<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%notice_type_user}}".
 *
 * @property int $notice_type_id
 * @property int $user_id
 * @property int $created_at
 *
 * @property NoticeType $noticeType
 * @property User $user
 */
class NoticeTypeUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notice_type_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_type_id', 'user_id', 'created_at'], 'required'],
            [['notice_type_id', 'user_id', 'created_at'], 'integer'],
            [['notice_type_id', 'user_id'], 'unique', 'targetAttribute' => ['notice_type_id', 'user_id']],
            [['notice_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => NoticeType::className(), 'targetAttribute' => ['notice_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_type_id' => Yii::t('app', 'Notice Type ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticeType()
    {
        return $this->hasOne(NoticeType::className(), ['id' => 'notice_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
