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
class TmoneyController extends ActiveController {

    public $modelClass = 'api\modules\v1\models\Tmoney';

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
        $behaviors['authenticator']['except'] = ['allfirst', 'get_pays_regions'];
        return $behaviors;
    }

    public function actionGet_user_solde() {
        if (Yii::$app->request->get()) {
            $infos = Yii::$app->request->get();
            if (isset($_GET['numero']) && isset($_GET['montant'])) {
                $find_user = \api\modules\v1\models\Tmoney::findOne(['numero_payeur' => $infos['numero']]);
                if (sizeof($find_user) > 0) {
//                    print_r((int) $infos['montant']);exit;
//                     if () {
                    if ((int) $find_user->solde >= (int) $infos['montant'] && (int) $find_user->solde > 0) {
                        $solde = (int) $find_user->solde - (int) $infos['montant'];
                        $find_user->solde = (string) ($solde);
                        if ($find_user->save()) {
                            return [
                                'status' => 'ok',
                                'message' => 'Transaction bien éffectuée!'
                            ];
                        } else {
                            return [
                                'status' => 'ko',
                                'message' => 'Veuillez creer un compte Tmoney !'
                            ];
                        }
                    } else {
                        return [
                            'status' => 'ko',
                            'message' => 'Montant insuffisant!'
                        ];
                    }
//                    } else {
//                            return [
//                                'status' => 'ko',
//                                'message' => 'Montant inssufisant!'
//                            ];
//                        }
                } else {
                    return [
                        'status' => 'ko',
                        'message' => 'Veuillez creer un compte Tmoney !'
                    ];
                }
            } else {
                return [
                    'status' => 'ko',
                    'message' => 'Reesayez plutart!!!'
                ];
            }
        } else {
            return [
                'status' => 'ko',
                'message' => 'Reesayez plutart!!!'
            ];
        }
    }

}
