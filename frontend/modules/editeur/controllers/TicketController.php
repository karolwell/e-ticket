<?php

namespace frontend\modules\editeur\controllers;

use Yii;
use yii\db\Query;
use frontend\modules\editeur\models\Ticket;
use frontend\modules\editeur\models\TypeTicket;
use frontend\modules\editeur\models\Activite;
use frontend\modules\editeur\models\Validite;
use frontend\modules\editeur\models\TicketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\UploadedFile;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
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
/*    public function actionIndex()
    {
        //$searchModel = new TicketSearch();
        $dataProvider = null;
        $query = new Query();
        $dataProvider =  new ActiveDataProvider([
            'query' => $query->select(['t.*'])
            ->from(['user u','type_ticket tk','ticket t'])
            ->where('tk.created_by=u.id and tk.id=t.type_ticketId')
            ->andwhere(['u.id'=>Yii::$app->user->identity->id]),
            'pagination' => [
                    'pageSize' => 20,
            ],
        ]); 
        //print_r($dataProvider->getModels());exit;

        $this->layout = 'main_';
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $activiteIds=Activite::find()->select(['id'])->where(['editeurId'=>Yii::$app->user->identity->id]);
        //print_r($activiteIds); exit;
        $dataProvider = $dataProvider = new ActiveDataProvider([
            'query' => Ticket::find()->where(['activiteId'=>$activiteIds]),
        ]); 

        //print_r($dataProvider); exit;
        $this->layout = 'main_';
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
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
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ticket();

        //$typetickets = TypeTicket::find(['etat'=>1,'editeurId'=>Yii::$app->user->identity->id])->all();
        $activites = Activite::find(['etat'=>1])->all();
        $validites = Validite::find(['etat'=>1])->all();
        $model->setScenario('create');

        if ($model->load(Yii::$app->request->post())) {

            //$type_ticketId = explode('-',Yii::$app->request->post()['type_ticketId'])[0];
            $activiteId = explode('-',Yii::$app->request->post()['activiteId'])[0];
            $validiteId = explode('-',Yii::$app->request->post()['validiteId'])[0];

            //print_r($activiteId);exit;

            $ticket = $model->find()->where(['activiteId'=>$activiteId,/*'type_ticketId'=>$type_ticketId*/'validiteId'=>$validiteId,
              'designation'=>$model->designation,'prix'=>$model->prix,'nombre_validation'=>$model->nombre_validation,'periode'=>$model->periode,
              'duree_validite'=>$model->duree_validite
          ])->one();

            if($ticket==null){

                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->activiteId = $activiteId;
                //$model->type_ticketId = $type_ticketId;
                $model->validiteId = $validiteId;

                if($model->imageFile){

                    $model->image=$model->imageFile->name;
                    if ($model->upload()) {

                        if ($model->save()) {

                            Yii::$app->session->setFlash('success', 'Le ticket est ajouté avec succès');
                        }else{
                        //print_r($model->getErrors());
                            Yii::$app->session->setFlash('error', 'Echec de création de du ticket');
                        }

                    }else{
                        Yii::$app->session->setFlash('error', 'L\' image du ticket n\'est pas chargé');
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'L\' image du ticket n\'est pas chargé');
                }




            }else{
                Yii::$app->session->setFlash('error', 'Ce ticket existe déjà');
            }

        }

        $this->layout = 'main_';
        return $this->render('create', [
            'model' => $model,
            'activites' => $activites,
            'validites' => $validites,
            //'typetickets' => $typetickets,
        ]);
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //$typetickets = TypeTicket::find(['etat'=>1,'editeurId'=>Yii::$app->user->identity->id])->all();
        $activites = Activite::find(['etat'=>1])->all();
        $validites = Validite::find(['etat'=>1])->all();


        if ($model->load(Yii::$app->request->post())) {

            $activiteId = explode('-',Yii::$app->request->post()['activiteId'])[0];
            $type_ticketId = explode('-',Yii::$app->request->post()['type_ticketId'])[0];
            $validiteId = explode('-',Yii::$app->request->post()['validiteId'])[0];


            //$model->type_ticketId = $type_ticketId;
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->activiteId = $activiteId;
            $model->validiteId = $validiteId;

            if($model->imageFile){

                $model->image=$model->imageFile->name;
                if ($model->upload()) {

                    if ($model->save()) {

                        Yii::$app->session->setFlash('success', 'La mise à jour du ticket est efectuée avec succès');
                    }else{
                        //print_r($model->getErrors());
                        Yii::$app->session->setFlash('error', 'Echec de mise à jour  du ticket');
                    }

                }else{
                    Yii::$app->session->setFlash('error', 'L\' image du ticket n\'est pas chargé');
                }
            }else{
                if ($model->save()) {

                    Yii::$app->session->setFlash('success', 'La mise à jour du ticket est efectuée avec succès');
                }else{
                        //print_r($model->getErrors());
                    Yii::$app->session->setFlash('error', 'Echec de mise à jour  du ticket');
                }
            }

        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        }

        $this->layout = 'main_';
        return $this->render('update', [
            'model' => $model,
            'activites' => $activites,
            'validites' => $validites,
            // 'typetickets' => $typetickets,
        ]);
    }

    /**
     * Deletes an existing Ticket model.
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
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
