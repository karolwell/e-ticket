<?php

namespace frontend\modules\editeur\controllers;

use Yii;
use frontend\modules\editeur\models\CategorieActivite;
use frontend\modules\editeur\models\Activite;
use frontend\modules\editeur\models\ActiviteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * ActiviteController implements the CRUD actions for Activite model.
 */
class ActiviteController extends Controller
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
     * Lists all Activite models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = $dataProvider = new ActiveDataProvider([
            'query' => Activite::find()->where(['editeurId'=>Yii::$app->user->identity->id]),
            ]); 

        //print_r($dataProvider); exit;
        $this->layout = 'main_';
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Activite model.
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
     * Creates a new Activite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activite();
        $categorieactivites = CategorieActivite::find(['etat'=>CategorieActivite::STATUS_ACTIVE])->all();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if($model->imageFile){

                $model->image=$model->imageFile->name;
                $model->reference = Yii::$app->security->generateRandomString(16);
                $model->editeurId = Yii::$app->user->identity->id;
                $model->created_by = Yii::$app->user->identity->id;
                $model->date_create = date("Y-m-d H:i:s");
                $model->etat = Activite::STATUS_ACTIVE;

                if($model->upload()){

                    if($model->save()){
                        Yii::$app->session->setFlash('success', 'L\'activité est crée avec succès');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }else{
                        Yii::$app->session->setFlash('error', 'Echec de création de l\'activité');
                    }
                }else{
                    print_r($model->getErrors());

                    Yii::$app->session->setFlash('error', 'Echec de chargement de l\'image');
                }
            }else{
                Yii::$app->session->setFlash('error', 'Echec, Enregistement non effectué');
            }

        }  

        $this->layout = 'main_';       
        return $this->render('create', [
            'model' => $model,
            'categorieactivites' => $categorieactivites,
            ]);
    }

    /**
     * Updates an existing Activite model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categorieactivites = CategorieActivite::find(['etat'=>CategorieActivite::STATUS_ACTIVE])->all();

        
        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if($model->imageFile){

                $model->image=$model->imageFile->name;
                //$model->reference = Yii::$app->security->generateRandomString(16);
                $model->editeurId = Yii::$app->user->identity->id;
                $model->created_by = Yii::$app->user->identity->id;
                $model->date_create = date("Y-m-d H:i:s");
                $model->etat = Activite::STATUS_ACTIVE;

                if($model->upload()){

                    if($model->save()){
                        Yii::$app->session->setFlash('success', 'L\'activité est mise à jour avec succès');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }else{
                        //print_r($model->getErrors());
                        Yii::$app->session->setFlash('error', 'Echec de création de l\'activité');
                    }
                }else{

                    Yii::$app->session->setFlash('error', 'Echec de chargement de l\'image');
                }
            }else{

                if($model->save()){
                    Yii::$app->session->setFlash('success', 'L\'activité est mise à jour avec succès');
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                        //print_r($model->getErrors());

                }

            }

        }
        $this->layout = 'main_';
        return $this->render('update', [
            'model' => $model,
            'categorieactivites' => $categorieactivites,
            ]);
        
    }

    /**
     * Deletes an existing Activite model.
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
     * Finds the Activite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activite::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
