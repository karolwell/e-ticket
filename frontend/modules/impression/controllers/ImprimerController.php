<?php

namespace frontend\modules\impression\controllers;

use Yii;

use frontend\modules\impression\models\Ticket;
use frontend\modules\impression\models\Achat;
use frontend\modules\impression\models\AchatDetails;
use yii\web\Controller;

/**
 * Default controller for the `impression` module
 */
class ImprimerController extends Controller
{

	public function beforeAction($action)
	{
		if (in_array($action->id, ['index','search'])) {
			$this->enableCsrfValidation = false;
		}
		return parent::beforeAction($action); 
	} 

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	Yii::$app->session->setFlash('info', 'Veuillez entrer le code achat et le code ticket pour imprimer votre ticket');
    	$this->layout = 'main_';

    	return $this->render('index');
    }


    public function actionSearch()
    {
        sleep(1.5);
        $results = array();
    	if(yii::$app->request->isAjax){
    		$datas = yii::$app->request->post('input');
    		$code = $datas['codes'];
    		$this->layout = false;
            if($code){

                if(is_numeric($code)){
                    $achat_detail=AchatDetails::find()->where(['code'=>$code,'etat'=>1])->one();
                    $results=array();
                    if($achat_detail!==null){

                        $results['ticket']=$achat_detail;
                    }

                }else{

                    $achat=Achat::find()->where(['code_facture'=>$code,'etat'=>1])->one();
                    $achat_details=AchatDetails::find()->where(['achatId'=>$achat->id,'etat'=>0])->all();
                    foreach ($achat_details as $achat_detail) {
                        $results['tickets'][$achat_detail->code]=Ticket::find()->where(['id'=>$achat_detail->ticketId])->one();
                    }
    			}
                //print_r($results);exit;
    			return $this->render('_result',[
    				'results'=>$results,
    			]);
    		}else{

    			$alerte = "<div class='alert alert-danger'> Veuillez saisir le code s'il vous plait ... </div>";
    			return $alerte;
    		}
    	}
    }
}
