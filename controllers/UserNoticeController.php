<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii2mod\rbac\filters\AccessControl;

use app\models\NoticeType;
use app\models\NoticeTypeUser;
use yii\data\SqlDataProvider;

class UserNoticeController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'status' => ['post'],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        // Build query for fetch actual values of notices options.
        $query = NoticeType::find()
                    ->select(['{{%notice_type}}.*', 'is_selected' => '{{%notice_type_user}}.notice_type_id'])
                    ->joinWith(['noticeTypeUsers' => function($query) {
                            $query->onCondition([ '{{%notice_type_user}}.user_id' => \Yii::$app->user->identity->id ]);
                        }
                    ]);

        // Define a data provider.
        $dataProvider = new SqlDataProvider([
            'sql' => $query->createCommand()->getRawSql()
        ]);

        // Processing pjax call.
        if (Yii::$app->getRequest()->getIsPjax()) {
            return $this->renderPartial('index', [
                'dataProvider' => $dataProvider
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionStatus($id)
    {
        // Check for assigned type already.
        $assigned = NoticeTypeUser::find()
                    ->innerJoinWith('noticeType')
                    ->where([
                        'notice_type_id' => (int) $id,
                        'user_id' => \Yii::$app->user->identity->id
                    ])
                    ->one();

        $ret = null;

        if ($assigned) {
            $ret = $assigned->delete();
        }
        else {
            $assigned = new NoticeTypeUser();
            $assigned->notice_type_id = $id;
            $assigned->user_id = \Yii::$app->user->identity->id;
            $assigned->created_at = time();
            
            $ret = $assigned->save();
        }

        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => Response::FORMAT_JSON,
            'data' => [ 'result'   => (int) $ret ]
        ]);
    }
}
