<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%notice_type}}".
 *
 * @property int $id
 * @property string $title
 * @property string $ident
 *
 * @property NoticeTypeUser[] $noticeTypeUsers
 * @property User[] $users
 */
class NoticeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notice_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'ident'], 'string', 'max' => 255],
            [['ident'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'ident' => Yii::t('app', 'Ident'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticeTypeUsers()
    {
        return $this->hasMany(NoticeTypeUser::className(), ['notice_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%notice_type_user}}', ['notice_type_id' => 'id']);
    }
}
