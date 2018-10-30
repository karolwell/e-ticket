<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\Cors;
use yii\filters\auth\QueryParamAuth;
use Yii;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class FactureController extends ActiveController {

    public $modelClass = 'api\modules\v1\models\Facture';

    public function behaviors() {
        $behaviors = parent::behaviors();

        //suppression de l'authentification
        unset($behaviors['authenticator']);
        //ajout du cors
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];
        //ajout de l'authentification
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        //enlever de l'authentification et le cors sur les methodes applog et applogconfitmation
        $behaviors['authenticator']['except'] = ['allfirst', 'get'];
        return $behaviors;
    }

    public function actionGet() {
        $infos = Yii::$app->request->post();
         $client= $infos['refClient'];
         $mois = $infos['mois'];
         $factures = array();
         if($client == "A5"){
         array_push($factures, ['client'=>$client,'mois'=>$mois]);
         return [
             'status'=>'ok',
             'factures'=>$factures,
            ];
         }else{
              return [
             'status'=>'ko',
             'message'=>'no data',
            ];
         }
    }
    public function actionGet_date() {
        $infos = Yii::$app->request->post();
//         $datas = $infos['refClient'];
         $factures = array();
         setlocale(LC_TIME, 'RUS');
//         setlocale (LC_TIME, 'fr_FR.utf8','fra');
         for ($d = 1; $d <= 12; $d++) {
            $months[] = date("F Y", strtotime( date( 'Y-m-01' )." -$d months"));
        }
//        rsort($months);
//           for ($i = 0; $i < 12; $i++) {
//               $months[] =  date('F Y', strtotime("-$i month"));
//            }
//         return $months;
         return (array_reverse($months));
    }

}
