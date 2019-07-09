<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\IndexForm;
use app\models\ProfileForm;
use app\models\User;
use app\models\SignupService;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    
    public function actionIndex()
    {
        $model = new IndexForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены
            $signupService = new SignupService();
            try{
                $user = $signupService->signup($model);
                Yii::$app->session->setFlash('success', 'Для завершения регистрации перейдите по ссылке в электронном письме.');
                $signupService->sendMail($user);
                return $this->goHome();
            } catch (\RuntimeException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->goHome();
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('index', ['model' => $model]);
        }
    }
    
    public function actionProfile()
    {
        $session = Yii::$app->session;
        $signupService = new SignupService();
        $model = new ProfileForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            switch (\Yii::$app->request->post('submitBtn')) {
                case 'save':
                    $model->updateUser();
                    $model->updateSession();
                    return $this->render('profile', ['model' => $model]);
                    break;
                case 'delete':
                    $model->deleteUser();
                    $session->destroy();
					return $this->goHome();
                    //$this->redirect('index.php');
                    break;
            }
        } else {
            if ($session->isActive && $session['status'] == 10) {
                $model = $signupService->initFromSession();
            } else {
                $token = Yii::$app->request->get('token');
                if (!empty($token)) {
                    $model = $signupService->confirmation($token);
                    return $this->render('profile', ['model' => $model]);
                }
            }
            return $this->render('profile', ['model' => $model]);
        }
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
}