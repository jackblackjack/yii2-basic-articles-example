<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\rbac\filters\AccessControl;

use app\models\User;
use app\models\UserSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                        'permissions' => [ 'userManager' ],
                    ],
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {

            $model->setPassword(Yii::$app->getSecurity()->generateRandomString(6));
            $model->generateAuthKey();
            
            if ($model->save()) {
                $model->trigger(User::EVENT_CREATE_NEW);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // Processing ajax call.
        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // Processing ajax call.
        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /*

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
    */

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionStatus($id)
    {
        if (! ($model = User::findOne($id))) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested user does not exist.'));
        }

        // Change active status value.
        $model->is_active = !$model->is_active;
        $is_saved = $model->save();

        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => Response::FORMAT_JSON,
            'data' => [ 'result'   => (int) $is_saved ]
        ]);
    }
}
