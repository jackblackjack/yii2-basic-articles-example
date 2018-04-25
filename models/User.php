<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\NotFoundHttpException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'is_active' ], 'default', 'value' => 0],
            [ [ 'is_active' ], 'in', 'range' => [0, 1]],
            [ ['username', 'email'], 'required' ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function afterSave($is_insert, $changedAttributes)
    {
        if ($is_insert) {
            // Fetch a default role name for new registered user.
            $roleName = \Yii::$app->params['rbac.roleOnRegister'];       
            $roleModel = \Yii::$app->authManager->getRole($roleName);
            
            if (! $roleModel) {
                throw new NotFoundHttpException(sprintf(Yii::t('app', 'Role %s is not found'), $roleName));
            }

            // Assign new registered user to default role name. 
            \Yii::$app->authManager->assign($roleModel, $this->attributes['id']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by auth key.
     *
     * @param [string] $key
     * @return static|null
     */
    public static function findByAuthKey($key)
    {    
        return static::findOne([
            'auth_key' => $key
        ]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by username or email
     *
     * @param string $username_or_email
     * @return static|null
     */
    public static function findByUsernameOrEmail($username_or_email)
    {
        return static::find()->where(['OR', ['username' => $username_or_email], ['email' => $username_or_email]])->one(); 
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        return $this;
    }
 
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
        return $this;
    }

    /**
     * Finds user by password reset token.
     *
     * @param [string] $token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
     
        return static::findOne([
            'password_reset_token' => $token,
            'is_active' => self::STATUS_ACTIVE,
        ]);
    }
     
    /**
     * Check for password reset token is valid.
     *
     * @param [string] $token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
     
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
     
    /**
     * Generates new password reset token and store it into model.
     * @return null
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        return $this;
    }
     
    /**
     * Clean up exists password reset token into model.
     * @return null
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
        return $this;
    }

    /**
     * Sets a value for activity status attribute.
     *
     * @param mixed $val
     */
    public function setActive($val)
    {
        $this->is_active = (int) $val;
        return $this;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getGroup()
    {
        /*
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('post_tag', ['post_id' => 'id']);
        */
    }
}
