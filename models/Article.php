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
     * Event for fire when created and active.
     * @var string
     */ 
    const EVENT_NEW_AND_ACTIVE = 'EVENT_ARTICLE_NEW_AND_ACTIVE';
    
    /**
     * Event for fire when activated model.
     * @var string
     */ 
    const EVENT_ACTIVATE = 'EVENT_ARTICLE_ACTIVATE';

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

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        // Call parent method.
        parent::afterSave($insert, $changedAttributes);

        // Fire events.
        if ($insert) {
            if ($this->is_active) {
                $this->trigger(static::EVENT_NEW_AND_ACTIVE);
            }
        }
        else if (isset($changedAttributes['is_active']) && (bool) $changedAttributes['is_active']) {
            $this->trigger(static::EVENT_ACTIVATE);
        }
    }
}
