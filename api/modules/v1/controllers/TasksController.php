<?php

namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use api\modules\v1\models\Tasks;

class TasksController extends ActiveController
{
	public $modelClass = 'api\modules\v1\models\Tasks'; 

      public function actionUsers_tasks($id_users=null){

            if(!is_null($id_users)){
                  
                  //$tasks = Tasks::find(['id_users'=>$id_users])->all();
                  $tasks = Tasks::find()->where(['id_users'=>$id_users])->all();
                  //print_r($tasks);exit;

                  if(!empty($tasks)){

                        $datas = [
                        'id'=>$id_users,
                        'status'=>'ok',
                        'message'=>'Ci-après la liste des taches',
                        'tasks'=>$tasks
                        ];

                  }else{

                        $datas = [
                        'id'=>$id_users,
                        'status'=>'ko',
                        'message'=>'Aucune tache disponible',
                        'tasks'=>array()
                        ];
                  }

            }   
        return $datas; 
      }

      public function actionTasks($id=null){



          if(is_null($id)){

               $tasks = Tasks::find()->all();

               if(!empty($tasks)){

                    $datas = [
                    'id'=>$id,
                    'status'=>'ok',
                    'message'=>'Ci-après la liste des taches',
                    'tasks'=>$tasks
                    ];

              }else{

                    $datas = [
                    'id'=>$id,
                    'status'=>'ko',
                    'message'=>'Aucune tache disponible, veuillez enrégistrer une nouvelle tache.',
                    ];
              }

        }else{

         $task = Tasks::findOne(['id'=>$id]);

         if(!empty($task)){

              $datas = [
              'id'=>$id,
              'status'=>'ok',
              'message'=>'Ci-après la tache demandee',
              'task'=>$task
              ];
        }else{

              $datas = [
              'id'=>$id,
              'status'=>'ko',
              'message'=>'Aucune tache  n\'est disponible',
              ];
        }
  }
return $datas;

}

public function actionAdd(){

    $model = new Tasks();

    if(Yii::$app->request->get()){

         $param = Yii::$app->request->get();
           //print_r($param);exit;
       /*   $model->name = $param['name'];
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
            //print_r($model);exit;
    if(!$datas){

     $exist=$model->findOne(['id_users'=>$model->id_users,'libelle'=>$model->libelle]);

     if(!$exist){

          if($model->save()){

               $datas = [
               'status'=>'ok',
               'message'=>'la tache est bien enregistrée'
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
      'message'=>'Cette tache existe déjas'
      ];

}

}

return $datas;
}


}
public function actionUpdates(){

    $model = new Tasks();

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
                     'message'=>'Mise à jour effectuée avec succes'
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
