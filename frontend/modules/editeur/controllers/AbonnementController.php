<?php

namespace frontend\modules\editeur\controllers;

use Yii;
use frontend\modules\editeur\models\Abonnement;
use frontend\modules\editeur\models\TypeAbonnement;
use frontend\modules\editeur\models\AbonnementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * AbonnementController implements the CRUD actions for Abonnement model.
 */
class AbonnementController extends Controller
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
        ];
    }

    /**
     * Lists all Abonnement models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = $dataProvider = new ActiveDataProvider([
            'query' => Abonnement::find()->where(['editeurId'=>Yii::$app->user->identity->id]),
        ]); 

        $this->layout = 'main_';
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Abonnement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'main_';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Abonnement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Abonnement();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->editeurId = Yii::$app->user->identity->id;
           // $model->type_abonnementId = Yii::$app->user->identity->type_abonnementId;
            $model->etat = Abonnement::STATUS_ACTIVE;

            if($model->save()){
                Yii::$app->session->setFlash('success', 'Soucription effectuée avec succès.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Echec de souscription...');
                //print_r($model->getErrors()); exit;
            }
            
        }
           
        $this->layout = 'main_';
        return $this->render('create', [
            'model' => $model,
                //'typeabonnements' => $TypeAbonnement,
        ]);
    }

    /**
     * Updates an existing Abonnement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->layout = 'main_';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Abonnement model.
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
     * Finds the Abonnement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Abonnement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Abonnement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
