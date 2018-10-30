<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;


class TestController extends Controller
{
    public $message;	
    public $fichier;
    public $sender;
	
	
        public function options(){	
		return ['message','fichier','sender'];
	}
	
	public function optionAliases(){
            return ['m'=>'message','f'=>'fichier','s'=>'sender'];
	}
	
	
     public function actionIndex() {
                $transaction_id="222";
		$type="1";
		$response="23";
		$numero="22891121670";
		$name="koudam";
		$firstname="yvon";
                $command='-t="'.$numero.'" -n="'.$name.'" -f="'.$firstname.'" -s="0" -i="'.$transaction_id.'"';
        echo $command;
    }
    
     public function actionGet($name, $address) {
        echo "I'm " . $name . " and live in " . $address . "\n";
    }

}
