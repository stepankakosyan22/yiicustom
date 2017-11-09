<?php

namespace backend\controllers;

use backend\models\Projects;
use backend\models\ProjectWorker;
use backend\models\User;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use app\models\Reports;
use yii\data\Pagination;
use yii\data\SqlDataProvider;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['project'],
                        'allow' => true,
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $all_projects = Projects::find();
        $pagination=new Pagination([
            'defaultPageSize' => 6,
            'totalCount'=>$all_projects->count()
        ]);
        $all_projects=$all_projects->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'all_projects' => $all_projects,
            'pagination'=>$pagination
        ]);
    }

    /**
     * Project action.
     *
     * @return string
     */

    public function actionProject()
    {
        $project = Projects::find()
            ->where(['id_project' => Yii::$app->request->get()['id_project']])
            ->one();
        $reports = (new Query())
            ->select('*')
            ->from('reports')
            ->where(['id_project' => Yii::$app->request->get()['id_project']])
            ->orderBy(['report_day' => SORT_DESC])
            ->all();
        $workers_of_project = (new Query())
            ->select('*')
            ->from('projects')
            ->join('INNER JOIN', 'project_worker', 'projects.id_project=project_worker.id_project')
            ->join('INNER JOIN', 'user', 'project_worker.id_worker=user.id')
            ->where(['projects.id_project' => Yii::$app->request->get()['id_project']])
            ->all();
        $customer_name=User::find()->where(['position'=>'Customer'])->all();

        return $this->render('project', [
            'project' => $project,
            'workers_of_project' => $workers_of_project,
            'reports' => $reports,
            'customer_name'=>$customer_name
        ]);
    }

    /**
     * Login action.
     *
     * @return string
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
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
