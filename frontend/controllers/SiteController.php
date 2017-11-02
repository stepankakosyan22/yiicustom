<?php

namespace frontend\controllers;

use app\models\Projects;
use app\models\Reports;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;
use yii\db\Query;
use yii\web\User;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\web\JsonParser;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
     * @inheritdoc
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
     * @return mixed
     */
    public function actionIndex()
    {
        $current_user_id = \Yii::$app->user->id;
        $customer_projects=(new Query())
            ->select('*')
            ->from('projects')
            ->where(['customer'=>$current_user_id])
            ->all();
        $customer_projects_worker=(new Query())
            ->select('*')
            ->from('project_worker')
            ->join('INNER JOIN','user','user.id=project_worker.id_worker')
            ->all();

        $customer_projects_worker_report=(new Query())
            ->select('*')
            ->from('reports')
            ->all();

        $user_datas = (new Query())
            ->select('*')
            ->from('user')
            ->where(['user.id' => $current_user_id])
            ->all();

        $user_projects = (new Query())
            ->select('*')
            ->from('project_worker')
            ->where(['id_worker' => $current_user_id])
            ->join('INNER JOIN', 'projects', 'project_worker.id_project = projects.id_project')
            ->all();


        $reports = (new \yii\db\Query())
            ->select('*')
            ->from('reports')
            ->where(['id_user' => $current_user_id])
            ->join('INNER JOIN', 'projects', 'projects.id_project = reports.id_project')
            ->all();
        return $this->render('index', [
            'reports' => $reports,
            'user_datas' => $user_datas,
            'user_projects' => $user_projects,
            'customer_projects' => $customer_projects,
            'customer_projects_worker' => $customer_projects_worker,
            'customer_projects_worker_report' => $customer_projects_worker_report,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            $imageName = $model->username;
            if (!empty($model->prof_image)) {
                $model->prof_image = UploadedFile::getInstance($model, 'prof_image');
                $model->prof_image->saveAs('uploads/users/' . $imageName . '.' . $model->prof_image->extension);
                $model->prof_image = 'uploads/users/' . $imageName . '.' . $model->prof_image->extension;
            }
            if ($user = $model->signup()) {
               $model->position=$user->position;
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }


        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionValidation()
    {
        $model = new SignupForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }


    public function actionProject()
    {
        $project = Projects::find()->where(['id_project' => Yii::$app->request->get()['id_project']])->one();
        return $this->render('/site/project', [
            'project' => $project,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
