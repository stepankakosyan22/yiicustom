<?php


namespace frontend\controllers;

use app\models\Projects;
use backend\models\ProjectWorker;
use Yii;
use app\models\Reports;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\filters\AccessControl;

/**
 * ReportsController implements the CRUD actions for Reports model.
 */
class ReportsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update'],
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Reports models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current_id=\Yii::$app->user->id;
        $reports = (new \yii\db\Query())
            ->select('*')
            ->from('reports')
            ->where(['id_user' =>$current_id])
            ->join('INNER JOIN', 'projects', 'projects.id_project = reports.id_project')
        ->orderBy(['report_day'=>SORT_DESC]);
        $pagination=new Pagination([
            'defaultPageSize' => 15,
            'totalCount'=>$reports->count()
        ]);
        $reports=$reports->offset($pagination->offset)->limit($pagination->limit)->all();

        $dataProvider = new ActiveDataProvider([
            'query' => Reports::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'reports' => $reports,
            'pagination'=>$pagination,
        ]);
    }

    /**
     * Displays a single Reports model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new Reports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reports();
        $model->scenario='create_report';

        if ($model->load(Yii::$app->request->post())) {
            $model->report_day = date('Y-m-d h:m:s');
            $model->id_user=\Yii::$app->user->id;
            if ($model->validate()){
                $model->save();
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model,]);
    }

    /**
     * Updates an existing Reports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if(substr($model->report_day,0,10)==date('Y-m-d')){
                $model->report_day = date('Y-m-d h:m:s');
                $model->save();
            }else{
                $this->redirect(['update', 'id' => $model->id_report]);
                return $model->addError('description',$error='You cannot edit past days reports!');
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Reports model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reports::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
