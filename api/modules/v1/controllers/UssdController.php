<?php
namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\XmlResponseFormatter;
use console\models\Ussdtransation;

class UssdController extends ActiveController
{
public $modelClass = 'api\modules\v1\models\Ussd';    


public function actionExec($cmd) {
   
	 /*   $get_url=yii::$app->basePath;   
        $base_url=explode(DIRECTORY_SEPARATOR."api",$get_url)[0];  
        chdir($base_url);
		
        $command = 'yii togocelussd/process '.$cmd;
		
		$handler = popen($command, 'r');
		
        $output = '';
        while (!feof($handler)) {
            $output .= fgets($handler);
        }
		$output = trim($output);
        $status = pclose($handler);
        return $output;	
		//print_r ($output);
	
    */ 

	$cmd = 'cd ../.. && /usr/local/bin/php yii consoleappinit/process '.$cmd;
	return $result = shell_exec($cmd);
	
}

public function actionGetdata() {

   
   $params = Yii::$app->request->post();

   if(isset($params['data'])) {
        $datas = $params['data'];
		
		
        $datas = stripslashes($datas);
        $datas = str_replace("'", "", $datas);
        if(!is_null($datas) && !empty($datas)){
            Yii::$app->response->format = Response::FORMAT_XML;
            Yii::$app->response->formatters['xml'] = [
                 'class' =>XmlResponseFormatter::className(),
                 'rootTag' => 'BillIssuerAPI'
             ];   
            $xml = simplexml_load_string($datas,NULL, TRUE);
            if(!is_null($xml)) {
			    
                if((string)$xml->type=="PREAUTH"){
				
						$numero=(string)$xml->user_mobile;
						$name=(string)$xml->user_last_name;
						$firstname=(string)$xml->user_first_name;
						$menu=(string)$xml->billissuer_id;
						$response=(string)$xml->bill_ref;
						
						//Initialisation de l'operation		
						$command='-t="'.$numero.'" -n="'.$name.'" -f="'.$firstname.'" -s="0" -r="'.$response.'" -m="'.$menu.'"';						
						$response= $this->actionExec($command);	
						$message= (array)(json_decode($response));
						
						
						
				}else if((string)$xml->type=="TRANSACTION"){
				
						
						$numero=(string)$xml->user_mobile;
						$name=(string)$xml->user_last_name;
						$firstname=(string)$xml->user_first_name;
						$menu=(string)$xml->billissuer_id;
						$response=(string)$xml->bill_ref;
						
						//Finalisation de l'operation		
						$command='-t="'.$numero.'" -n="'.$name.'" -f="'.$firstname.'" -s="1" -r="'.$response.'" -m="'.$menu.'"';	
						$response= $this->actionExec($command);	
						$message= (array)(json_decode($response));
						
				}else {					  
					    $message=[
							'message'=> \Yii::t('app', 'NO_INFORMATION_RECEIVED')
						];
				}
			}else {
				$message=[
					'message'=> \Yii::t('app', 'NO_INFORMATION_RECEIVED')
				];
			}	
		}else {
			$message=[
				'message'=> \Yii::t('app', 'NO_INFORMATION_RECEIVED')
			];
		}	
		
		
	}else {
		$message=[
			'message'=> \Yii::t('app', 'NO_INFORMATION_RECEIVED')
		];
	}	

	
	$response= ['status'=>'OK','info'=>"Test again",'amount'=>100];
	 
	return	$message;
}


public function actionExectest($cmd) {
	
	
		
   
	/**/ $get_url=yii::$app->basePath;   
        $base_url=explode(DIRECTORY_SEPARATOR."api",$get_url)[0];  
	
        chdir($base_url);
		
		
        $command = 'php yii consoleappinit/process '.$cmd;
       
		
		$handler = popen($command, 'r');
		
        $output = '';
        while (!feof($handler)) {
            $output .= fgets($handler);
        }
		
		$output = trim($output);
        $status = pclose($handler);
        return $output;	
		//print_r ($output);
	
    
    

	
	/*$cmdd = 'cd ../.. && /usr/local/bin/php yii consoleappinit/process '.$cmd;
	$cmdd = 'cd../.. && php yii consoleappinit/process '.$cmd;
	    
	 $result = shell_exec($cmdd);
        
     return $result;*/
	
}


public function actionGetdatatest() {
  // exit();


   $params = Yii::$app->request->post();
   
   if( isset($params['type']) and isset($params['transaction_id']) and isset($params['response']) and 
   isset($params['user_mobile']) and isset($params['user_first_name']) and isset($params['user_last_name'])   ) {
    
		$transaction_id=(string)trim($params['transaction_id']);
		$type=(string)trim($params['type']);
		$response=(string)trim($params['response']);
		$numero=(string)trim($params['user_mobile']);
		$name=(string)trim($params['user_first_name']);
		$firstname=(string)trim($params['user_last_name']);
                
//                 return $type; 
		if($type=="PREAUTH"){
                    //Initialisation de l'operation		
                    $command='-t="'.$numero.'" -n="'.$name.'" -f="'.$firstname.'" -s="0" -i="'.$transaction_id.'"';
                    $message= $this->actionExectest($command);	
                     
		}else if($type=="TRANSACTION"){                     
						
                    $command='-t="'.$numero.'" -r="'.$response.'" -i="'.$transaction_id.'" -s="1" ';
                    $message= $this->actionExectest($command);
		}             
    }else{
         $message= \Yii::t('app', 'NO_INFORMATION_RECEIVED');
    }
//    return 1;
	echo  $message ;	
}



}