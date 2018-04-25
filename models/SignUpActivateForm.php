<?php
 
namespace app\models;
 
use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

use app\models\User;
 
/**
 * Sign Up activate form.
 */
class SignUpActivateForm extends Model
{
    /**
     * @var \app\models\User
     */
    private $_user;
 
    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Activate token cannot be blank.');
        }
        
        $this->_user = User::findByAuthKey($token);
 
        if (!$this->_user) {
            throw new InvalidParamException('Wrong activate token.');
        }
 
        parent::__construct($config);
    }

    /**
     * Returns a user object.
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Sends an email with a link, for congrats user.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'email' => $this->_user->email,
            'is_active' => User::STATUS_ACTIVE
        ]);
 
        if (!$user) {
            return false;
        }
  
        return \Yii::$app
            ->mailer
            ->compose(
                ['html' => 'signUpCongratulations-html', 'text' => 'signUpCongratulations-text'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject(sprintf(Yii::t('yii', 'Congratulations, %s'), $user->username) . \Yii::$app->name)
            ->send();
    }
}