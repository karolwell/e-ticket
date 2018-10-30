<?php

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use api\modules\v1\models\Users;

class UsersController extends ActiveController
{
	public $modelClass = 'api\modules\v1\models\Users'; 

	public function actionUsers($id=null){

		if(is_null($id)){


			$users = Users::find()->all();

			if(!empty($users)){

				$datas = [
				'id'=>$id,
				'status'=>'ok',
				'message'=>'Ci-après la liste des utilisateurs',
				'users'=>$users
				];

			}else{

				$datas = [
				'id'=>$id,
				'status'=>'ko',
				'message'=>'Aucun utilisateur disponible, veuillez enrégisteur un nouvel utilisateur.',
				];
			}

		}else{

			$user = Users::findOne(['id'=>$id]);

			if(!empty($user)){

				$datas = [
				'id'=>$id,
				'status'=>'ok',
				'message'=>'Ci-après l\'ulilisateur demandé',
				'users'=>$user
				];
			}else{

				$datas = [
				'id'=>$id,
				'status'=>'ko',
				'message'=>'Aucun l\'utilisateur demandé n\'est pas disponible',
				];
			}
		}

		return $datas; 

	}

	public function actionAdd(){

		$model = new users();

		if(Yii::$app->request->get()){

			$param = Yii::$app->request->get();
/*            print_r($param);exit;
            $model->name = $param['name'];
            $model->email = $param['email'];*/
            $datas = null;
            foreach ($param as $key => $value) {

            	if(!$value){


            		$datas = [
            		'status'=>'ko',
            		'message'=>'Tous les champs sont obligatoires'
            		];break;

            	}else{
            		$model->$key = urldecode($value);
            	}
            	
            }

            if(!$datas){

            	$exist=$model->findOne(['email'=>$model->email,'name'=>$model->name]);

            	if(!$exist){

            		if($model->save()){

            			$datas = [
            			'status'=>'ok',
            			'message'=>'L\'utilisateur est bien enregistre'
            			];
            		}else{

            			$datas = [
            			'status'=>'ko',
            			'message'=>'Echec d\'enregistrement'
            			];
            		}

            	}else{

            		    $datas = [
            			'status'=>'ko',
            			'message'=>'Cet utilisateur existe dejas'
            			];

            	}

            }

            return $datas;
        }


    }
	public function actionUpdates(){

		$model = new users();

		if(Yii::$app->request->get()){

			$param = Yii::$app->request->get();
			$model = $model->findOne(['id'=>$param['id']]);
/*            print_r($param);exit;
            $model->name = $param['name'];
            $model->email = $param['email'];*/
            $datas = null;
            foreach ($param as $key => $value) {

            	if(!$value){


            		$datas = [
            		'status'=>'ko',
            		'message'=>'Tous les champs sont obligatoires'
            		];break;

            	}else{
            		$model->$key = urldecode($value);
            	}
            	
            }

            if(!$datas){


            		if($model->save()){

            			$datas = [
            			'status'=>'ok',
            			'message'=>'Mise a jour effectuee avec succes'
            			];
            		}else{

            			$datas = [
            			'status'=>'ko',
            			'message'=>'Echec de mise a jour'
            			];
            		}

            }

            return $datas;
        }


    }
}
