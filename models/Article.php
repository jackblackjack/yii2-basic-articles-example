<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Model;
use yii\db\Expression;

use app\models\User;
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
     * {@inheritDoc}
     */
    public function init()
    {
        $this->on(static::EVENT_NEW_AND_ACTIVE, [ $this, 'updateNotices' ]);
        $this->on(static::EVENT_ACTIVATE, [ $this, 'updateNotices' ]);
    }

    /**
     * {@inheritDoc}
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [ [ 'is_active' ], 'default', 'value' => 0],
            [ [ 'is_active' ], 'in', 'range' => [0, 1]],
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
    public function getReaders()
    {
        return $this->hasMany(User::className(), [ 'id' => 'user_id' ])->via('readingArticles');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReadingArticles()
    {
        return $this->hasMany(ArticleUser::className(), ['article_id' => 'id'], null, ['is_readed']);
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
        else if (isset($changedAttributes['is_active']) && ! $changedAttributes['is_active']) {
            $this->trigger(static::EVENT_ACTIVATE);
        }
    }

    /**
     * Update notices for active accounts.
     * @return void
     */
    public function updateNotices()
    {
        // Fetch a list of users whos has not notice about article.
        $ar_unnoticed = User::find()
                            ->leftJoin('{{%article_user}}', 
                                            '{{%user}}.id = {{%article_user}}.user_id AND ' .
                                            sprintf('{{%%article_user}}.article_id = %d', $this->id)
                                        )
                            ->andWhere(['IS', '{{%article_user}}.user_id', (new Expression('NULL'))])
                            //->andWhere(['IS NOT', '{{%article_user}}.is_readed', (new Expression('NULL'))])
                            ->andWhere(['=', '{{%user}}.is_active', User::STATUS_ACTIVE])
                            ->andWhere(['<>','{{%user}}.id', \Yii::$app->user->getId()])
                            ->all();

        foreach ($ar_unnoticed as $account) {
            //$this->link('readers', $account, ['is_readed' => 1]);
            $this->link('readers', $account, ['is_readed' => 1]);
        }
    }
}
