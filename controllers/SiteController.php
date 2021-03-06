<?php

namespace app\controllers;

use Yii;
use yii2mod\rbac\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\User;
use app\models\Article;
use app\models\ArticleSearch;

use app\models\SignUpForm;
use app\models\SignUpActivateForm;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ResetPasswordForm;
use app\models\PasswordResetRequestForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'sign-up'],
                'rules' => [
                    [
                        'actions' => ['sign-up'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();

        // Build data provider.
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere([ '=', 'is_active', Article::STATUS_ACTIVE ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Sign up action.
     *
     * @return Response|string
     */
    public function actionSignUp()
    {
        $model = new SignUpForm();

        if ($model->load(\Yii::$app->request->post())) {
            
            if ($user = $model->signup()) {
                
                if ($user->sendActivateEmail()) {
                    \Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                    return $this->goHome();
                }
                else {
                    \Yii::$app->session->setFlash('error', 'Sorry, we are unable to sign up for email provided.');
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Existing sign up activation action.
     *
     * @return Response|string
     */
    public function actionSignUpActivate($token)
    {
        try {
            $model = new SignUpActivateForm($token);
        } 
        catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->validate()) {

            // Update user properties.
            $model->getUser()->setActive(true)->generateAuthKey();

            // Try to save user properties.
            if (! $model->getUser()->save() ) {
                Yii::$app->session->setFlash('error', 
                    Yii::t('yii', 'Sorry, error while update user.')
                );
            }

            // Try to send email.
            if (! $model->sendEmail()) {
                Yii::$app->session->setFlash('error', 
                    Yii::t('yii', 'Sorry, we are unable to sign up for email provided.')
                );
            }
            else {
                // Send congrats notice.
                Yii::$app->session->setFlash('success', 
                    sprintf(Yii::t('yii', 'Welcome, %s!'), $model->getUser()->username)
                );
            }
        } 
        else {
                
            // Send notice about error.
            Yii::$app->session->setFlash('error', 
                Yii::t('yii', 'Sorry, account is not validated.')
            );
        }

        return $this->goHome();
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displa\Ys contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(\Yii::$app->request->post()) && $model->contact(\Yii::$app->params['adminEmail'])) {
            \Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displa\Ys about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
 
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                \Yii::$app->session->setFlash('success', 'Check \Your email for further instructions.');
                return $this->goHome();
            } else {
                \Yii::$app->session->setFlash('error', 'Sorr\Y, we are unable to reset password for email provided.');
            }
        }
 
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
 
        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            \Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }
 
        return $this->render('resetPassword', [
            'model' => $model
        ]);
    }
}
