<?php
namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Session;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\TypeUser;
use frontend\models\TypeAbonnement;
use frontend\modules\editeur\models\Activite;
use frontend\modules\editeur\models\Achat;
use frontend\modules\editeur\models\AchatDetails;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                        'actions' => ['signup','logout'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['ussd','send_reponse','ajouter_panier','retirer_panier','panier'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
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

    public function ckeckTicket($ticket){

        $valide = $ticket->validite->mot_cle;
        
        $etat='ko';
        $reste=-1;
        $tab_etat=[];
        if($ticket->nombre_ticket!=null){

            $achat=AchatDetails::find()->where(['ticketId'=>$ticket->id])->all();
            $tot_achat = count($achat);
            $reste = (int)$ticket->nombre_ticket - $tot_achat;

            if($tot_achat<$ticket->nombre_ticket)$etat='ok';

            $tab_etat=['etat'=>$etat,'reste'=>$reste];
        }else{
            $etat='ok';
            $tab_etat=['etat'=>$etat,'reste'=>$reste];
        }
        return $tab_etat;

    }

    public function actionIndex()
    {
        /*if (!\Yii::$app->user->isGuest and (TypeUser::findOne(Yii::$app->user->identity->type_userId)->designation=="editeur")) {
            return $this->redirect(['editeur/bord/index']);
        }else{
            return $this->render('index');
        }*/


        $session = new Session;
        $session->open();
        $date = date('Y-m-d');

        //print_r($date); exit;

        $activites = Activite::find()
        ->where("etat=".Activite::STATUS_ACTIVE." AND  (datefin >= '".$date."' OR datefin = '0000-00-00')")
        ->all();

        $tickets = [];
        foreach ($activites as $key => $activite) {
            
            foreach ($activite->tickets as $key => $ticket) {

             $disponible = $this->ckeckTicket($ticket);
             //print_r($ticket); exit;
             array_push($tickets, [
                'etat_panier'=>0,
                'compte_panier'=>0,
                'disponible'=>$disponible['etat'],
                'reste'=>$disponible['reste'],
                'ticket'=>$ticket,
                'editeur'=>$activite->editeur,
                'activite'=>$activite,
                'categorie'=>$activite->categorieActivite,
                'typeticket'=>$ticket->typeTicket,
            ]);
         }
     }
     //unset($session['all']);exit;
     if(isset($session['all'])){

        $tickets = $session['all'];

    }else{

        $session['all'] = $tickets;

    }

    //print_r($session['all']);exit;
    
    $dataProvider =  new ArrayDataProvider([
        'allModels' => $tickets,
    ]); 

       //print_r($tickets[0]);exit;

    return $this->render('index', [
            //'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);

}

public function actionMon_panier(){

    $session = new Session;
    $session->open();
    $ticket_sessions = $session['all'];


        $tot_nombre=0; $tot_prix=0; $nombre=0;
        foreach ($ticket_sessions as $ticket_session) {
          if($ticket_session['etat_panier']==1){
            $nombre += 1;
            $tot_nombre += $ticket_session['compte_panier'];
            $tot_prix += $ticket_session['compte_panier']*$ticket_session['ticket']->prix;
        }
    }

    return $this->render('panier', [
        'tickets' => $ticket_sessions,
        'total' => $tot_prix,
        'tot_nombre' => $tot_nombre,
        'nombre' => $nombre,
    ]);

}


function actionAjouter_panier(){

    $session = new Session;
    $session->open();

    $tickets = $session['all'];
    $panier = array();

    //$this->layout = false;
    if(Yii::$app->request->isAjax){

        $datas = yii::$app->request->post('input');

        if(isset($datas['ticket'])){
            $panier[$datas['ticket']]=$tickets[$datas['ticket']];
            $tickets[$datas['ticket']]['etat_panier']=1;
            $tickets[$datas['ticket']]['compte_panier']=$datas['nombre'];
            $session['all'] = $tickets;
        }else{
            $panier[$datas['ticket']]=$tickets[$datas['ticket']];
            $tickets[$datas['ticket']]['etat_panier']=0;
            $tickets[$datas['ticket']]['compte_panier']=0;
            $session['all'] = $tickets;
        }

        //print_r($tickets);exit;
       // print_r($tickets[$datas['ticket']]);exit;
        if($panier[$datas['ticket']]){
            return 'ok';
        }else{
            return 'ko';
        }
    }
}



function actionRetirer_panier(){

    $session = new Session;
    $session->open();

    $tickets = $session['all'];
    $panier = array();

    //$this->layout = false;
    if(Yii::$app->request->isAjax){

        $datas = yii::$app->request->post('input');


        if(isset($datas['ticket'])){
            $panier[$datas['ticket']]=0;
            $tickets[$datas['ticket']]['etat_panier']=0;
            $tickets[$datas['ticket']]['compte_panier']=0;
            $session['all'] = $tickets;
        }

       // print_r($tickets[$datas['ticket']]);exit;
        if($panier[$datas['ticket']]==0){
            return 'ok';
        }else{
            return 'ko';
        }
    }
}


public function actionPanier(){

    $session = new Session;
    $session->open();
    $ticket_sessions = $session['all'];

    if(Yii::$app->request->isAjax){

        $tot_nombre=0; $tot_prix=0; $nombre=0;
        foreach ($ticket_sessions as $ticket_session) {
          if($ticket_session['etat_panier']==1){
            $nombre += 1;
            $tot_nombre += $ticket_session['compte_panier'];
            $tot_prix += $ticket_session['compte_panier']*$ticket_session['ticket']->prix;
        }
    }

    $this->layout =false;
    return $this->render('_panier', [
        'tickets' => $ticket_sessions,
        'total' => $tot_prix,
        'nombre' => $nombre,
    ]);
}

}


public function actionLogin()
{
    if (!\Yii::$app->user->isGuest) {
        return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
        if(TypeUser::findOne(Yii::$app->user->identity->type_userId )->designation=="editeur"){

         return $this->redirect(['editeur/bord/index']);

     }else{
        return $this->goBack();
    }

} else {
    return $this->render('login', [
        'model' => $model,
    ]);
}
}

public function actionLogout()
{
    Yii::$app->user->logout();

    $this->redirect(["site/index"]);
}

public function actionContact()
{
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
        } else {
            Yii::$app->session->setFlash('error', 'There was an error sending email.');
        }

        return $this->refresh();
    } else {
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
}

public function actionAbout()
{
    return $this->render('about');
}

public function actionSignup()
{ 
    $typeuser = new TypeUser();
    $typeabonnement = new TypeAbonnement();

    $typeusers = $typeuser->find(['designation'=>'<> admin'])->all();
    $typeabonnements = $typeabonnement->find()->all();

    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post())) {
        $select= Yii::$app->request->post()['type_userId'];

        $type_user = TypeUser::find()->where(['designation'=>$select])->one();

        $model->type_userId = $type_user->id;
        if($type_user->designation=="editeur"){

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->logo=$model->imageFile->name;
            if ($model->upload()) {
                if ($user = $model->signup()) {

                    if (Yii::$app->getUser()->login($user)) {
                            //return $this->goHome();
                     return $this->redirect(['editeur/index']);
                 }
             }
         }else{
            Yii::$app->session->setFlash('error', 'Le logo n\'est pas chargé');
        }

    }else{
        if ($user = $model->signup()) {

            if (Yii::$app->getUser()->login($user)) {

                if($type_user->designation=="facturier"){
                    Yii::$app->session->setFlash('info', 'Veuillez terminer l\'inscription en configurant vos paramètres');
                    return $this->redirect(['editeur/ProtocoleFacturier/create']);
                }else{
                   return $this->goHome();
               }

           }
       }
   }

}

return $this->render('signup', [
    'model' => $model,
    'typeusers' => $typeusers,
    'typeabonnements' => $typeabonnements,
]);
}

public function actionRequestPasswordReset()
{
    $model = new PasswordResetRequestForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ($model->sendEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

            return $this->goHome();
        } else {
            Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
        }
    }

    return $this->render('requestPasswordResetToken', [
        'model' => $model,
    ]);
}

