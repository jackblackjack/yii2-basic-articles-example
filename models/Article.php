<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Model;

class Article extends ActiveRecord
{    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['title', 'preview_data', 'full_data'], 'required' ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), [ 'id' => 'user_id' ])
                        ->viaTable(ArticleUser::tableName(), [ 'user_id' => 'id' ]);
    }
}