public function actionResetPassword($token)
{
    try {
        $model = new ResetPasswordForm($token);
    } catch (InvalidParamException $e) {
        throw new BadRequestHttpException($e->getMessage());
    }

    if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
        Yii::$app->getSession()->setFlash('success', 'New password was saved.');

        return $this->goHome();
    }

    return $this->render('resetPassword', [
        'model' => $model,
    ]);
}


public function actionUssd(){
	

  $session = Yii::$app->session;

  if(isset($_POST['send']))
  {	
     $session->set('user_mobile', $_POST['phone_number']);
     $session->set('user_first_name', "GABIAM");
     $session->set('user_last_name', "Folly Bernard");
     $session->set('transaction_id', rand(1234,5678));

     $session->set('status', "READY");

			//envoie de la premiere commande pour initialiser loperation
 }else{
     $session->set('status', "NOREADY");

 }		



 $this->layout ="/main_ussd";
 return $this->render('ussd');
}

public function actionSend_reponse(){
  if(Yii::$app->request->isPost){
//                    return 1;
    $info=Yii::$app->request->post();				
    $response=urldecode($info['response']);

//                                return $response;
    $session = Yii::$app->session;


    if($session->has('status')){
       $status=$session->get("status");

       if($response=="*8686#"){					
          $type="PREAUTH";						
      }else{					
          $type="TRANSACTION";						
      }
      $base_url=explode("/frontend",Yii::$app->homeUrl)[0];

//					$url_api = "http://".$_SERVER['HTTP_HOST'].$base_url."/api/web/v1/ussds/getdatatest";
      $url_api = "http://e-tikets.online/e-ticket/api/web/v1/ussds/getdatatest";

//                                        print_r($url_api);exit;

      $ch = curl_init();
      $curlConfig = array(
         CURLOPT_URL            => $url_api,
         CURLOPT_POST           => true,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_CONNECTTIMEOUT => 5,
         CURLOPT_POSTFIELDS     => array(
          'user_first_name' => $session->get("user_first_name"),
          'transaction_id' => $session->get("transaction_id"),
          'user_last_name' => $session->get("user_last_name"),
          'user_mobile' => $session->get("user_mobile"),
          'response' => $response,
          'type' => $type,
      ),
     );
      curl_setopt_array($ch, $curlConfig);
      $result = curl_exec($ch);
      curl_close($ch);

//                                        var_dump($result);exit;

      echo str_replace("\n","<br/>",$result);	
  }else{
   echo \Yii::t('app', 'RESTART_TEST');
}

}

}
}
