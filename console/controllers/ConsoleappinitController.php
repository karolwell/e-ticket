<?php

/*
  Tester dans le console
  Pour demarrer la section executer

  yii consoleappinit/process -t="22891403958" -n="GABIAM" -f="Folly Bernard" -s="0" -i="123"

  Ensuite pour continuer

  >yii consoleappinit/process -t="22891403958" -r="REPONSE"  -s="1" -i="123"





  METEO AU NIVEAU DU CENTRE D'APPEL AVEC SUIVIT DE LOPERATION


  MENU USSD
  CONSEIL AGRICOLE (SABONNER)

  CENTRE DAPPEL
  DEVELOPPER CONSEIL AGRICOLE 1 ET 3
  RETRAIT DE PUBLICATION AU NIVEAU DU CENTRE D'APPEL AVEC MODIFICATION


  WEB
  DISCUSSION ACTIF SSI FORFAITCONTACT AJOUR
  RETRAIT DES ANNONCES AU NIVEAU DU WEB



 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use console\models\User;
use console\models\Ussdtransation;
use console\models\MenuUssd;
use console\models\Pays;
use console\models\Ticket;
use console\models\TypeTicket;
use console\models\Activite;
use console\models\Achat;
use console\models\AchatDetails;
use console\models\ConfigFacturier;
use console\models\TopEvenement;
class ConsoleappinitController extends Controller {

    public $telephone;
    public $name;
    public $firstname;
    public $status;
    public $idtransaction;
    public $response;

    const MENU_SYSTEME = '10';
    const ALL_SYSTEME = '90';
    const SUIVANT_SYSTEME = '99';
    const PRECEDENT_SYSTEME = '98';
    const ID_COUNTRY = '214';
    const ID_OPERATEUR = '1747';
    const PRIX_METEO = '25';
    const PRIX_METEO_MOIS = '715';
    const MENU_RESERVATION = '1';
    const MENU_FACTURE = '2';
    const MENU_TICKET = '3';
    const MENU_EVENEMENT = '4';
    const MENU_ALERTSMS = '5';
    const MENU_CONSEILSAGRI = '6';
    const MENU_SEARCHPRODUIT = '7';
    const MENU_SEARCHPRICE = '8';
    const MENU_RECHARGEWEB = '9';
    const MENU_FORFAITCONTACT = '10';
    const MENU_COMPTEWEB = '11';
    const MENU_RECOMMANDER = '12';

    public function options() {

        return ['telephone', 'name', 'firstname', 'status', 'idtransaction', 'response'];
    }

    public function optionAliases() {
        return ['t' => 'telephone', 'n' => 'name', 'f' => 'firstname', 's' => 'status', 'r' => 'response', 'i' => 'idtransaction'];
    }

    public function actionProcess() {


        $status = trim($this->status);

        $telephone = trim($this->telephone);
        $idtransaction = trim($this->idtransaction);
        $response = trim($this->response);

        $name = "";
        $firstname = "";

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;


        if ($status == 0) {
            $name = trim($this->name);
            $firstname = trim($this->firstname);
        }

//	    $id_user=$this->actionCheck_user($telephone,$name,$firstname,$status);		
//		if($id_user=="0"){
//		
//			$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
//			 
//		}else{
//			$id_trans=$this->actionCheck_transaction($idtransaction,$telephone,$id_user,$status);
        $id_trans = $this->actionCheck_transaction($idtransaction, $telephone, $status);
//                        print_r($id_trans);exit;

        if ($id_trans == 0) {

	$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
//            $message = \Yii::t('app', 'jkm');
        } else {

//				$info_user=User::findOne(['id'=>$id_user]);
//				if($info_user->regionsId==null){
//				
//						$message=$this->update_region($status,$id_trans,$response);
//				}else{	

            if ($status == "0") {

                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                if (sizeof($all_menu) > 0) {

                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');


                    $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);
                    $i = 1;

                    if (sizeof($all_menu) < $nbre_show) {

                        foreach ($all_menu as $menu) {
                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                            $i++;
                        }
                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                        $find_transaction->page_menu = 0;
                    } else {

                        $count = 0;
                        for ($i = 0; $i < $nbre_show; $i++) {
                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                            $count++;
                        }

                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                        $find_transaction->page_menu = 1;
                    }

                    $find_transaction->message_send = $message;
                    $find_transaction->save();
                } else {
                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                }
            } else if ($status == "1") {
               
                $message = $this->consoleprocess($response, $id_trans);
            } else {
                $message = \Yii::t('app', 'FALSE_INFORMATION');
            }
//				}
        }

//		}

        echo $this->wd_remove_accents($message, 'utf-8');
    }

    public function consoleprocess($res, $id_trans) {


        $id_trans = trim($id_trans);
        $response = trim($res);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $menu = trim($find_transaction->menu);

        $sub_menu = trim($find_transaction->sub_menu);

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $rec_menu = $menu;
        if ($rec_menu == "-1")
            $rec_menu = $response;
        $test_menu = MenuUssd::findone(['position_menu_ussd' => $rec_menu, 'status' => '1']);
        if ($test_menu !== null or $rec_menu == "0" or $response == $nest_show or $response == $previor_show) {

            switch (trim($menu)) {
                case "-1":
                   
                    if ($response != $nest_show and $response != $previor_show) {
                        $find_transaction->menu = $response;
                    }
                    $find_transaction->sub_menu = 1;
                    $find_transaction->save();
                    
                        
                    switch (trim($response)) {
                        case "0":
                           
                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();
                            if (sizeof($all_menu) > 0) {
                                $message = \Yii::t('app', 'HAVE_AIDE');
                                $i = 1;

                                if (sizeof($all_menu) < $nbre_show) {

                                    foreach ($all_menu as $menu) {
                                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                        $i++;
                                    }
                                    $message .= "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                    $find_transaction->page_menu = 0;
                                } else {

                                    $count = 0;
                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                    $message .= "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                    $find_transaction->page_menu = 1;

                                    $find_transaction->message_send = $message;
                                }
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }
                            $find_transaction->save();

                            break;

                        case $previor_show:

                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                            if (sizeof($all_menu) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;
                                $message = "";

                                if ($page_actuelle > 1) {

                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_menu)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }
                                    }


                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {
                                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_menu)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }
                                $message .= "\n0. " . \Yii::t('app', 'AIDE');

                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }

                            $find_transaction->save();

                            break;
                        case $nest_show:

                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();
                            if (sizeof($all_menu) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_menu) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_menu) - $start;

                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        } else {
                                            $message .= "\n";
                                        }


                                        if ($count == $nbre_show) {
                                            if (sizeof($all_menu) > ($nbre_show + $start)) {
                                                $message .= $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_menu); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_menu) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }



                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }

                                $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }
                            $find_transaction->save();
                            break;
                            
                        case ConsoleappinitController::MENU_RESERVATION :
                            $message = $this->reservation($response, $id_trans, 0);
                            break;
                        
                         case ConsoleappinitController::MENU_FACTURE :
                            $message = $this->impression_facture($response, $id_trans, 0);
                            
                        break;

                        case ConsoleappinitController::MENU_TICKET :
                            $message = $this->impression_ticket($response, $id_trans, 0);
                            break;

                        case ConsoleappinitController::MENU_EVENEMENT :
                            $message = $this->top_evenement($response, $id_trans, 0);
                            break;

                        default:
                            $find_transaction->menu = -1;
                            $find_transaction->save();
                            $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            break;
                    }
                    break;

                case "0":
              
                    switch (trim($response)) {
                        case $previor_show:

                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                            if (sizeof($all_menu) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;
                                $message = "";

                                if ($page_actuelle > 1) {

                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_menu)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }
                                    }


                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {
                                        $message = \Yii::t('app', 'HAVE_AIDE') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'HAVE_AIDE');
                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_menu)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }
                                $message .= "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }

                            $find_transaction->save();

                            break;
                        case $nest_show:

                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();
                            if (sizeof($all_menu) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_menu) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_menu) - $start;

                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        } else {
                                            $message .= "\n";
                                        }


                                        if ($count == $nbre_show) {
                                            if (sizeof($all_menu) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_menu); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_menu) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }

                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }

                                $message .= "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }

                            $find_transaction->save();

                            break;
                        case "0":
                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();
                            if (sizeof($all_menu) > 0) {
                                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                $i = 1;
                                if (sizeof($all_menu) < $nbre_show) {

                                    foreach ($all_menu as $menu) {
                                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                        $i++;
                                    }
                                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                    $find_transaction->page_menu = 0;
                                } else {

                                    $count = 0;
                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                    $find_transaction->page_menu = 1;
                                }

                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                ;
                            }

                            $find_transaction->menu = -1;
                            $find_transaction->save();
                            break;
                        default:
                            $aide_menu = MenuUssd::findone(['position_menu_ussd' => $response, 'status' => '1']);

                            if ($aide_menu !== null) {
                                $message = $aide_menu->description . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                ;
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                            break;
                    }

                    break;

                case ConsoleappinitController::MENU_RESERVATION :
                    $message = $this->reservation($response, $id_trans, 1);
                    break;
                
                   case ConsoleappinitController::MENU_FACTURE :
                    $message = $this->impression_facture($response, $id_trans, 1);
                    break;

                case ConsoleappinitController::MENU_TICKET :
                  
                    $message = $this->impression_ticket($response, $id_trans, 1);
                    break;

                case ConsoleappinitController::MENU_EVENEMENT :
                    $message = $this->top_evenement($response, $id_trans, 1);
                    break;

                default:
                    $message = \Yii::t('app', 'ERREUR');
                    $find_transaction->etat_transaction = 2;
                    $find_transaction->save();
                    break;
            }
        } else {
            $find_transaction->menu = -1;
            $find_transaction->sub_menu = 0;
            $find_transaction->page_menu = 1;
            $find_transaction->save();
            $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
        }

        return $message;
    }

    public function reservation($response, $id_trans, $status) {
//        return 1111;
        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $prix_unitaire = ConsoleappinitController::PRIX_METEO;
        $prix_unitaire_mois = ConsoleappinitController::PRIX_METEO_MOIS;
        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $sub_menu = trim($find_transaction->sub_menu);
        $nbre = (int) $response;
        if ($nbre == 0) {
            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

            if (sizeof($all_menu) > 0) {
                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                $i = 1;

                if (sizeof($all_menu) < $nbre_show) {

                    foreach ($all_menu as $menu) {
                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                        $i++;
                    }
                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 0;
                } else {

                    $count = 0;
                    for ($i = 0; $i < $nbre_show; $i++) {
                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                        $count++;
                    }

                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 1;
                }
                $find_transaction->message_send = $message;
            } else {
                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
            }

            $find_transaction->menu = -1;
            $find_transaction->sub_menu = 0;
            $find_transaction->save();
        } else {

            switch (trim($status)) {
                case "0":
//                        $message = "1. Meteo du jour\n2. Un autre jour\n3. aujourd'hui a ...\n4. Alerte météo\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                        $message = "Veuillez entrer le code de l'editeur: ";
                        $find_transaction->message_send = $message;
                        $find_transaction->sub_menu = 1;
                        $find_transaction->save();
                   
                 break;

                case "1":
                    
                    switch (trim($sub_menu)) {
                        case "1":
//                        return 11;
                            $editeur = User::find()->where(['status'=>10,'identifiant'=>$response])->one();
//                             return $editeur->id;
                            if(sizeof($editeur)==1){
                                  $all_act = $editeur->activites;
                                     $activites = array();
                                     $date = date('Y-m-d');
                                     foreach ($all_act as $activite){
                                         if($activite->datefin == NULL || $activite->datefin > $date){
                                             array_push($activites, $activite);
                                         }
                                     }
                                     
                                     if(sizeof($activites)>0){
                                         
                                              $message=\Yii::t('app', 'SELECT_ACTIVITE');
                                                $i=1;
                                                if(sizeof($activites)< $nbre_show ){

                                                        foreach ($activites as $act){
                                                                $message.="\n".$i.". ".$act->designation;
                                                                $i++;
                                                        }
                                                        $find_transaction->page_menu=0;
                                                }else{

                                                        $count=0;
                                                        for($i=0;$i<$nbre_show;$i++){											
                                                                $message.="\n".($i+1).". ".$activites[$i]->designation;
                                                                $count++;
                                                        }

                                                        $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
                                                        $find_transaction->page_menu=1;											
                                                }
                                     }else{
                                        $message=\Yii::t('app', 'AUCUNE ACTIVITE EN COURS POUR CET EDITEUR');
                                        $find_transaction->etat_transaction=1;
                                     }
                                              $orther='"editeurIdentif":"'.$response.'"';
                                                $find_transaction->others = $orther;
                                                $find_transaction->message_send=$message;
                                                $find_transaction->sub_menu = 2;
                                                $find_transaction->save();
                                            $find_transaction->save();
//                                return $activites;
                            }else{
                                 $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send;
                            }

                            break;
                        case "2":
                          if($response==$previor_show){
                                    $editeur = User::find()->where(['status'=>10,'identifiant'=>$response])->one();
                                     $all_act = $editeur->activites;
                                     $activites = array();
                                     $date = date('Y-m-d');
                                     foreach ($all_act as $activite){
                                         if($activite->datefin == NULL || $activite->datefin > $date){
                                             array_push($activites, $activite);
                                         }
                                     }
//                                        $all_categorie=Categorie::find()->orderBy('name ASC')->all();

                                    if(sizeof($activites)>0){

                                            $page_actuelle=(int)$find_transaction->page_menu;

                                            $message="";
                                            if($page_actuelle>1){

                                                    $start=($page_actuelle-2)*$nbre_show;

                                                    $count=0;
                                                    for($i=$start;$i<($nbre_show+$start);$i++){	
                                                            if($i<sizeof($activites)){

                                                                    if($message!="")$message.="\n";
                                                                    $message.=($i+1).". ".$activites[$i]->designation;
                                                                    $count++;
                                                            }
                                                    }

                                                    if($start>0){
                                                            $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                    }else{
                                                            $message=\Yii::t('app', 'SELECT_ACTIVITE')."\n".$message."\n";											 
                                                    }
                                                    $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');

                                                    $find_transaction->page_menu=$page_actuelle-1;

                                            }else{

                                                    $message=\Yii::t('app', 'SELECT_ACTIVITE');

                                                    for($i=0;$i<$nbre_show;$i++){	
                                                            if($i<=sizeof($activites)){
                                                                    $message.="\n".($i+1).". ".$activites[$i]->designation;
                                                            }
                                                    }											

                                                    $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                            }


                                            $find_transaction->message_send=$message;	

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else if($response==$nest_show){
                                    
                                      $editeur = User::find()->where(['status'=>10,'identifiant'=>$response])->one();
                                        $all_act = $editeur->activites;
                                     $activites = array();
                                     $date = date('Y-m-d');
                                     foreach ($all_act as $activite){
                                         if($activite->datefin == NULL || $activite->datefin > $date){
                                             array_push($activites, $activite);
                                        }
                                     }
                                        if(sizeof($activites)>0){
                                                $message="";
                                                $i=1;

                                                $page_actuelle=(int)$find_transaction->page_menu;
                                                $start=$page_actuelle*$nbre_show;

                                                if(sizeof($activites)<($nbre_show+$start) ){
                                                    

                                                        $nbre_reste=sizeof($activites)-$start;


                                                        if($nbre_reste>=1){
                                                                $count=0;
                                                                for($i=$start;$i<($nbre_reste+$start);$i++){
                                                                    if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$activites[$i]->designation;
                                                                        $count++;
                                                                }

                                                                if($page_actuelle>0){
                                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                                }

                                                                if($count==$nbre_show){
                                                                        if(sizeof($activites)>($nbre_show+$start)){
                                                                                $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                        }
                                                                }

                                                                $find_transaction->page_menu=$page_actuelle+1;
                                                        }else{

                                                                $start=($page_actuelle-1)*$nbre_show;
                                                                for($i=$start;$i<sizeof($activites);$i++){
                                                                        if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$activites[$i]->designation;
                                                                }
                                                                $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');

                                                        }

                                                }else{

                                                        $count=0;
                                                        for($i=$start;$i<($nbre_show+$start);$i++){		
                                                                if($message!="")$message.="\n";
                                                                $message.=($i+1).". ".$activites[$i]->designation;
                                                                $count++;
                                                        }

                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        if($count==$nbre_show){
                                                                if(sizeof($activites)>($nbre_show+$start)){
                                                                        $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                }
                                                        }

                                                        $find_transaction->page_menu=$page_actuelle+1;
                                                }
                                                $find_transaction->message_send=$message;

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									


                                        $find_transaction->save();

                                }else{
                                       $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                        $information=$recup_information[0];	
                                        $identifiant= $information['editeurIdentif'];
                                      $editeur = User::find()->where(['status'=>10,'identifiant'=>$identifiant])->one();
//                                         $activites = $editeur->activites;
                                          $all_act = $editeur->activites;
                                            $activites = array();
                                            $date = date('Y-m-d');
                                            foreach ($all_act as $activite){
                                                if($activite->datefin == NULL || $activite->datefin > $date){
                                                    array_push($activites, $activite);
                                                }
                                            }
                                         
                                            if((int)$response<=sizeof($activites)){
						
                                                            $activite=$activites[(int)$response-1];
                                                            $all_ticket=Ticket::find()->where(['activiteId'=>$activite->id])->orderBy('prix ASC')->all();					
                                                            if(sizeof($all_ticket)>0){

                                                                    $message=\Yii::t('app', 'SELECTIONNER LE TICKET');
                                                                    $i=1;
                                                                    if(sizeof($all_ticket)< $nbre_show ){

                                                                            foreach ($all_ticket as $ticket){
                                                                                    $message.="\n".$i.". ".$ticket->designation;
                                                                                    $i++;
                                                                            }
                                                                            $find_transaction->page_menu=0;
                                                                    }else{

                                                                            $count=0;
                                                                            for($i=0;$i<$nbre_show;$i++){											
                                                                                    $message.="\n".($i+1).". ".$all_ticket[$i]->designation;
                                                                                    $count++;
                                                                            }
                                                                            $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
                                                                            $find_transaction->page_menu=1;											
                                                                    }

                                                                    $find_transaction->message_send=$message;
                                                                    
                                                            }else{
                                                                    $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                                    $find_transaction->etat_transaction=2;
                                                            }
//                                                            return 12;
                                                     $orther=$find_transaction->others.',"activiteId":"'.$activite->id.'"';
//                                                    $find_transaction->message_send=$message;
                                                    $find_transaction->others=$orther;
                                                    $find_transaction->sub_menu=3;
                                                    $find_transaction->save();	
                                                
//                                                    $activite=$activites[(int)$response-1];
                                                    										
                                            }else{
                                                $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
                                            }									
                                }	
                            break;
                        case "3":
                          if($response==$previor_show){
                                     $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                    $information=$recup_information[0];	
                                    $activiteId= $information['activiteId'];
                                    $all_ticket=Ticket::find()->where(['activiteId'=>$activiteId])->orderBy('prix ASC')->all();					
//                                        $all_categorie=Categorie::find()->orderBy('name ASC')->all();
                                    if(sizeof($all_ticket)>0){

                                            $page_actuelle=(int)$find_transaction->page_menu;

                                            $message="";
                                            if($page_actuelle>1){

                                                    $start=($page_actuelle-2)*$nbre_show;

                                                    $count=0;
                                                    for($i=$start;$i<($nbre_show+$start);$i++){	
                                                            if($i<sizeof($all_ticket)){

                                                                    if($message!="")$message.="\n";
                                                                    $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                    $count++;
                                                            }
                                                    }

                                                    if($start>0){
                                                            $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                    }else{
                                                            $message=\Yii::t('app', 'SELECTIONNER LE TICKET')."\n".$message."\n";											 
                                                    }
                                                    $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');

                                                    $find_transaction->page_menu=$page_actuelle-1;

                                            }else{

                                                    $message=\Yii::t('app', 'SELECTIONNER LE TICKET');

                                                    for($i=0;$i<$nbre_show;$i++){	
                                                            if($i<=sizeof($all_ticket)){
                                                                    $message.="\n".($i+1).". ".$all_ticket[$i]->designation;
                                                            }
                                                    }											

                                                    $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                            }


                                            $find_transaction->message_send=$message;	

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else if($response==$nest_show){
                                     $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                    $information=$recup_information[0];	
                                    $activiteId= $information['activiteId'];
                                    $all_ticket=Ticket::find()->where(['activiteId'=>$activiteId])->orderBy('prix ASC')->all();	
                                        if(sizeof($all_ticket)>0){
                                                $message="";
                                                $i=1;

                                                $page_actuelle=(int)$find_transaction->page_menu;
                                                $start=$page_actuelle*$nbre_show;

                                                if(sizeof($all_ticket)<($nbre_show+$start) ){
                                                        $nbre_reste=sizeof($all_ticket)-$start;
                                                        if($nbre_reste>=1){
                                                                $count=0;
                                                                for($i=$start;$i<($nbre_reste+$start);$i++){
                                                                    if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                        $count++;
                                                                }

                                                                if($page_actuelle>0){
                                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                                }

                                                                if($count==$nbre_show){
                                                                        if(sizeof($all_ticket)>($nbre_show+$start)){
                                                                                $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                        }
                                                                }

                                                                $find_transaction->page_menu=$page_actuelle+1;
                                                        }else{

                                                                $start=($page_actuelle-1)*$nbre_show;
                                                                for($i=$start;$i<sizeof($all_ticket);$i++){
                                                                        if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                }
                                                                $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        }
                                                }else{
                                                        $count=0;
                                                        for($i=$start;$i<($nbre_show+$start);$i++){		
                                                                if($message!="")$message.="\n";
                                                                $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                $count++;
                                                        }

                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        if($count==$nbre_show){
                                                                if(sizeof($all_ticket)>($nbre_show+$start)){
                                                                        $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                }
                                                        }

                                                        $find_transaction->page_menu=$page_actuelle+1;
                                                }
                                                $find_transaction->message_send=$message;

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else{
                                           $recup_information=Json::decode("[{".$find_transaction->others."}]");										
                                            $information=$recup_information[0];	
                                            $activiteId= $information['activiteId'];
                                            $all_ticket=Ticket::find()->where(['activiteId'=>$activiteId])->orderBy('prix ASC')->all();	
//                                         $all_categorie=Categorie::find()->orderBy('name ASC')->all();
                                            if((int)$response<=sizeof($all_ticket)){
                                                 $ticket = $all_ticket[(int)$response-1];
                                                 
                                                 
                                                  $achats = AchatDetails::find()->where(['ticketId'=>$ticket->id])->all();
                                                    if($ticket->nombre_ticket == NULL){
                                                        $message = "Veuillez entrer le nombre de tickets \n(maximum 5)";
                                                       $orther=$find_transaction->others.',"ticketId":"'.$ticket->id.'"';
                                                       $find_transaction->others = $orther;
                                                       $find_transaction->message_send = $message;
                                                       $find_transaction->sub_menu = 4;
                                                    }else{
                                                        $nbre_achat = sizeof($achats);
                                                        $reste = (int)$ticket->nombre_ticket - $nbre_achat;
                                                        if($reste==0){
                                                            //ticket fini
                                                             $message=\Yii::t('app', 'NOMBRE MAXIMAL ATTEINT POUR CE TICKET');
                                                             $find_transaction->message_send = $message;
                                                             $find_transaction->etat_transaction=1;
                                                        }else{
                                                               //il peux acheter
                                                                 $message = "Veuillez entrer le nombre de tickets \n(maximum 5)";
                                                                $orther=$find_transaction->others.',"ticketId":"'.$ticket->id.'"';
                                                                $find_transaction->others = $orther;
                                                                $find_transaction->message_send = $message;
                                                                $find_transaction->sub_menu = 4;
                                                        }
                                                    }
                                                    $find_transaction->save();
//                                           										
                                            }else{
                                                $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
                                            }									
                                }	
                            break;
                        case "4":
                            if (is_numeric($response)) {
                              $nbre = (int) $response;
                                 $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                $information=$recup_information[0];	
                                $activiteId= $information['activiteId'];
                                $activite = Activite::findOne($activiteId);
                                $ticketId= $information['ticketId'];
                                $ticket = Ticket::findOne($ticketId);
                                $achats = AchatDetails::find()->where(['ticketId'=>$ticket->id])->all();
                                 if($ticket->nombre_ticket == NULL){
                                         if ($nbre <= 5 && $nbre > 0) {
                                            $total = (int)$ticket->prix * $nbre;
                                            $message = $activite->designation."\n"." Achat de ".$nbre." ticket(s) de ".$ticket->prix." F CFA "."\n\n1. ".\Yii::t('app', 'CONFIRMER')."\n2. ".\Yii::t('app', 'ANNULER');
                                            $find_transaction->message_send = $message;
                                            $orther=$find_transaction->others.',"nbre":"'.$nbre.'"'.',"montant":"'.$total.'"';
                                            $find_transaction->others = $orther;
                                            $find_transaction->sub_menu = 5;
            //                                $find_transaction->message = "1";
                                            $find_transaction->save();
                                        }else {
                                            $message = \Yii::t('app', 'ERREUR') . ":" . $find_transaction->message_send;
                                        }
                                    }else{
                                        $nbre_achat = sizeof($achats);
                                        $reste = (int)$ticket->nombre_ticket - $nbre_achat;
                                         if($reste >= $nbre){ 
                                            if ($nbre <= 5 && $nbre > 0) {
                                                  $total = (int) $ticket->prix * $nbre;
                                                  $message = $activite->designation . "\n" . " Achat de " . $nbre . " ticket(s) de " . $ticket->prix . " F CFA " . "\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER');
                                                  $find_transaction->message_send = $message;
                                                  $orther = $find_transaction->others . ',"nbre":"' . $nbre . '"' . ',"montant":"' . $total . '"';
                                                  $find_transaction->others = $orther;
                                                  $find_transaction->sub_menu = 5;
                                                  //                                $find_transaction->message = "1";
                                                  $find_transaction->save();
                                              } else {
                                                  $message = \Yii::t('app', 'ERREUR') . ":" . $find_transaction->message_send;
                                              }
                                          } else {
      //                                                 $nbre_a_payer = $nbre - $reste;
                                              $message = "Il ne reste que " . $reste . " ticket(s) de " . $ticket->prix . " F CFA disponible";
                                              $find_transaction->message_send = $message;
                                          }
                                    }
                                 
                                
                          
                                    $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send;
                            }
                             
                            break;
                        case "5":
//                              print_r($response);exit;
                            if($response=="1"){
//                                print_r(111);exit;
                                    //enregistrement du produit
                                    $recup_information=Json::decode("[{".$find_transaction->others."}]");										
                                    $information=$recup_information[0];	
                                    $ticketId = (int)$information['ticketId'];
                                    $nombre = (int)$information['nbre'];
                                    $msg ="";
                                     $achat=new Achat();
                                    
                                     $achat->numero_client = $find_transaction->username;
                                     $achat->dateAchat = date("Y-m-d H:i:s");
                                     $achat->montant = $information['montant'];
                                     $achat->etat = 1;
                                     $achat->code_facture = "A".rand(10000,99999);
                                     if($achat->save()){
                                         for ($i = 0; $i < $nombre; $i++) {
                                             $detail=new AchatDetails();
                                             $detail->ticketId = $ticketId;
                                             $detail->numero_client = $find_transaction->username;
                                             $detail->achatId = $achat->id;
                                             $detail->code = $this->random(12);
                                             $detail->etat = 1;
                                             if($detail->save()){
                                                    //envoyer un message a l'annonceur
                                                    $receiver=$find_transaction->username;
                                                    $sender="E-ticket";
                                                    $sms = "#".$detail->code."#. Retrouvez vos tickets sur cette adresse: https://www.e-tikets.online/impression/".$achat->code_facture;
//                                                    if($msg =="")$msg.=$detail->code." .Retrouvez vos tickets sur cette adresse: https://www.e-tikets.online/impression/".$achat->code_facture.".";
                                                    $msg.=$detail->code." .Retrouvez vos tickets sur cette adresse: https://www.e-tikets.online/impression/".$achat->code_facture.".";
//                                                  $this->send_sms($sms,$sender,$receiver);
                                                     $this->send_sms($sms, $receiver);
                                            }else{
                                               $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
                                            }
                                        }
                                            $message=\Yii::t('app', 'ACHAT DE TICKET REUSSI');
                                            $find_transaction->message=$msg;
                                            $find_transaction->sub_menu=6;
                                            $find_transaction->etat_transaction=1;
                                            $find_transaction->save();
                                     }else{
                                         $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send; 
                                     }

                            }else{

                                    $all_menu=MenuUssd::find()->where(['status'=>'1'])->orderBy('position_menu_ussd ASC')->all();

                                    if(sizeof($all_menu)>0){

                                            $message=\Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                            $i=1;

                                            if(sizeof($all_menu)< $nbre_show ){

                                                    foreach ($all_menu as $menu){
                                                            $message.="\n".$menu->position_menu_ussd.". ".$menu->denomination;
                                                            $i++;
                                                    }
                                                    $message.="\n\n0. ".\Yii::t('app', 'AIDE');
                                                    $find_transaction->page_menu=0;
                                            }else{

                                                    $count=0;
                                                    for($i=0;$i<$nbre_show;$i++){											
                                                            $message.="\n".$all_menu[$i]->position_menu_ussd.". ".$all_menu[$i]->denomination;

                                                            $count++;
                                                    }

                                                    $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');	
                                                    $message.="\n0. ".\Yii::t('app', 'AIDE');
                                                    $find_transaction->page_menu=1;

                                            }
                                            $find_transaction->message_send=$message;
                                    }else{
                                            $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                    }

                                    $find_transaction->menu=-1;
                                    $find_transaction->save();
                            }
                    }
                    break;
            }
        }
        return $message;
    }
    
    public function impression_facture($res, $id_trans, $status) {
//        return 1111;
        $id_trans = trim($id_trans);
        $response = trim($res);
          

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $prix_unitaire = ConsoleappinitController::PRIX_METEO;
        $prix_unitaire_mois = ConsoleappinitController::PRIX_METEO_MOIS;
        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $sub_menu = trim($find_transaction->sub_menu);
//        $nbre = (int) $response;
        if ($response == "0") {
            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

            if (sizeof($all_menu) > 0) {
                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                $i = 1;

                if (sizeof($all_menu) < $nbre_show) {

                    foreach ($all_menu as $menu) {
                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                        $i++;
                    }
                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 0;
                } else {

                    $count = 0;
                    for ($i = 0; $i < $nbre_show; $i++) {
                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                        $count++;
                    }

                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 1;
                }
                $find_transaction->message_send = $message;
            } else {
                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
            }

            $find_transaction->menu = -1;
            $find_transaction->sub_menu = 0;
            $find_transaction->save();
        } else {

            switch (trim($status)) {
                case "0":
//                        $message = "1. Meteo du jour\n2. Un autre jour\n3. aujourd'hui a ...\n4. Alerte météo\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                        $message = "Veuillez entrer le code du facturier: ";
                        $find_transaction->message_send = $message;
                        $find_transaction->sub_menu = 1;
                        $find_transaction->save();
                   
                 break;

                case "1":
                    
                    switch (trim($sub_menu)) {
                        case "1":
//                        return 11;
                            $facturier = User::find()->where(['status'=>10,'identifiant'=>$response])->one();
//                             return $editeur->id;
                            if(sizeof($facturier)==1 && $facturier->typeUser->designation=="facturier"){
                                    $message = "Veuillez entrer votre reference client: ";
                                    $orther='"facturierIdentif":"'.$response.'"';
                                    $find_transaction->others = $orther;
                                    $find_transaction->message_send=$message;
                                    $find_transaction->sub_menu = 2;
                                    $find_transaction->save();
//                                return $activites;
                            }else{
                                 $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send;
                            }

                            break;
                        case "2":
                            $message=\Yii::t('app', 'SELECTIONER LE MOIS');
//                            $mois = "";
                            for ($d = 1; $d <= 12; $d++) {
                                 $months[] = date("F Y", strtotime( date( 'Y-m-01' )." -$d months"));
                             }
                            $all_months = array_reverse($months);
                                $i=1;
                                if(sizeof($all_months)< $nbre_show ){
                                    return 1;
                                        foreach ($all_months as $month){
                                                $message.="\n".$i.". ".$month;
                                                $i++;
                                        }
                                        $find_transaction->page_menu=0;
                                }else{
//                                  return 11;
                                        $count=0;
                                        for($i=0;$i<$nbre_show;$i++){											
                                                $message.="\n".($i+1).". ".$all_months[$i];
                                                $count++;
                                        }
//                                        

                                        $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
                                        $find_transaction->page_menu=1;	
//                                         return 11;
                                }
                                $orther = $find_transaction->others . ',"refClient":"' . $response . '"';
                                $find_transaction->others = $orther;
                                $find_transaction->message_send = $message;
                                $find_transaction->sub_menu = 3;
                                $find_transaction->save();
                            break;
                        case "3":
                             if($response==$previor_show){
                                      for ($d = 1; $d <= 12; $d++) {
                                    $months[] = date("F Y", strtotime(date('Y-m-01') . " -$d months"));
                                }
                                $all_months = array_reverse($months);
//                                        $all_categorie=Categorie::find()->orderBy('name ASC')->all();

                                    if(sizeof($all_months)>0){

                                            $page_actuelle=(int)$find_transaction->page_menu;

                                            $message="";
                                            if($page_actuelle>1){

                                                    $start=($page_actuelle-2)*$nbre_show;

                                                    $count=0;
                                                    for($i=$start;$i<($nbre_show+$start);$i++){	
                                                            if($i<sizeof($all_months)){

                                                                    if($message!="")$message.="\n";
                                                                    $message.=($i+1).". ".$all_months[$i];
                                                                    $count++;
                                                            }
                                                    }

                                                    if($start>0){
                                                            $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                    }else{
                                                            $message=\Yii::t('app', 'SELECT_MONTH')."\n".$message."\n";											 
                                                    }
                                                    $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');

                                                    $find_transaction->page_menu=$page_actuelle-1;

                                            }else{

                                                    $message=\Yii::t('app', 'SELECTIONNER LE MOIS');

                                                    for($i=0;$i<$nbre_show;$i++){	
                                                            if($i<=sizeof($all_months)){
                                                                    $message.="\n".($i+1).". ".$all_months[$i];
                                                            }
                                                    }											

                                                    $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                            }


                                            $find_transaction->message_send=$message;	

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else if($response==$nest_show){
                                    
                                         for ($d = 1; $d <= 12; $d++) {
                                    $months[] = date("F Y", strtotime(date('Y-m-01') . " -$d months"));
                                }
                                $all_months = array_reverse($months);
                                        if(sizeof($all_months)>0){
                                                $message="";
                                                $i=1;

                                                $page_actuelle=(int)$find_transaction->page_menu;
                                                $start=$page_actuelle*$nbre_show;

                                                if(sizeof($all_months)<($nbre_show+$start) ){
                                                    

                                                        $nbre_reste=sizeof($all_months)-$start;


                                                        if($nbre_reste>=1){
                                                                $count=0;
                                                                for($i=$start;$i<($nbre_reste+$start);$i++){
                                                                    if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$all_months[$i];
                                                                        $count++;
                                                                }

                                                                if($page_actuelle>0){
                                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                                }

                                                                if($count==$nbre_show){
                                                                        if(sizeof($all_months)>($nbre_show+$start)){
                                                                                $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                        }
                                                                }

                                                                $find_transaction->page_menu=$page_actuelle+1;
                                                        }else{

                                                                $start=($page_actuelle-1)*$nbre_show;
                                                                for($i=$start;$i<sizeof($all_months);$i++){
                                                                        if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$all_months[$i];
                                                                }
                                                                $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');

                                                        }

                                                }else{

                                                        $count=0;
                                                        for($i=$start;$i<($nbre_show+$start);$i++){		
                                                                if($message!="")$message.="\n";
                                                                $message.=($i+1).". ".$all_months[$i];
                                                                $count++;
                                                        }

                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        if($count==$nbre_show){
                                                                if(sizeof($all_months)>($nbre_show+$start)){
                                                                        $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                }
                                                        }

                                                        $find_transaction->page_menu=$page_actuelle+1;
                                                }
                                                $find_transaction->message_send=$message;

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									

                                        $find_transaction->save();

                                }else{
                                    $recup_information = Json::decode("[{" . $find_transaction->others . "}]");
                                    $information = $recup_information[0];
                                    $identifiant = $information['facturierIdentif'];
                                    $refClient = $information['refClient'];
                                    $facturier = User::find()->where(['status' => 10, 'identifiant' => $identifiant])->one();
                                   if(sizeof($facturier)==1 && $facturier->typeUser->designation=="facturier"){
                                       $config = ConfigFacturier::findOne(['userId'=>$facturier->id,'etat'=>1]);
                                       if(sizeof($config)==1){
                                          for ($d = 1; $d <= 12; $d++) {
                                                $months[] = date("F Y", strtotime( date( 'Y-m-01' )." -$d months"));
                                            }
                                           $all_months = array_reverse($months);
                                           $mois = $all_months[(int)$response-1];
                                           
                                            $find_facture = \console\models\Factures::find()
                                              ->where([
                                                  'numero_client'=>$find_transaction->username,
                                                  'facturierId'=>$facturier->id,
                                                  'mois_facture'=>$mois,
                                                  'etat'=>1,
                                                      ])
                                                    ->one();
//                                        RETURN 212121;
                                            
                                            if(sizeof($find_facture)==1){
                                                 $sms = "Vous pouvez imprimer votre facture via cette adresse: https://www.e-tikets.online/impression/".$find_facture->code;
                                                 $message= "DEMANDE IMPRESSION FACTURE EFFECTUEE AVEC SUCCEES";
                                                //send sms
                                                $this->send_sms($sms, $find_transaction->username);
                                            }else{
                                                 $url = $config->url_api;
                                                 $facture = $this->get_facture($find_transaction->username,$refClient,$facturier->id,$url,$mois); 
                                               $message = $facture;
                                            }
                                               $sms = "Vous pouvez imprimer votre facture via cette adresse: https://www.e-tikets.online/impression/".$find_facture->code;
                                               $orther = $find_transaction->others . ',"mois":"' . $mois . '"';
                                               $find_transaction->others = $orther;
                                               $find_transaction->sub_menu = 4;
                                               $find_transaction->etat_transaction = 1;
                                               $find_transaction->message_send = $message;
                                               $find_transaction->message = $sms;
                                               $find_transaction->save(); 
                                          
                                       } else {
                                        $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                                     }
//                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
//                                    $find_transaction->etat_transaction = 2;                        return 12;
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                                    							
                          }	
                            
                        break;
                      
                    }
                    break;
            }
        }
        return $message;
    }
    
     public function get_facture($numeroClient ,$refClient,$idFacturier,$urlFacturier,$mois) {

        $fields = array(
         'refClient' => $refClient,
         'mois' => $mois,
         );
        $ch = curl_init($urlFacturier);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch,CURLOPT_URL, $urlFacturier);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        $content = trim($result);
        
               
        $recup_message = Json::decode($content);
        $all_msg= "";
        $status = $recup_message['status'];
//          return $status;
//        return $status;
        if($status =="ok"){
            $facture = new \console\models\Factures;
            $facture->numero_client = $numeroClient;
            $facture->facturierId = $idFacturier;
            $facture->mois_facture = $mois;
            $facture->response = json_encode($recup_message['factures']);
            $facture->code = "F".rand(10000,99999);
            $facture->date = date("Y-m-d H:i:s");
            $facture->etat = 1;
            if($facture->save()){
                $all_msg = "DEMANDE IMPRESSION FACTURE EFFECTUEE AVEC SUCCEES";
                $sms= "Vous pouvez imprimer votre facture via cette adresse: https://www.e-tikets.online/impression/".$facture->code;
                //send_sms
                $this->send_sms($sms, $numeroClient);
            }
        }else{
            $all_msg = $recup_message['message'];
        }
       return trim($all_msg);
    }
    
    public function impression_ticket($res, $id_trans, $status) {
//        return 1111;
        $id_trans = trim($id_trans);
        $response = trim($res);
          

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $prix_unitaire = ConsoleappinitController::PRIX_METEO;
        $prix_unitaire_mois = ConsoleappinitController::PRIX_METEO_MOIS;
        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $sub_menu = trim($find_transaction->sub_menu);
//        $nbre = (int) $response;
        if ($response == "0") {
            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

            if (sizeof($all_menu) > 0) {
                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                $i = 1;

                if (sizeof($all_menu) < $nbre_show) {

                    foreach ($all_menu as $menu) {
                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                        $i++;
                    }
                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 0;
                } else {

                    $count = 0;
                    for ($i = 0; $i < $nbre_show; $i++) {
                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                        $count++;
                    }

                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 1;
                }
                $find_transaction->message_send = $message;
            } else {
                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
            }

            $find_transaction->menu = -1;
            $find_transaction->sub_menu = 0;
            $find_transaction->save();
        } else {

            switch (trim($status)) {
                case "0":
//                        $message = "1. Meteo du jour\n2. Un autre jour\n3. aujourd'hui a ...\n4. Alerte météo\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                        $message = "Veuillez entrer le code du ticket: ";
                        $find_transaction->message_send = $message;
                        $find_transaction->sub_menu = 1;
                        $find_transaction->save();
                   
                 break;

                case "1":
                    
                    switch (trim($sub_menu)) {
                        case "1":
                               if (is_numeric($response)) {
                                 $ticket = AchatDetails::find()->where(['code'=>$response,'etat'=>1])->one();
//                              return $editeur->id;
                                        if(sizeof($ticket)==1){
//                                            return 11;
                                            $message = "DEMANDE IMPRESSION TICKET EFFECTUEE AVEC SUCCEES";
                                            $sms = "#".$ticket->code."#.Vous pouvez imprimer votre facture via cette adresse: https://www.e-tikets.online/impression/".$ticket->code;
                                            $orther='"codeTicket":"'.$response.'"';
                                            $find_transaction->others = $orther;
                                            $find_transaction->message_send=$message;
                                            $find_transaction->message=$sms;
                                            $find_transaction->etat_transaction = 1;
                                            $find_transaction->sub_menu = 2;
                                            $find_transaction->save();
                                                //send sms
                                            $this->send_sms($sms, $find_transaction->username);
                                        }else{
                                             $message = \Yii::t('app', 'LE TICKET N\'EXISTE PAS') . "\n" . $find_transaction->message_send;
                                        }
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                        break;
                    }
                break;
            }
        }
        return $message;
    }
    
    
      public function top_evenement($res, $id_trans, $status) {
      
        $id_trans = trim($id_trans);
        $response = trim($res);
          

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $prix_unitaire = ConsoleappinitController::PRIX_METEO;
        $prix_unitaire_mois = ConsoleappinitController::PRIX_METEO_MOIS;
        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $sub_menu = trim($find_transaction->sub_menu);
//        $nbre = (int) $response;
        if ($response == "0") {
            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

            if (sizeof($all_menu) > 0) {
                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                $i = 1;

                if (sizeof($all_menu) < $nbre_show) {

                    foreach ($all_menu as $menu) {
                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                        $i++;
                    }
                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 0;
                } else {

                    $count = 0;
                    for ($i = 0; $i < $nbre_show; $i++) {
                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                        $count++;
                    }

                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 1;
                }
                $find_transaction->message_send = $message;
            } else {
                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
            }

            $find_transaction->menu = -1;
            $find_transaction->sub_menu = 0;
            $find_transaction->save();
        } else {

            switch (trim($status)) {
                case "0":
                         $date = date("Y-m-d H:i:s");
                        $evenements = TopEvenement::find()->where("date_fin > '".$date."' and etat=1")->all();
//                               return 1111;
                         if (sizeof($evenements) > 0) {
                                    $message = \Yii::t('app', 'TOP EVENEMENTS');
                                    $i = 1;
                                    if (sizeof($evenements) < $nbre_show) {

                                        foreach ($evenements as $act) {
                                            if($act->activite->etat ==1){
                                                $message .= "\n" . $i . ". " . $act->activite->designation;
                                                $i++;
                                            }
                                        }
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            if($evenements[$i]->activite->etat ==1){
                                            $message .= "\n" . ($i + 1) . ". " . $evenements[$i]->activite->designation;
                                            $count++;
                                            }
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $find_transaction->page_menu = 1;
                                    }
                                } else {
                                    $message = \Yii::t('app', 'AUCUNE TOP ACTIVITE');
                                    $find_transaction->etat_transaction = 1;
                                }
                                $find_transaction->message_send = $message;
                                $find_transaction->sub_menu = 1;
                                $find_transaction->save();
                                break;

                case "1":
                    switch (trim($sub_menu)) {
                        case "1":
                          if($response==$previor_show){
                               $date = date("Y-m-d H:i:s");
                                   $evenements = TopEvenement::find()->where("date_fin > '".$date."' and etat=1")->all();
                                    if(sizeof($evenements)>0){
                                            $page_actuelle=(int)$find_transaction->page_menu;

                                            $message="";
                                            if($page_actuelle>1){

                                                    $start=($page_actuelle-2)*$nbre_show;

                                                    $count=0;
                                                    for($i=$start;$i<($nbre_show+$start);$i++){	
                                                            if($i<sizeof($evenements)){

                                                                    if($message!="")$message.="\n";
                                                                    $message.=($i+1).". ".$evenements[$i]->activite->designation;
                                                                    $count++;
                                                            }
                                                    }

                                                    if($start>0){
                                                            $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                    }else{
                                                            $message=\Yii::t('app', 'TOP EVENEMENTS')."\n".$message."\n";											 
                                                    }
                                                    $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');

                                                    $find_transaction->page_menu=$page_actuelle-1;

                                            }else{

                                                    $message=\Yii::t('app', 'TOP EVENEMENTS');

                                                    for($i=0;$i<$nbre_show;$i++){	
                                                            if($i<=sizeof($evenements)){
                                                                    $message.="\n".($i+1).". ".$evenements[$i]->activite->designation;
                                                            }
                                                    }											

                                                    $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                            }


                                            $find_transaction->message_send=$message;	

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else if($response==$nest_show){
                                     $date = date("Y-m-d H:i:s");
                                      $evenements = TopEvenement::find()->where("date_fin > '".$date."' and etat=1")->all();
                                     
                                        if(sizeof($evenements)>0){
                                                $message="";
                                                $i=1;

                                                $page_actuelle=(int)$find_transaction->page_menu;
                                                $start=$page_actuelle*$nbre_show;

                                                if(sizeof($evenements)<($nbre_show+$start) ){
                                                    

                                                        $nbre_reste=sizeof($evenements)-$start;


                                                        if($nbre_reste>=1){
                                                             $message=\Yii::t('app', 'TOP EVENEMENTS');
                                                                $count=0;
                                                                for($i=$start;$i<($nbre_reste+$start);$i++){
                                                                    if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$evenements[$i]->activite->designation;
                                                                        $count++;
                                                                }

                                                                if($page_actuelle>0){
                                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                                }

                                                                if($count==$nbre_show){
                                                                        if(sizeof($evenements)>($nbre_show+$start)){
                                                                                $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                        }
                                                                }

                                                                $find_transaction->page_menu=$page_actuelle+1;
                                                        }else{
                                                             $message=\Yii::t('app', 'TOP EVENEMENTS');

                                                                $start=($page_actuelle-1)*$nbre_show;
                                                                for($i=$start;$i<sizeof($evenements);$i++){
                                                                        if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$evenements[$i]->activite->designation;
                                                                }
                                                                $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');

                                                        }

                                                }else{
                                                         $message=\Yii::t('app', 'TOP EVENEMENTS');
                                                        $count=0;
                                                        for($i=$start;$i<($nbre_show+$start);$i++){		
                                                                if($message!="")$message.="\n";
                                                                $message.=($i+1).". ".$evenements[$i]->activite->designation;
                                                                $count++;
                                                        }

                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        if($count==$nbre_show){
                                                                if(sizeof($activites)>($nbre_show+$start)){
                                                                        $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                }
                                                        }

                                                        $find_transaction->page_menu=$page_actuelle+1;
                                                }
                                                $find_transaction->message_send=$message;

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									


                                        $find_transaction->save();

                                }else{
                                 $date = date("Y-m-d H:i:s");
                                 $evenements = TopEvenement::find()->where("date_fin > '".$date."' and etat=1")->all();
                                    if((int)$response<=sizeof($evenements)){
                                        $evenement = $evenements[(int) $response - 1];
//                                        return $evenements[2];
                                        $message = "TOP EVENEMENT CONSULTE AVEC SUCCEES";
                                        $msg = $evenement->message;
                                        $orther='"evenementId":"'.$evenement->id.'"';
                                        $find_transaction->others = $orther;
                                        $find_transaction->message_send = $message;
                                        $find_transaction->message = $msg;
                                        $find_transaction->etat_transaction = 1;                                        
                                        $find_transaction->sub_menu = 2;
                                        $find_transaction->save();
                                        //send sms
                                        $this->send_sms($msg, $find_transaction->username);
                                    }else{
                                        $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
                                    }									
                                }	
                            break;
                    }
                    break;
            }
        }
        return $message;
    }

   public function publier_recolte($response,$id_trans,$status){		
	   
	    $nbre_show=ConsoleappinitController::MENU_SYSTEME;
	    $nest_show=ConsoleappinitController::SUIVANT_SYSTEME;
	    $previor_show=ConsoleappinitController::PRECEDENT_SYSTEME;
		
		$id_trans=trim($id_trans);
		$response=trim($response);
		
		$find_transaction = Ussdtransation::findOne(['id'=>$id_trans]);
		
		$sub_menu=trim($find_transaction->sub_menu);
		
		
		switch (trim($status)) {
					case "0":
						$message=\Yii::t('app', 'SELECT_BUSY')."\n1. ".\Yii::t('app', 'OFFRE')."\n2. ".\Yii::t('app', 'DEMANDE')."\n3. ".\Yii::t('app', 'TROC');
						$find_transaction->message_send=$message;
						$find_transaction->save();
					break;
					case "1":
					
					    switch (trim($sub_menu)) {
							case "1":
						
								$info_response=array("1"=>"OFFRE","2"=>"DEMANDE","3"=>"TROC");
								
								if($response<=sizeof($info_response) and $response!="0"){
									
										$all_categorie=Categorie::find()->orderBy('name ASC')->all();
					
										if(sizeof($all_categorie)>0){
										
											$message=\Yii::t('app', 'SELECT_CATEGORIE');
											$i=1;
											
											if(sizeof($all_categorie)< $nbre_show ){
												
												foreach ($all_categorie as $categorie){
													$message.="\n".$i.". ".$categorie->name;
													$i++;
												}
												$find_transaction->page_menu=0;
											}else{
												
												$count=0;
												for($i=0;$i<$nbre_show;$i++){											
													$message.="\n".($i+1).". ".$all_categorie[$i]->name;
													$count++;
												}
												
												$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
												$find_transaction->page_menu=1;											
											}
											
											$find_transaction->message_send=$message;
										}else{
											$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
											$find_transaction->etat_transaction=2;
										}									
											
										$orther='"biztypeId":"'.$response.'"';
										$info_message=\Yii::t('app', $info_response[$response]);
										$find_transaction->others=$orther;
										$find_transaction->message=$info_message;
										$find_transaction->sub_menu="20";
										$find_transaction->save();
									
									}else{
										
										$message =\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
										$find_transaction->save();
									}							
								
							break;
							
							case "20":	
									
								if($response==$previor_show){
								
									$all_categorie=Categorie::find()->orderBy('name ASC')->all();
				
									if(sizeof($all_categorie)>0){
										
										
										$page_actuelle=(int)$find_transaction->page_menu;
										
										$message="";
										if($page_actuelle>1){
										
											$start=($page_actuelle-2)*$nbre_show;
											
											$count=0;
											for($i=$start;$i<($nbre_show+$start);$i++){	
												if($i<sizeof($all_categorie)){
													
													if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_categorie[$i]->name;
													$count++;
												}
											}
											
											if($start>0){
												$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
											}else{
												$message=\Yii::t('app', 'SELECT_CATEGORIE')."\n".$message."\n";											 
											}
											$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
											
											$find_transaction->page_menu=$page_actuelle-1;
											
										}else{
										
											$message=\Yii::t('app', 'SELECT_CATEGORIE');
											
											for($i=0;$i<$nbre_show;$i++){	
												if($i<=sizeof($all_categorie)){
													$message.="\n".($i+1).". ".$all_categorie[$i]->name;
												}
											}											
											
											$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
										}
										
										
										$find_transaction->message_send=$message;	
										
									}else{
										$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
										$find_transaction->etat_transaction=2;
									}									
										
																		
									$find_transaction->save();
								
								}else if($response==$nest_show){
								
									$all_categorie=Categorie::find()->orderBy('name ASC')->all();
				
									if(sizeof($all_categorie)>0){
										$message="";
										$i=1;
										
										$page_actuelle=(int)$find_transaction->page_menu;
										$start=$page_actuelle*$nbre_show;
										
										if(sizeof($all_categorie)<($nbre_show+$start) ){
											
											$nbre_reste=sizeof($all_categorie)-$start;
											
											
											if($nbre_reste>=1){
												$count=0;
												for($i=$start;$i<($nbre_reste+$start);$i++){
												    if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_categorie[$i]->name;
													$count++;
												}
												
												if($page_actuelle>0){
													$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
												}
												
												if($count==$nbre_show){
													if(sizeof($all_categorie)>($nbre_show+$start)){
														$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
													}
												}
												
												$find_transaction->page_menu=$page_actuelle+1;
											}else{
											
												$start=($page_actuelle-1)*$nbre_show;
												for($i=$start;$i<sizeof($all_categorie);$i++){
													if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_categorie[$i]->name;
												}
												$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
												
											}
											
										}else{
											
											$count=0;
											for($i=$start;$i<($nbre_show+$start);$i++){		
												if($message!="")$message.="\n";
												$message.=($i+1).". ".$all_categorie[$i]->name;
												$count++;
											}
											
											$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
											if($count==$nbre_show){
												if(sizeof($all_categorie)>($nbre_show+$start)){
													$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
												}
											}
											
											$find_transaction->page_menu=$page_actuelle+1;
										}
										$find_transaction->message_send=$message;
										
									}else{
										$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
										$find_transaction->etat_transaction=2;
									}									
										
																		
									$find_transaction->save();
								
								}else{
								
										$all_categorie=Categorie::find()->orderBy('name ASC')->all();
						
										if((int)$response<=sizeof($all_categorie)){
										
											$categorie=$all_categorie[(int)$response-1];
											
											$all_produit=CategorieFille::find()->where(['categorieId'=>$categorie->id])->orderBy('nomCategorie_fille ASC')->all();					
											if(sizeof($all_produit)>0){

												$message=\Yii::t('app', 'SELECT_PRODUIT');
												$i=1;
												
												if(sizeof($all_produit)< $nbre_show ){
													
													foreach ($all_produit as $produit){
														$message.="\n".$i.". ".$produit->nomCategorie_fille;
														$i++;
													}
													$find_transaction->page_menu=0;
												}else{
													
													$count=0;
													for($i=0;$i<$nbre_show;$i++){											
														$message.="\n".($i+1).". ".$all_produit[$i]->nomCategorie_fille;
														$count++;
													}
													
													$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
													$find_transaction->page_menu=1;											
												}
												
												$find_transaction->message_send=$message;
											}else{
												$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
												$find_transaction->etat_transaction=2;
											}
											
											$orther=$find_transaction->others.',"categorieId0":"'.$categorie->id.'"';
											
											$find_transaction->message_send=$message;
											$find_transaction->others=$orther;
											$find_transaction->sub_menu=2;
											$find_transaction->save();											
											
											
										}else{
											$message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
										}									
								}	
							break;
							
							case "2":	
								$recup_information=Json::decode("[{".$find_transaction->others."}]");										
								$information=$recup_information[0];	
								$idcategorie= $information['categorieId0'];
									
								if($response==$previor_show){
								
									$all_produit=CategorieFille::find()->where(['categorieId'=>$idcategorie])->orderBy('nomCategorie_fille ASC')->all();
				
									if(sizeof($all_produit)>0){
										
										
										$page_actuelle=(int)$find_transaction->page_menu;
										
										if($page_actuelle>1){
										
											$message="";
											$start=($page_actuelle-2)*$nbre_show;
											
											$count=0;
											for($i=$start;$i<($nbre_show+$start);$i++){	
												if($i<sizeof($all_produit)){
													if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
													$count++;
												}
											}
											
											if($start>0){
												$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
											}else{
												$message=\Yii::t('app', 'SELECT_PRODUIT')."\n".$message."\n";
											}
											$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
											
											$find_transaction->page_menu=$page_actuelle-1;
											
										}else{
										
											$message=\Yii::t('app', 'SELECT_PRODUIT');
											
											for($i=0;$i<$nbre_show;$i++){	
												if($i<=sizeof($all_produit)){
													if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
												}
											}											
											
											$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
										}
										
										
										$find_transaction->message_send=$message;	
										
									}else{
										$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
										$find_transaction->etat_transaction=2;
									}									
										
																		
									$find_transaction->save();
								
								}else if($response==$nest_show){
								
									$all_produit=CategorieFille::find()->where(['categorieId'=>$idcategorie])->orderBy('nomCategorie_fille ASC')->all();
				
									if(sizeof($all_produit)>0){
										$message="";
										$i=1;
										
										$page_actuelle=(int)$find_transaction->page_menu;
										$start=$page_actuelle*$nbre_show;
										
										if(sizeof($all_produit)<($nbre_show+$start) ){
											
											$nbre_reste=sizeof($all_produit)-$start;
											
											
											if($nbre_reste>=1){
												$count=0;
												for($i=$start;$i<($nbre_reste+$start);$i++){	
													if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
													$count++;
												}
												
												if($page_actuelle>0){
													$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
												}
												
												if($count==$nbre_show){
													if(sizeof($all_produit)>($nbre_show+$start)){
														$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
													}
												}
												
												$find_transaction->page_menu=$page_actuelle+1;
											}else{
											
												$start=($page_actuelle-1)*$nbre_show;
												for($i=$start;$i<sizeof($all_produit);$i++){
													if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
												}
												$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
												
											}
											
										}else{
											
											$count=0;
											for($i=$start;$i<($nbre_show+$start);$i++){	
												if($message!="")$message.="\n";
												$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
												$count++;
											}
											
											$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
											if($count==$nbre_show){
												if(sizeof($all_produit)>($nbre_show+$start)){
													$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
												}
											}
											
											$find_transaction->page_menu=$page_actuelle+1;
										}
										$find_transaction->message_send=$message;
										
									}else{
										$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
										$find_transaction->etat_transaction=2;
									}									
										
																		
									$find_transaction->save();
								
								}else{
								
										$all_produit=CategorieFille::find()->where(['categorieId'=>$idcategorie])->orderBy('nomCategorie_fille ASC')->all();
						
										if((int)$response<=sizeof($all_produit)){
										
											$produit=$all_produit[((int)$response)-1];											
											$infoU_categorie=CategorieFille::findOne(['id' => $produit->id]);
											$unites_categories=Json::decode($infoU_categorie->unite_mesure);
											
											$all_unites=Unites::find()->where(['id'=>$unites_categories])->orderBy('nom ASC')->all();		
											if(sizeof($all_unites)>0){
													$message=\Yii::t('app', 'UNITE');
													$i=1;
													
													
													
													if(sizeof($all_unites)< $nbre_show ){
														
														foreach ($all_unites as $unites){
															$message.="\n".$i.". ".$unites->nom;
															$i++;
														}
														$find_transaction->page_menu=0;
													}else{
														
														$count=0;
														for($i=0;$i<$nbre_show;$i++){											
															$message.="\n".($i+1).". ".$all_unites[$i]->nom;
															$count++;
														}
														
														$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
														$find_transaction->page_menu=1;
														
													}
													$find_transaction->message_send=$message;
													
											}else{
												$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
												$find_transaction->etat_transaction=2;
											}	                                    
											
											
											
											$info_message=$find_transaction->message." ".\Yii::t('app', 'OF')." ".$produit->nomCategorie_fille;
											$find_transaction->message=$info_message;
											
											$orther=$find_transaction->others.',"categorieId":"'.$produit->id.'"';
											
											$find_transaction->message_send=$message;
											$find_transaction->others=$orther;
											$find_transaction->message=$info_message;
											$find_transaction->sub_menu=3;
											$find_transaction->save();
											
										}else{
											$message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
										}
									
								}	
							break;
							
							case "3":							
								    $recup_information=Json::decode("[{".$find_transaction->others."}]");										
									$information=$recup_information[0];	
									$idcategorie= $information['categorieId'];
									$infoU_categorie=CategorieFille::findOne(['id' => $idcategorie]);
									$unites_categories=Json::decode($infoU_categorie->unite_mesure);
									$all_unites=Unites::find()->where(['id'=>$unites_categories])->orderBy('nom ASC')->all();
										
									if($response==$previor_show){
									
					
										if(sizeof($all_unites)>0){
											
											
											$page_actuelle=(int)$find_transaction->page_menu;
											
											if($page_actuelle>1){
											
												$message="";
												$start=($page_actuelle-2)*$nbre_show;
												
												$count=0;
												for($i=$start;$i<($nbre_show+$start);$i++){	
													if($i<sizeof($all_unites)){
														if($message!="")$message.="\n";
														$message.=($i+1).". ".$all_unites[$i]->nom;
														$count++;
													}
												}
												
												if($start>0){
													$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
												}else{
													$message=\Yii::t('app', 'SELECT_PRODUIT')."\n".$message."\n";
												}
												$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
												
												$find_transaction->page_menu=$page_actuelle-1;
												
											}else{
											
												$message=\Yii::t('app', 'UNITE');
												
												for($i=0;$i<$nbre_show;$i++){	
													if($i<=sizeof($all_unites)){
														$message.="\n".($i+1).". ".$all_unites[$i]->nom;
													}
												}											
												
												$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
											}
											
											$find_transaction->message_send=$message;
											
											
										}else{
											$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
											$find_transaction->etat_transaction=2;
										}									
											
																			
										$find_transaction->save();
									
									}else if($response==$nest_show){
									
										
										if(sizeof($all_unites)>0){
											$message="";
											$i=1;
											
											$page_actuelle=(int)$find_transaction->page_menu;
											$start=$page_actuelle*$nbre_show;
											
											if(sizeof($all_unites)<($nbre_show+$start) ){
												
												$nbre_reste=sizeof($all_unites)-$start;											
												
												if($nbre_reste>=1){
													$count=0;
													for($i=$start;$i<($nbre_reste+$start);$i++){
														if($message!="")$message.="\n";
														$message.=($i+1).". ".$all_unites[$i]->nom;
														$count++;
													}
													
													if($page_actuelle>0){
														$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
													}
													
													if($count==$nbre_show){
														if(sizeof($all_unites)>($nbre_show+$start)){
															$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
														}
													}
													
													$find_transaction->page_menu=$page_actuelle+1;
												}else{
												
													$start=($page_actuelle-1)*$nbre_show;
													for($i=$start;$i<sizeof($all_unites);$i++){	
														if($message!="")$message.="\n";
														$message.=($i+1).". ".$all_unites[$i]->nom;
													}
													$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
													
												}
												
											}else{
												
												$count=0;
												for($i=$start;$i<($nbre_show+$start);$i++){	
													if($message!="")$message.="\n";
													$message.=($i+1).". ".$all_unites[$i]->nom;
													$count++;
												}
												
												$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
												if($count==$nbre_show){
													if(sizeof($all_unites)>($nbre_show+$start)){
														$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
													}
												}
												
												$find_transaction->page_menu=$page_actuelle+1;
											}
											$find_transaction->message_send=$message;
											
										}else{
											$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
											$find_transaction->etat_transaction=2;
										}									
											
																			
										$find_transaction->save();
									
									}else{
										
										if((int)$response<=sizeof($all_unites)){
										
											$message=\Yii::t('app', 'ENTER_QTE');	
											
											
											$unites=$all_unites[((int)$response)-1];
								

											$orther=$find_transaction->others.',"unitesId":"'.$unites->id.'"';
											$find_transaction->others=$orther;								
											$find_transaction->sub_menu=4;
											$find_transaction->save();
											
										}else{
											
											$message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
										}
							
									}
							
									
							break;
							default:
									$recup_information=Json::decode("[{".$find_transaction->others."}]");										
									$information=$recup_information[0];	
									
									$biztypeId= $information['biztypeId'];
														
									if($biztypeId=="1" or $biztypeId=="2"){
									
										switch (trim($sub_menu)) {
											
											case "4":
														$message=\Yii::t('app', 'PRIX_UNITAIRE')." (F cfa)";															
														
											    		$info_message=$find_transaction->message."  ".$response;											
														$orther=$find_transaction->others.',"stock":"'.$response.'"';
														$find_transaction->others=$orther;								
														$find_transaction->message=$info_message;								
														$find_transaction->sub_menu=5;
														$find_transaction->save();
										
												break;
											case "5":
											     
											
													
													$recup_information=Json::decode("[{".$find_transaction->others."}]");										
													$information=$recup_information[0];	
												    $unites=Unites::findOne(['id'=>$information['unitesId']]);	
											
											
													$message=\Yii::t('app', 'EMPLACEMENT');	
													
													$info_message=$find_transaction->message." ".$unites->abrev.". ".\Yii::t('app', 'PRIX').": ".$response."F CFA/".$unites->abrev." ".\Yii::t('app', 'DISPONIBLE');												
													$orther=$find_transaction->others.',"prix":"'.$response.'"';
													
													$find_transaction->message=$info_message;
													$find_transaction->others=$orther;
													$find_transaction->sub_menu=6;
													$find_transaction->save();
												break;
											case "6":
											
													$info_message=$find_transaction->message." ".$response;
													$message=$info_message."\n\n1. ".\Yii::t('app', 'CONFIRMER')."\n2. ".\Yii::t('app', 'ANNULER');
													
													
													$orther=$find_transaction->others.',"lieu":"'.$response.'"';
													
													$find_transaction->message=$info_message;
													$find_transaction->message_send=$message;
													$find_transaction->others=$orther;
													$find_transaction->sub_menu=7;
													$find_transaction->save();
													
												break;
											case "7":
													if($response=="1"){
														
														//enregistrement du produit
														
														
														$recup_information=Json::decode("[{".$find_transaction->others."}]");										
														$information=$recup_information[0];	
														
														$model=new Annonce();
														
														$model->userId = $find_transaction->iduser;
														$model->methodeId = 3;
														$model->deviseId = 2;
														$model->time =time();
														$model->createdBy = $find_transaction->iduser;
														$model->modifiedBy= $find_transaction->iduser;
														$model->reference = Yii::$app->security->generateRandomString();
														$model->unitesId= $information['unitesId'];
														$model->stock= $information['stock'];
														$model->prix= $information['prix'];
														$model->categorieId= $information['categorieId'];
														$model->biztypeId= $information['biztypeId'];
														$model->lieu= $information['lieu'];
														$model->uniqueCode="R".rand(100000,999999);
														
														//convertion du prix et de la quantite
														
														$convert=Unites::findOne(['id' => $model->unitesId]);
														$valeur_convert=$convert->valeur_convertir;
														
														$model->convert_quantite =$model->stock/$valeur_convert;
														$model->convert_prix =$model->prix/$valeur_convert;
														if($model->save()){
														
														
															//envoyer un message a l'annonceur
															
															$receiver=$find_transaction->username;
															$sender="E-agri";
															$sms=$find_transaction->message.". ".\Yii::t('app', 'CODE_ANNONCE1')." ".$model->uniqueCode.". ".\Yii::t('app', 'CODE_ANNONCE2').". ".\Yii::t('app', 'SUCCES_PUBLICATION');
															
															if($information['biztypeId']=="2"){
															$sms=$find_transaction->message.". ".\Yii::t('app', 'CODE_ANNONCE1')." ".$model->uniqueCode.". ".\Yii::t('app', 'CODE_ANNONCE3').". ".\Yii::t('app', 'SUCCES_PUBLICATION');
															}
															$this->send_sms($sms,$sender,$receiver);
															
															
															$message=\Yii::t('app', 'SUCCES_PUBLICATION');
														
															$find_transaction->message=$sms;
															$find_transaction->sub_menu=8;
															$find_transaction->etat_transaction=1;
															$find_transaction->save();
															
														}else{
															
														   $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
														}				
														
														
													}else{
														
														$all_menu=MenuUssd::find()->where(['status'=>'1'])->orderBy('position_menu_ussd ASC')->all();
													
														if(sizeof($all_menu)>0){
															
															$message=\Yii::t('app', 'WELCOME_EAGRI');
															$i=1;
												
															if(sizeof($all_menu)< $nbre_show ){
																
																foreach ($all_menu as $menu){
																	$message.="\n".$menu->position_menu_ussd.". ".$menu->denomination;
																	$i++;
																}
																$message.="\n\n0. ".\Yii::t('app', 'AIDE');
																$find_transaction->page_menu=0;
															}else{
																
																$count=0;
																for($i=0;$i<$nbre_show;$i++){											
																	$message.="\n".$all_menu[$i]->position_menu_ussd.". ".$all_menu[$i]->denomination;
																	
																	$count++;
																}
																
																$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');	
																$message.="\n0. ".\Yii::t('app', 'AIDE');
																$find_transaction->page_menu=1;
																
															}
															$find_transaction->message_send=$message;
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
														}
								
														$find_transaction->menu=-1;
														$find_transaction->save();
													}
												break;
														
											default:
												$message =\Yii::t('app', 'RESTART_TEST');
												$find_transaction->etat_transaction=2;
												$find_transaction->save();
												break;
										}
									
									}else if($biztypeId=="3"){
								
										switch (trim($sub_menu)) {
											
											case "4":										
														$recup_information=Json::decode("[{".$find_transaction->others."}]");										
														$information=$recup_information[0];	
														$unites=Unites::findOne(['id'=>$information['unitesId']]);											
											
													
														$message=\Yii::t('app', 'EMPLACEMENT');	
														$info_message=$find_transaction->message."  ".$response." ".$unites->abrev;											
														
														$find_transaction->message=$info_message;

														$orther=$find_transaction->others.',"stock":"'.$response.'"';
														$find_transaction->others=$orther;								
														$find_transaction->sub_menu=50;
														$find_transaction->save();
												
										
											break;
											case "50":
													
													$all_categorie=Categorie::find()->orderBy('name ASC')->all();
					
													if(sizeof($all_categorie)>0){
													
														$message=\Yii::t('app', 'SELECT_CATEGORIE_TROC');
														$i=1;
														
														if(sizeof($all_categorie)< $nbre_show ){
															
															foreach ($all_categorie as $categorie){
																$message.="\n".$i.". ".$categorie->name;
																$i++;
															}
															$find_transaction->page_menu=0;
														}else{
															
															$count=0;
															for($i=0;$i<$nbre_show;$i++){											
																$message.="\n".($i+1).". ".$all_categorie[$i]->name;
																$count++;
															}
															
															$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
															$find_transaction->page_menu=1;											
														}
														
														$find_transaction->message_send=$message;
													}else{
														$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
														$find_transaction->etat_transaction=2;
													}
												
													$orther=$find_transaction->others.',"lieu":"'.$response.'"';
													$info_message=$find_transaction->message." ".\Yii::t('app', 'DISPONIBLE')." ".$response;	
													
													$find_transaction->message=$info_message;
													$find_transaction->message_send=$message;
													$find_transaction->others=$orther;
													$find_transaction->sub_menu=5;
													$find_transaction->save();
											
											break;
											case "5":
													
													if($response==$previor_show){
								
														$all_categorie=Categorie::find()->orderBy('name ASC')->all();
									
														if(sizeof($all_categorie)>0){
															
															
															$page_actuelle=(int)$find_transaction->page_menu;
															
															if($page_actuelle>1){
															
																$message="";
																
																$start=($page_actuelle-2)*$nbre_show;
																
																$count=0;
																for($i=$start;$i<($nbre_show+$start);$i++){	
																	if($i<sizeof($all_categorie)){
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_categorie[$i]->name;
																		$count++;
																	}
																}
																
																if($start>0){
																	$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																}else{
																	$message=\Yii::t('app', 'SELECT_CATEGORIE_TROC')."\n".$message."\n";
																}
																$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																
																$find_transaction->page_menu=$page_actuelle-1;
																
															}else{
															
																$message=\Yii::t('app', 'SELECT_CATEGORIE_TROC');
																
																for($i=0;$i<$nbre_show;$i++){	
																	if($i<=sizeof($all_categorie)){
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_categorie[$i]->name;
																	}
																}											
																
																$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
															}
															
															
															$find_transaction->message_send=$message;	
															
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
															$find_transaction->etat_transaction=2;
														}									
															
																							
														$find_transaction->save();
													
													}else if($response==$nest_show){
													
														$all_categorie=Categorie::find()->orderBy('name ASC')->all();
									
														if(sizeof($all_categorie)>0){
															$message="";
															$i=1;
															
															$page_actuelle=(int)$find_transaction->page_menu;
															$start=$page_actuelle*$nbre_show;
															
															if(sizeof($all_categorie)<($nbre_show+$start) ){
																
																$nbre_reste=sizeof($all_categorie)-$start;
																
																
																if($nbre_reste>=1){
																	$count=0;
																	for($i=$start;$i<($nbre_reste+$start);$i++){	
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_categorie[$i]->name;
																		$count++;
																	}
																	
																	if($page_actuelle>0){
																		$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																	}
																	
																	if($count==$nbre_show){
																		if(sizeof($all_categorie)>($nbre_show+$start)){
																			$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																		}
																	}
																	
																	$find_transaction->page_menu=$page_actuelle+1;
																}else{
																
																	$start=($page_actuelle-1)*$nbre_show;
																	for($i=$start;$i<sizeof($all_categorie);$i++){	
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_categorie[$i]->name;
																	}
																	$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																	
																}
																
															}else{
																
																$count=0;
																for($i=$start;$i<($nbre_show+$start);$i++){	
																	if($message!="")$message.="\n";
																	$message.=($i+1).". ".$all_categorie[$i]->name;
																	$count++;
																}
																
																$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																if($count==$nbre_show){
																	if(sizeof($all_categorie)>($nbre_show+$start)){
																		$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																	}
																}
																
																$find_transaction->page_menu=$page_actuelle+1;
															}
															$find_transaction->message_send=$message;
															
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
															$find_transaction->etat_transaction=2;
														}									
															
																							
														$find_transaction->save();
													
													}else{
													
															$all_categorie=Categorie::find()->orderBy('name ASC')->all();
											
															if((int)$response<=sizeof($all_categorie)){
															
																$categorie=$all_categorie[(int)$response-1];
																
																$all_produit=CategorieFille::find()->where(['categorieId'=>$categorie->id])->orderBy('nomCategorie_fille ASC')->all();					
																if(sizeof($all_produit)>0){

																	$message=\Yii::t('app', 'SELECT_PRODUIT');
																	$i=1;
																	
																	if(sizeof($all_produit)< $nbre_show ){
																		
																		foreach ($all_produit as $produit){
																			$message.="\n".$i.". ".$produit->nomCategorie_fille;
																			$i++;
																		}
																		$find_transaction->page_menu=0;
																	}else{
																		
																		$count=0;
																		for($i=0;$i<$nbre_show;$i++){											
																			$message.="\n".($i+1).". ".$all_produit[$i]->nomCategorie_fille;
																			$count++;
																		}
																		
																		$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
																		$find_transaction->page_menu=1;											
																	}
																	
																	$find_transaction->message_send=$message;
																}else{
																	$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
																	$find_transaction->etat_transaction=2;
																}
																
																$orther=$find_transaction->others.',"categorieId02":"'.$categorie->id.'"';
																
																$find_transaction->message_send=$message;
																$find_transaction->others=$orther;
																$find_transaction->sub_menu=6;
																$find_transaction->save();											
																
																
															}else{
																$message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
															}									
													}	
							
											
											break;
											case "6":	
									
													$recup_information=Json::decode("[{".$find_transaction->others."}]");										
													$information=$recup_information[0];	
													$idcategorie= $information['categorieId02'];
								
													if($response==$previor_show){
													
														$all_produit=CategorieFille::find()->where(['categorieId'=>$idcategorie])->orderBy('nomCategorie_fille ASC')->all();
									
														if(sizeof($all_produit)>0){
															
															
															$page_actuelle=(int)$find_transaction->page_menu;
															
															if($page_actuelle>1){
															
																
																$message="";
																$start=($page_actuelle-2)*$nbre_show;
																
																$count=0;
																for($i=$start;$i<($nbre_show+$start);$i++){	
																	if($i<sizeof($all_produit)){
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
																		$count++;
																	}
																}
																
																if($start>0){
																	$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																}else{
																		$message=\Yii::t('app', 'PRODUIT_TROC')."\n".$message."\n";
																}
																$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																
																$find_transaction->page_menu=$page_actuelle-1;
																
															}else{
															
																$message=\Yii::t('app', 'PRODUIT_TROC');
																
																for($i=0;$i<$nbre_show;$i++){	
																	if($i<=sizeof($all_produit)){
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
																	}
																}											
																
																$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
															}
															
															
															$find_transaction->message_send=$message;	
															
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
															$find_transaction->etat_transaction=2;
														}									
															
																							
														$find_transaction->save();
													
													}else if($response==$nest_show){
													
														$all_produit=CategorieFille::find()->where(['categorieId'=>$idcategorie])->orderBy('nomCategorie_fille ASC')->all();
									
														if(sizeof($all_produit)>0){
															$message="";
															$i=1;
															
															$page_actuelle=(int)$find_transaction->page_menu;
															$start=$page_actuelle*$nbre_show;
															
															if(sizeof($all_produit)<($nbre_show+$start) ){
																
																$nbre_reste=sizeof($all_produit)-$start;
																
																
																if($nbre_reste>=1){
																	$count=0;
																	for($i=$start;$i<($nbre_reste+$start);$i++){
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
																		$count++;
																	}
																	
																	if($page_actuelle>0){
																		$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																	}
																	
																	if($count==$nbre_show){
																	if(sizeof($all_produit)>($nbre_show+$start)){
																		$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																	}
																}
																	
																	$find_transaction->page_menu=$page_actuelle+1;
																}else{
																
																	$start=($page_actuelle-1)*$nbre_show;
																	for($i=$start;$i<sizeof($all_produit);$i++){	
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
																	}
																	$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																	
																}
																
															}else{
																
																$count=0;
																for($i=$start;$i<($nbre_show+$start);$i++){	
																	if($message!="")$message.="\n";
																	$message.=($i+1).". ".$all_produit[$i]->nomCategorie_fille;
																	$count++;
																}
																
																$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																if($count==$nbre_show){
																	if(sizeof($all_produit)>($nbre_show+$start)){
																		$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																	}
																}
																
																$find_transaction->page_menu=$page_actuelle+1;
															}
															$find_transaction->message_send=$message;
															
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
															$find_transaction->etat_transaction=2;
														}									
															
																							
														$find_transaction->save();
													
													}else{
													
															$all_produit=CategorieFille::find()->where(['categorieId'=>$idcategorie])->orderBy('nomCategorie_fille ASC')->all();
											
															if((int)$response<=sizeof($all_produit)){
															
																                                    
																$produit=$all_produit[((int)$response)-1];
																$infoU_categorie=CategorieFille::findOne(['id' => $produit->id]);
																$unites_categories=Json::decode($infoU_categorie->unite_mesure);
																
																$all_unites=Unites::find()->where(['id'=>$unites_categories])->orderBy('nom ASC')->all();		
																if(sizeof($all_unites)>0){
																		$message=\Yii::t('app', 'UNITE');
																		$i=1;
																		
																		
																		
																		if(sizeof($all_unites)< $nbre_show ){
																			
																			foreach ($all_unites as $unites){
																				$message.="\n".$i.". ".$unites->nom;
																				$i++;
																			}
																			$find_transaction->page_menu=0;
																		}else{
																			
																			$count=0;
																			for($i=0;$i<$nbre_show;$i++){											
																				$message.="\n".($i+1).". ".$all_unites[$i]->nom;
																				$count++;
																			}
																			
																			$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
																			$find_transaction->page_menu=1;
																			
																		}
																		$find_transaction->message_send=$message;
																		
																}else{
																	$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
																	$find_transaction->etat_transaction=2;
																}					
																
																$info_message=$find_transaction->message." ".\Yii::t('app', 'CONTRE')." ".$produit->nomCategorie_fille;
																$find_transaction->message=$info_message;
																
																$orther=$find_transaction->others.',"categorieId2":"'.$produit->id.'"';
																
																$find_transaction->message_send=$message;
																$find_transaction->others=$orther;
																$find_transaction->message=$info_message;
																$find_transaction->sub_menu=7;
																$find_transaction->save();
																
															}else{
																$message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
															}
														
													}	
											break;
											case "7":
													$recup_information=Json::decode("[{".$find_transaction->others."}]");										
													$information=$recup_information[0];	
													$idcategorie= $information['categorieId2'];
													$infoU_categorie=CategorieFille::findOne(['id' => $idcategorie]);
													$unites_categories=Json::decode($infoU_categorie->unite_mesure);

													$all_unites=Unites::find()->where(['id'=>$unites_categories])->orderBy('nom ASC')->all();
													
													if($response==$previor_show){
													
														if(sizeof($all_unites)>0){
															
															
															$page_actuelle=(int)$find_transaction->page_menu;
															
															if($page_actuelle>1){
															
																
																$message="";
																$start=($page_actuelle-2)*$nbre_show;
																
																$count=0;
																for($i=$start;$i<($nbre_show+$start);$i++){	
																	if($i<sizeof($all_unites)){
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_unites[$i]->nom;
																		$count++;
																	}
																}
																
																if($start>0){
																	$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																}else{
																		
																	$message=\Yii::t('app', 'UNITE')."\n".$message."\n";
																}
																$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																
																$find_transaction->page_menu=$page_actuelle-1;
																
															}else{
															
																$message=\Yii::t('app', 'UNITE');
																
																for($i=0;$i<$nbre_show;$i++){	
																	if($i<=sizeof($all_unites)){
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_unites[$i]->nom;
																	}
																}											
																
																$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
															}
															
															$find_transaction->message_send=$message;
															
															
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
															$find_transaction->etat_transaction=2;
														}									
															
																							
														$find_transaction->save();
													
													}else if($response==$nest_show){
													
														if(sizeof($all_unites)>0){
															$message="";
															$i=1;
															
															$page_actuelle=(int)$find_transaction->page_menu;
															$start=$page_actuelle*$nbre_show;
															
															if(sizeof($all_unites)<($nbre_show+$start) ){
																
																$nbre_reste=sizeof($all_unites)-$start;											
																
																if($nbre_reste>=1){
																	$count=0;
																	for($i=$start;$i<($nbre_reste+$start);$i++){	
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_unites[$i]->nom;
																		$count++;
																	}
																	
																	if($page_actuelle>0){
																		$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																	}
																	
																	if($count==$nbre_show){
																		if(sizeof($all_unites)>($nbre_show+$start)){
																			$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																		}
																	}
																	
																	$find_transaction->page_menu=$page_actuelle+1;
																}else{
																
																	$start=($page_actuelle-1)*$nbre_show;
																	for($i=$start;$i<sizeof($all_unites);$i++){	
																		if($message!="")$message.="\n";
																		$message.=($i+1).". ".$all_unites[$i]->nom;
																	}
																	$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																	
																}
																
															}else{
																
																$count=0;
																for($i=$start;$i<($nbre_show+$start);$i++){		
																	if($message!="")$message.="\n";
																	$message.=($i+1).". ".$all_unites[$i]->nom;
																	$count++;
																}
																
																$message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
																if($count==$nbre_show){
																	if(sizeof($all_unites)>($nbre_show+$start)){
																		$message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
																	}
																}
																
																$find_transaction->page_menu=$page_actuelle+1;
															}
															$find_transaction->message_send=$message;
															
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
															$find_transaction->etat_transaction=2;
														}									
															
																							
														$find_transaction->save();
													
													}else{
														
														if((int)$response<=sizeof($all_unites)){
														
															
															$message=\Yii::t('app', 'RECEIVED_QTE');	
															
															
															$unites=$all_unites[((int)$response)-1];
												
															$orther=$find_transaction->others.',"unitesId2":"'.$unites->id.'"';
															$find_transaction->others=$orther;								
															$find_transaction->sub_menu=8;
															$find_transaction->save();
															
														}else{
															
															$message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
														}
											
													}
											
											break;
											case "8":							
													$message=\Yii::t('app', 'EMPLACEMENT');	
													
													$recup_information=Json::decode("[{".$find_transaction->others."}]");										
													$information=$recup_information[0];	
												    $unites=Unites::findOne(['id'=>$information['unitesId2']]);
														
													$info_message=$find_transaction->message."  ".$response." ".$unites->abrev;
													$find_transaction->message=$info_message;
											
													$orther=$find_transaction->others.',"stock2":"'.$response.'"';
													$find_transaction->others=$orther;
													$find_transaction->sub_menu=9;
													$find_transaction->save();
														
											break;
											
											case "9":
											
													$orther=$find_transaction->others.',"lieu2":"'.$response.'"';
													$info_message=$find_transaction->message." disponible a ".$response;	
													$message=$info_message."\n\n1. ".\Yii::t('app', 'CONFIRMER')."\n2. ".\Yii::t('app', 'ANNULER');
													
													$find_transaction->message=$info_message;
													$find_transaction->message_send=$message;
													$find_transaction->others=$orther;
													$find_transaction->sub_menu=10;
													$find_transaction->save();
											break;
											case "10":
													if($response=="1"){
														
														//enregistrement du produit
														
														$ready=false;
														
														$recup_information=Json::decode("[{".$find_transaction->others."}]");										
														$information=$recup_information[0];	
														$biztypeId=$information['biztypeId'];
														
														
																
																$model=new Annonce();
																
																$model->userId = $find_transaction->iduser;
																$model->methodeId = 3;
																$model->deviseId = 2;
																$model->time =time();
																$model->createdBy = $find_transaction->iduser;
																$model->modifiedBy= $find_transaction->iduser;
																$model->reference = Yii::$app->security->generateRandomString();
																$model->unitesId= $information['unitesId'];
																$model->stock= $information['stock'];
																$model->prix= "0";
																$model->categorieId= $information['categorieId'];
																$model->biztypeId= 4;
																$model->lieu= $information['lieu'];
																$model->uniqueCode="R".rand(100000,999999);
																
																//convertion du prix et de la quantite
																
																$convert=Unites::findOne(['id' => $model->unitesId]);
																$valeur_convert=$convert->valeur_convertir;
																
																$model->convert_quantite =$model->stock/$valeur_convert;
																$model->convert_prix ="0";
																
																if($model->save()){
																
																	$annonceId=$model->id;
																	
																	$model_troc=new Troc();
																
																	$model_troc->title = "";
																	$model_troc->categorieId= $information['categorieId2'];
																	$model_troc->unitesId=  $information['unitesId2'];
																	$model_troc->annonceId= $annonceId;
																	$model_troc->quantite= $information['stock2'];
																	$model_troc->stock= $information['stock2'];
																	$model_troc->lieu= $information['lieu2'];
																	$model_troc->statut= 1;
																	$model_troc->time =time();
																	$model_troc->reference = Yii::$app->security->generateRandomString();
																	
																	
																	if($model_troc->save()){
																		$ready=true;
																	}
																}
														
														
														
														if($ready){
														
															
															$receiver=$find_transaction->username;
															$sender="E-agri";
															$sms=$find_transaction->message.". ".\Yii::t('app', 'CODE_ANNONCE1')." ".$model->uniqueCode.". ".\Yii::t('app', 'CODE_ANNONCE4').". ".\Yii::t('app', 'SUCCES_PUBLICATION');
															
															$this->send_sms($sms,$sender,$receiver);
															
															
															$message=\Yii::t('app', 'SUCCES_PUBLICATION');
														
															$find_transaction->message=$sms;
															$find_transaction->sub_menu=11;
															$find_transaction->etat_transaction=1;
															$find_transaction->save();
															
														}else{
														   $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
														}				
														
														
													}else{
														
														$all_menu=MenuUssd::find()->where(['status'=>'1'])->orderBy('position_menu_ussd ASC')->all();
													
														if(sizeof($all_menu)>0){
															$i=1;
												            $message=\Yii::t('app', 'WELCOME_EAGRI');
															if(sizeof($all_menu)< $nbre_show ){
																
																foreach ($all_menu as $menu){
																	$message.="\n".$menu->position_menu_ussd.". ".$menu->denomination;
																	$i++;
																}
																$message.="\n\n0. ".\Yii::t('app', 'AIDE');
																$find_transaction->page_menu=0;
															}else{
																
																$count=0;
																for($i=0;$i<$nbre_show;$i++){											
																	$message.="\n".$all_menu[$i]->position_menu_ussd.". ".$all_menu[$i]->denomination;
																	$count++;
																}
																
																$message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');	
																$message.="\n0. ".\Yii::t('app', 'AIDE');
																$find_transaction->page_menu=1;
																
															}
															$find_transaction->message_send=$message;
							
														}else{
															$message=\Yii::t('app', 'TRANSACTION ECHOUEE');
														}
								
														$find_transaction->menu=-1;
														$find_transaction->save();
													}
											break;
										
									    }
									
									}
						    break;
						}						
					break;		
		}
			   
		
		return $message;
	   
	}
        
    public function retirer_recolte($response, $id_trans, $status) {

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;


        switch (trim($status)) {
            case "0":
                $message = \Yii::t('app', 'CODE_ANNONCE') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                $find_transaction->message_send = $message;
                $find_transaction->sub_menu = 1;
                $find_transaction->save();
                break;

            case "1":

                if ($response == "0") {
                    $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                    if (sizeof($all_menu) > 0) {
                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                        $i = 1;

                        if (sizeof($all_menu) < $nbre_show) {

                            foreach ($all_menu as $menu) {
                                $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                $i++;
                            }
                            $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 0;
                        } else {

                            $count = 0;
                            for ($i = 0; $i < $nbre_show; $i++) {
                                $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                $count++;
                            }

                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                            $message .= "\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 1;
                        }
                        $find_transaction->message_send = $message;
                    } else {
                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    }

                    $find_transaction->menu = -1;
                    $find_transaction->sub_menu = 0;
                    $find_transaction->save();
                } else {
                    switch (trim($sub_menu)) {
                        case "1":

                            $message = \Yii::t('app', 'REMOVE_ANNONCE') . " " . $response . "\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER') . "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                            $find_transaction->others = $response;
                            $find_transaction->message_send = $message;
                            $find_transaction->sub_menu = 2;
                            $find_transaction->save();
                            break;
                        case "2":

                            if ($response == "1") {
                                $identifiant = $find_transaction->others;
                                $test_annonce = Annonce::findOne(['uniqueCode' => $identifiant, 'userId' => $find_transaction->iduser, 'statut' => '1']);

                                if ($test_annonce !== null) {

                                    $test_annonce->statut = 2;
                                    $test_annonce->save();

                                    $message = \Yii::t('app', 'DELETE_SUCCES_ANNONCE');

                                    $find_transaction->message = $message;
                                    $find_transaction->etat_transaction = 1;
                                    $find_transaction->save();
                                } else {
                                    $message = \Yii::t('app', 'ERREUR') . ": " . \Yii::t('app', 'CODE_ANNONCE') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                    $find_transaction->sub_menu = 1;
                                    $find_transaction->save();
                                }
                            } else if ($response == "2") {
                                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                                if (sizeof($all_menu) > 0) {
                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    $i = 1;

                                    if (sizeof($all_menu) < $nbre_show) {

                                        foreach ($all_menu as $menu) {
                                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                            $i++;
                                        }
                                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                }

                                $find_transaction->menu = -1;
                                $find_transaction->sub_menu = 0;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }

                            break;
                    }
                }
                break;
        }

        return $message;
    }

    public function demander_contact($response, $id_trans, $status) {

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;


        switch (trim($status)) {
            case "0":
                //$message=\Yii::t('app', 'CODE_ANNONCE')." \n\n0. ".\Yii::t('app', 'MENU PRINCIPAL');
                $message = "Entrez l'identifiant de l'annonce \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                $find_transaction->message_send = $message;
                $find_transaction->sub_menu = 1;
                $find_transaction->save();
                break;

            case "1":

                if ($response == "0") {
                    $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                    if (sizeof($all_menu) > 0) {
                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                        $i = 1;

                        if (sizeof($all_menu) < $nbre_show) {

                            foreach ($all_menu as $menu) {
                                $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                $i++;
                            }
                            $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 0;
                        } else {

                            $count = 0;
                            for ($i = 0; $i < $nbre_show; $i++) {
                                $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                $count++;
                            }

                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                            $message .= "\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 1;
                        }
                        $find_transaction->message_send = $message;
                    } else {
                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    }

                    $find_transaction->menu = -1;
                    $find_transaction->sub_menu = 0;
                    $find_transaction->save();
                } else {
                    switch (trim($sub_menu)) {
                        case "1":
                            $test_annonce = Medias::findOne(['identifiant' => $response]);

                            if ($test_annonce !== null) {




                                $type_annonce = $test_annonce->annonce->biztype->name;
                                $produit = $test_annonce->annonce->categorie->nomCategorie_fille;
                                $lieu = $test_annonce->annonce->lieu;
                                $stock = $test_annonce->annonce->stock;
                                $unites1 = $test_annonce->annonce->unites->abrev;

                                //envoyer un message a l'annonceur											

                                if ($test_annonce->annonce->biztypeId == "4") {

                                    $info_troc = Troc::findOne(['annonceId' => $test_annonce->annonceId]);

                                    $produit2 = $info_troc->categorie->nomCategorie_fille;
                                    $stock2 = $info_troc->quantite;
                                    $lieu2 = $info_troc->lieu;
                                    $unites2 = $info_troc->unites->abrev;



                                    $message = \Yii::t('app', 'ECHANGE') . " " . $produit . " " . $stock . " " . $unites1 . " " . \Yii::t('app', 'DISPONIBLE') . " " . $lieu . " " . \Yii::t('app', 'CONTRE') . " " . $produit2 . " " . $stock2 . " " . $unites2 . " " . \Yii::t('app', 'DISPONIBLE') . " " . $lieu2;
                                } else {
                                    $unites = $test_annonce->annonce->unites->abrev;
                                    $prix = $test_annonce->annonce->prix;
                                    $devise = "";
                                    $plus_price = "";
                                    if ($prix != "") {

                                        $devise = $test_annonce->annonce->devise->name;
                                        $plus_price = \Yii::t('app', 'PRIX_UNITAIRE') . ":  " . $prix . $devise . "/" . $unites;
                                    }

                                    $message = $type_annonce . " " . \Yii::t('app', 'OF') . " " . $produit . " " . $stock . " " . $unites1 . $plus_price . " " . \Yii::t('app', 'DISPONIBLE') . " " . $lieu;
                                }


                                $message = \Yii::t('app', 'SEARCH_CONTACT') . " (" . $message . ")\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER') . "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                $find_transaction->others = $response;
                                $find_transaction->message_send = $message;
                                $find_transaction->sub_menu = 2;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }



                            break;
                        case "2":

                            if ($response == "1") {
                                $identifiant = $find_transaction->others;
                                $test_annonce = Medias::findOne(['identifiant' => $identifiant]);

                                if ($test_annonce !== null) {

                                    $numero = $test_annonce->annonce->user->username;


                                    $type_annonce = $test_annonce->annonce->biztype->name;
                                    $produit = $test_annonce->annonce->categorie->nomCategorie_fille;
                                    $lieu = $test_annonce->annonce->lieu;
                                    $stock = $test_annonce->annonce->stock;
                                    $unites1 = $test_annonce->annonce->unites->nom;

                                    //envoyer un message a l'annonceur


                                    if ($test_annonce->annonce->biztypeId == "4") {

                                        $info_troc = Troc::findOne(['annonceId' => $test_annonce->annonceId]);

                                        $produit2 = $info_troc->categorie->nomCategorie_fille;
                                        $stock2 = $info_troc->quantite;
                                        $lieu2 = $info_troc->lieu;
                                        $unites2 = $info_troc->unites->nom;



                                        $message = \Yii::t('app', 'ECHANGE') . " " . $produit . " " . $stock . " " . $unites1 . " " . \Yii::t('app', 'DISPONIBLE') . " " . $lieu . " " . \Yii::t('app', 'CONTRE') . " " . $produit2 . " " . $stock2 . " " . $unites2 . " " . \Yii::t('app', 'DISPONIBLE') . " " . $lieu2 . " \n" . \Yii::t('app', 'CONTACT') . ": " . $numero;
                                    } else {
                                        $unites = $test_annonce->annonce->unites->abrev;
                                        $prix = $test_annonce->annonce->prix;
                                        $devise = "";
                                        $plus_price = "";
                                        if ($prix != "") {

                                            $devise = $test_annonce->annonce->devise->name;
                                            $plus_price = \Yii::t('app', 'PRIX_UNITAIRE') . ":  " . $prix . $devise . "/" . $unites;
                                        }

                                        $message = $type_annonce . " " . \Yii::t('app', 'OF') . " " . $produit . " " . $stock . " " . $unites1 . $plus_price . " " . \Yii::t('app', 'DISPONIBLE') . " " . $lieu . " \n" . \Yii::t('app', 'CONTACT') . ": " . $numero;
                                    }

                                    $this->save_autorisation($find_transaction->iduser, $test_annonce->annonceId);

                                    $receiver = $find_transaction->username;
                                    $sender = "E-agri";
                                    $sms = $message;
                                    $this->send_sms($sms, $sender, $receiver);


                                    $find_transaction->message = $message;
                                    $find_transaction->etat_transaction = 1;
                                    $find_transaction->save();
                                } else {
                                    $message = \Yii::t('app', 'ERREUR') . ": " . \Yii::t('app', 'CODE_ANNONCE') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                    $find_transaction->sub_menu = 1;
                                    $find_transaction->save();
                                }
                            } else if ($response == "2") {
                                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                                if (sizeof($all_menu) > 0) {
                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    $i = 1;

                                    if (sizeof($all_menu) < $nbre_show) {

                                        foreach ($all_menu as $menu) {
                                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                            $i++;
                                        }
                                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                }

                                $find_transaction->menu = -1;
                                $find_transaction->sub_menu = 0;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }

                            break;
                    }
                }
                break;
        }

        return $message;
    }

    public function alert_sms($response, $id_trans, $status) {



        $id_trans = trim($id_trans);
        $response = trim($response);
        $id_operateur = ConsoleappinitController::ID_OPERATEUR;

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;


        switch (trim($status)) {
            case "0":
                $info_plage = $this->paquet_sms($id_operateur);
                if (sizeof($info_plage) > 0) {
                    $message = \Yii::t('app', 'PLAGE_SMS');

                    $i = 1;
                    foreach ($info_plage as $paquet) {
                        $message .= "\n" . $i . ". (" . $paquet['nbre'] . " " . \Yii::t('app', 'SMS') . ") -> " . $paquet['prix'] . " FCFA";
                        $i++;
                    }
                    $message .= "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                    $find_transaction->sub_menu = 1;
                    $find_transaction->message_send = $message;
                } else {
                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    $find_transaction->etat_transaction = 2;
                }
                $find_transaction->save();
                break;

            case "1":

                if ($response == "0") {
                    $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                    if (sizeof($all_menu) > 0) {
                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                        $i = 1;

                        if (sizeof($all_menu) < $nbre_show) {

                            foreach ($all_menu as $menu) {
                                $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                $i++;
                            }
                            $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 0;
                        } else {

                            $count = 0;
                            for ($i = 0; $i < $nbre_show; $i++) {
                                $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                $count++;
                            }

                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                            $message .= "\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 1;
                        }
                        $find_transaction->message_send = $message;
                    } else {
                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    }

                    $find_transaction->menu = -1;
                    $find_transaction->sub_menu = 0;
                    $find_transaction->save();
                } else {
                    switch (trim($sub_menu)) {
                        case "1":

                            $info_plage = $this->paquet_sms($id_operateur);
                            if (sizeof($info_plage) > 0) {

                                if ((int) $response <= sizeof($info_plage)) {

                                    $position = (int) $response - 1;
                                    $message = \Yii::t('app', 'MOYEN_PAYMENT') . "\n1. " . \Yii::t('app', 'PAYMENT_EAGRI') . "\n2. " . \Yii::t('app', 'PAYMENT_MOBILE') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');


                                    $content = \Yii::t('app', 'ACTIVATION_OF') . " " . $info_plage[$position]['nbre'] . " " . \Yii::t('app', 'SMS') . ". " . \Yii::t('app', 'PRIX_PAQUET') . ": " . $info_plage[$position]['prix'] . " Fcfa";

                                    $find_transaction->others = "" . $position;
                                    $find_transaction->message = $content;
                                    $find_transaction->message_send = $message;
                                    $find_transaction->sub_menu = 2;
                                    $find_transaction->save();
                                } else {
                                    $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                                }
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                                $find_transaction->save();
                            }

                            break;
                        case "2":

                            if ($response == "1" or $response == "2") {

                                $content = "";
                                if ($response == "1") {
                                    $content = $find_transaction->message . " " . \Yii::t('app', 'WITH') . " " . \Yii::t('app', 'PAYMENT_EAGRI') . ".";
                                } else if ($response == "2") {
                                    $content = $find_transaction->message . " " . \Yii::t('app', 'WITH') . " " . \Yii::t('app', 'PAYMENT_MOBILE') . ".";
                                }

                                $message = $content . "\n\n1. " . Yii::t('app', 'CONFIRMER') . "\n2. " . Yii::t('app', 'ANNULER') . "\n0. " . Yii::t('app', 'MENU PRINCIPAL');

                                $selection = $find_transaction->others;

                                $find_transaction->others = $selection . "-" . $response;
                                $find_transaction->message_send = $message;
                                $find_transaction->message = $content;
                                $find_transaction->sub_menu = 3;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                            break;
                        case "3":
                            if ($response == "1") {


                                $info_plage = $this->paquet_sms($id_operateur);
                                if (sizeof($info_plage) > 0) {

                                    $recup_info = explode("-", $find_transaction->others);

                                    $selection = $recup_info[0];
                                    $moyen = $recup_info[1];
                                    $info_selection = $info_plage[$selection];

                                    if ($moyen == "1") {
                                        // SELECTION DU MOYEN DE PAYEMENT E-agri
                                        //recuperer les info de l'utilisateur
                                        $info_user = User::findOne(['id' => $find_transaction->iduser]);

                                        $amount_compte = $info_user->solde;
                                        $sms_compte = $info_user->alerte;

                                        if ($amount_compte >= $info_selection['prix']) {

                                            $new_solde = $amount_compte - $info_selection['prix'];
                                            $new_sms = $sms_compte + $info_selection['nbre'];

                                            $info_user->solde = $new_solde;
                                            $info_user->alerte = $new_sms;
                                            $info_user->save();

                                            $message = $find_transaction->message . " " . \Yii::t('app', 'SUCCES_SOUSCRIPTION');


                                            $receiver = $find_transaction->username;
                                            $sender = "E-agri";
                                            $sms = $message;
                                            $this->send_sms($sms, $sender, $receiver);


                                            $find_transaction->message = $message;
                                            $find_transaction->etat_transaction = 1;
                                            $find_transaction->save();
                                        } else {
                                            $message = \Yii::t('app', 'SOLDE1_INSUFFISANT');
                                            $find_transaction->etat_transaction = 2;
                                            $find_transaction->save();
                                        }
                                    } else if ($moyen == "2") {
                                        // SELECTION DU MOYEN DE PAYEMENT MOBILE MONEY

                                        $message = $find_transaction->message . " " . \Yii::t('app', 'SUCCES_SOUSCRIPTION');

                                        $find_transaction->message = $message;
                                        $find_transaction->etat_transaction = 1;
                                        $find_transaction->save();
                                    } else {
                                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                        $find_transaction->etat_transaction = 2;
                                        $find_transaction->save();
                                    }
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                    $find_transaction->save();
                                }
                            } else if ($response == "2") {

                                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                                if (sizeof($all_menu) > 0) {
                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    $i = 1;

                                    if (sizeof($all_menu) < $nbre_show) {

                                        foreach ($all_menu as $menu) {
                                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                            $i++;
                                        }
                                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                }

                                $find_transaction->menu = -1;
                                $find_transaction->sub_menu = 0;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }

                            break;
                    }
                }
                break;
        }

        return $message;
    }

    public function recherche_produit($response, $id_trans, $status) {

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);


        switch (trim($status)) {
            case "0":
                $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                if (sizeof($all_categorie) > 0) {

                    $message = \Yii::t('app', 'SELECT_CATEGORIE');
                    $i = 1;

                    if (sizeof($all_categorie) < $nbre_show) {

                        foreach ($all_categorie as $categorie) {
                            $message .= "\n" . $i . ". " . $categorie->name;
                            $i++;
                        }
                        $find_transaction->page_menu = 0;
                    } else {

                        $count = 0;
                        for ($i = 0; $i < $nbre_show; $i++) {
                            $message .= "\n" . ($i + 1) . ". " . $all_categorie[$i]->name;
                            $count++;
                        }

                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                        $find_transaction->page_menu = 1;
                    }

                    $find_transaction->message_send = $message;
                } else {
                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    $find_transaction->etat_transaction = 2;
                }
                $find_transaction->save();

                break;
            case "1":
                switch (trim($sub_menu)) {

                    case "1":

                        if ($response == $previor_show) {

                            $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                            if (sizeof($all_categorie) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;

                                if ($page_actuelle > 1) {


                                    $message = "";
                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_categorie)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                            $count++;
                                        }
                                    }

                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {

                                        $message = \Yii::t('app', 'SELECT_CATEGORIE') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'SELECT_CATEGORIE');

                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_categorie)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }


                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else if ($response == $nest_show) {

                            $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                            if (sizeof($all_categorie) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_categorie) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_categorie) - $start;


                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        }

                                        if ($count == $nbre_show) {
                                            if (sizeof($all_categorie) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_categorie); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_categorie) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }

                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else {

                            $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                            if ((int) $response <= sizeof($all_categorie)) {

                                $categorie = $all_categorie[(int) $response - 1];

                                $all_produit = CategorieFille::find()->where(['categorieId' => $categorie->id])->orderBy('nomCategorie_fille ASC')->all();
                                if (sizeof($all_produit) > 0) {

                                    $message = \Yii::t('app', 'SELECT_PRODUIT');
                                    $i = 1;

                                    if (sizeof($all_produit) < $nbre_show) {

                                        foreach ($all_produit as $produit) {
                                            $message .= "\n" . $i . ". " . $produit->nomCategorie_fille;
                                            $i++;
                                        }
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $find_transaction->page_menu = 1;
                                    }

                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                }

                                $orther = '"categorieId0":"' . $categorie->id . '"';

                                $find_transaction->message_send = $message;
                                $find_transaction->others = $orther;
                                $find_transaction->sub_menu = 2;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                        }

                        break;
                    case "2":

                        $recup_information = Json::decode("[{" . $find_transaction->others . "}]");
                        $information = $recup_information[0];
                        $idcategorie = $information['categorieId0'];

                        if ($response == $previor_show) {

                            $all_produit = CategorieFille::find()->where(['categorieId' => $idcategorie])->orderBy('nomCategorie_fille ASC')->all();

                            if (sizeof($all_produit) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;

                                if ($page_actuelle > 1) {

                                    $message = "";
                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_produit)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                            $count++;
                                        }
                                    }

                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {
                                        $message = \Yii::t('app', 'SELECT_PRODUIT') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'SELECT_PRODUIT');

                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_produit)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }


                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else if ($response == $nest_show) {

                            $all_produit = CategorieFille::find()->where(['categorieId' => $idcategorie])->orderBy('nomCategorie_fille ASC')->all();

                            if (sizeof($all_produit) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_produit) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_produit) - $start;


                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        }

                                        if ($count == $nbre_show) {
                                            if (sizeof($all_produit) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }
                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_produit); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_produit) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }

                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else {

                            $all_produit = CategorieFille::find()->where(['categorieId' => $idcategorie])->orderBy('nomCategorie_fille ASC')->all();

                            if ((int) $response <= sizeof($all_produit)) {


                                $produit = $all_produit[((int) $response) - 1];
                                $infoU_categorie = CategorieFille::findOne(['id' => $produit->id]);
                                $unites_categories = Json::decode($infoU_categorie->unite_mesure);

                                $all_unites = Unites::find()->where(['id' => $unites_categories])->orderBy('nom ASC')->all();
                                if (sizeof($all_unites) > 0) {
                                    $message = \Yii::t('app', 'UNITE');
                                    $i = 1;



                                    if (sizeof($all_unites) < $nbre_show) {

                                        foreach ($all_unites as $unites) {
                                            $message .= "\n" . $i . ". " . $unites->nom;
                                            $i++;
                                        }
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . ($i + 1) . ". " . $all_unites[$i]->nom;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                }


                                $info_message = \Yii::t('app', 'SEARCH_OF') . " " . $produit->nomCategorie_fille;
                                $find_transaction->message = $info_message;

                                $orther = '"categorieId":"' . $produit->id . '"';

                                $find_transaction->message_send = $message;
                                $find_transaction->others = $orther;
                                $find_transaction->message = $info_message;
                                $find_transaction->sub_menu = 3;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                        }
                        break;

                    case "3":

                        $recup_information = Json::decode("[{" . $find_transaction->others . "}]");
                        $information = $recup_information[0];
                        $idcategorie = $information['categorieId'];
                        $infoU_categorie = CategorieFille::findOne(['id' => $idcategorie]);
                        $unites_categories = Json::decode($infoU_categorie->unite_mesure);

                        $all_unites = Unites::find()->where(['id' => $unites_categories])->orderBy('nom ASC')->all();

                        if ($response == $previor_show) {


                            if (sizeof($all_unites) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;

                                if ($page_actuelle > 1) {

                                    $message = "";
                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_unites)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_unites[$i]->nom;
                                            $count++;
                                        }
                                    }

                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {

                                        $message = \Yii::t('app', 'UNITE') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'UNITE');

                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_unites)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= "\n" . ($i + 1) . ". " . $all_unites[$i]->nom;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }

                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else if ($response == $nest_show) {


                            if (sizeof($all_unites) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_unites) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_unites) - $start;

                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_unites[$i]->nom;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        }

                                        if ($count == $nbre_show) {
                                            if (sizeof($all_unites) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_unites); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_unites[$i]->nom;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= ($i + 1) . ". " . $all_unites[$i]->nom;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_unites) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }

                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else {

                            if ((int) $response <= sizeof($all_unites)) {

                                $unites = $all_unites[((int) $response) - 1];

                                $info_message = $find_transaction->message . " " . $unites->abrev;
                                $message = \Yii::t('app', 'QTE_MINIMUM');



                                $orther = $find_transaction->others . ',"unitesId":"' . $unites->id . '"';
                                $find_transaction->others = $orther;
                                $find_transaction->sub_menu = 4;
                                $find_transaction->save();
                            } else {

                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                        }

                        break;
                    case "4":
                        $recup_information = Json::decode("[{" . $find_transaction->others . "}]");
                        $information = $recup_information[0];
                        $unites = Unites::findOne(['id' => $information['unitesId']]);

                        $info_message = $find_transaction->message . "  " . $response . " " . $unites->abrev;
                        $find_transaction->message = $info_message;
                        $message = $info_message . "\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER');

                        $orther = $find_transaction->others . ',"stock":"' . $response . '"';
                        $find_transaction->others = $orther;
                        $find_transaction->sub_menu = 5;
                        $find_transaction->save();

                        break;
                    case "5":

                        if ($response == "1") {

                            //Recherche du produit									

                            $recup_information = Json::decode("[{" . $find_transaction->others . "}]");
                            $information = $recup_information[0];

                            $unitesId = $information['unitesId'];
                            $stock = $information['stock'];
                            $categorieId = $information['categorieId'];

                            //convertion  de la quantite 

                            $convert = Unites::findOne(['id' => $unitesId]);
                            $valeur_convert = $convert->valeur_convertir;

                            $convert_quantite = $stock / $valeur_convert;

                            $search_produit = Annonce::find()->where("biztypeId='1' and categorieId ='" . $categorieId . "' and convert_quantite>='" . $convert_quantite . "' and statut='1' order by id  DESC limit 0,4")->all();
                            if (sizeof($search_produit) > 0) {

                                $sms = $search_produit[0]->categorie->nomCategorie_fille;
                                foreach ($search_produit as $annonce) {
                                    if ($sms != "")
                                        $sms .= "\n";
                                    $unites = $annonce->unites->nom;
                                    $sms .= \Yii::t('app', 'LIEU') . ": " . $annonce->lieu . ", " . \Yii::t('app', 'QTE') . ":" . $annonce->stock . " " . $unites . ", " . \Yii::t('app', 'PRIX_PAQUET') . ": " . $annonce->prix . " " . $annonce->devise->name . "/" . $annonce->unites->abrev . ", " . \Yii::t('app', 'CONTACT') . ":" . $annonce->user->username;
                                }

                                //envoyer un message a l'annonceur																					
                                $message = \Yii::t('app', 'SEND_INFORMATION_SMS');
                                $receiver = $find_transaction->username;
                                $sender = "E-agri";
                                $this->send_sms($sms, $sender, $receiver);

                                $find_transaction->sub_menu = 6;
                                $find_transaction->etat_transaction = 1;
                                $find_transaction->save();
                            }else {
                                $message = \Yii::t('app', 'EMPTY_RESULT');
                                $find_transaction->etat_transaction = 2;
                                $find_transaction->save();
                            }
                        } else {

                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                            if (sizeof($all_menu) > 0) {
                                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                $i = 1;

                                if (sizeof($all_menu) < $nbre_show) {

                                    foreach ($all_menu as $menu) {
                                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                        $i++;
                                    }
                                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                    $find_transaction->page_menu = 0;
                                } else {

                                    $count = 0;
                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                    $find_transaction->page_menu = 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                            }

                            $find_transaction->menu = -1;
                            $find_transaction->save();
                        }
                        break;

                    default:
                        $message = \Yii::t('app', 'RESTART_TEST');
                        $find_transaction->etat_transaction = 2;
                        $find_transaction->save();
                        break;
                }
                break;
        }


        return $message;
    }

    public function recherche_prix($response, $id_trans, $status) {

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $id_pays = ConsoleappinitController::ID_COUNTRY;

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);


        switch (trim($status)) {
            case "0":
                $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                if (sizeof($all_categorie) > 0) {

                    $message = \Yii::t('app', 'SELECT_CATEGORIE');
                    $i = 1;

                    if (sizeof($all_categorie) < $nbre_show) {

                        foreach ($all_categorie as $categorie) {
                            $message .= "\n" . $i . ". " . $categorie->name;
                            $i++;
                        }
                        $find_transaction->page_menu = 0;
                    } else {

                        $count = 0;
                        for ($i = 0; $i < $nbre_show; $i++) {
                            $message .= "\n" . ($i + 1) . ". " . $all_categorie[$i]->name;
                            $count++;
                        }

                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                        $find_transaction->page_menu = 1;
                    }

                    $find_transaction->message_send = $message;
                } else {
                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    $find_transaction->etat_transaction = 2;
                }
                $find_transaction->save();

                break;
            case "1":
                switch (trim($sub_menu)) {

                    case "1":

                        if ($response == $previor_show) {

                            $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                            if (sizeof($all_categorie) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;

                                if ($page_actuelle > 1) {

                                    $message = "";

                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_categorie)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                            $count++;
                                        }
                                    }

                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {
                                        $message = \Yii::t('app', 'SELECT_CATEGORIE') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'SELECT_CATEGORIE');

                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_categorie)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }


                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else if ($response == $nest_show) {

                            $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                            if (sizeof($all_categorie) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_categorie) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_categorie) - $start;


                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        }

                                        if ($count == $nbre_show) {
                                            if (sizeof($all_categorie) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_categorie); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= ($i + 1) . ". " . $all_categorie[$i]->name;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_categorie) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }

                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else {

                            $all_categorie = Categorie::find()->orderBy('name ASC')->all();

                            if ((int) $response <= sizeof($all_categorie)) {

                                $categorie = $all_categorie[(int) $response - 1];

                                $all_produit = CategorieFille::find()->where(['categorieId' => $categorie->id])->orderBy('nomCategorie_fille ASC')->all();
                                if (sizeof($all_produit) > 0) {

                                    $message = \Yii::t('app', 'SELECT_PRODUIT');
                                    $i = 1;

                                    if (sizeof($all_produit) < $nbre_show) {

                                        foreach ($all_produit as $produit) {
                                            $message .= "\n" . $i . ". " . $produit->nomCategorie_fille;
                                            $i++;
                                        }
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $find_transaction->page_menu = 1;
                                    }

                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                }

                                $orther = '"categorieId0":"' . $categorie->id . '"';

                                $find_transaction->message_send = $message;
                                $find_transaction->others = $orther;
                                $find_transaction->sub_menu = 2;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                        }

                        break;

                    case "2":
                        $recup_information = Json::decode("[{" . $find_transaction->others . "}]");
                        $information = $recup_information[0];
                        $idcategorie = $information['categorieId0'];

                        if ($response == $previor_show) {

                            $all_produit = CategorieFille::find()->where(['categorieId' => $idcategorie])->orderBy('nomCategorie_fille ASC')->all();

                            if (sizeof($all_produit) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;

                                if ($page_actuelle > 1) {

                                    $message = "";

                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_produit)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                            $count++;
                                        }
                                    }

                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {

                                        $message = \Yii::t('app', 'SELECT_PRODUIT') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'SELECT_PRODUIT');

                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_produit)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }


                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else if ($response == $nest_show) {

                            $all_produit = CategorieFille::find()->where(['categorieId' => $idcategorie])->orderBy('nomCategorie_fille ASC')->all();

                            if (sizeof($all_produit) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_produit) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_produit) - $start;


                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        }

                                        if ($count == $nbre_show) {
                                            if (sizeof($all_produit) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_produit); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= ($i + 1) . ". " . $all_produit[$i]->nomCategorie_fille;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_produit) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }

                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else {

                            $all_produit = CategorieFille::find()->where(['categorieId' => $idcategorie])->orderBy('nomCategorie_fille ASC')->all();

                            if ((int) $response <= sizeof($all_produit)) {


                                $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();
                                if (sizeof($all_region) > 0) {
                                    $message = \Yii::t('app', 'SELECT_REGION');
                                    $i = 1;

                                    if (sizeof($all_region) < $nbre_show) {

                                        foreach ($all_region as $regions) {
                                            $message .= "\n" . $i . ". " . $regions->nomregion;
                                            $i++;
                                        }
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . ($i + 1) . ". " . $all_region[$i]->nomregion;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                }


                                $produit = $all_produit[((int) $response) - 1];

                                $info_message = \Yii::t('app', 'SEARCH_PRICE') . " " . $produit->nomCategorie_fille;
                                $orther = '"categorieId":"' . $produit->id . '"';

                                $find_transaction->message = $info_message;
                                $find_transaction->others = $orther;
                                $find_transaction->sub_menu = 3;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                        }
                        break;
                    case "3":
                        if ($response == $previor_show) {

                            $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();

                            if (sizeof($all_region) > 0) {


                                $page_actuelle = (int) $find_transaction->page_menu;

                                if ($page_actuelle > 1) {

                                    $message = "";
                                    $start = ($page_actuelle - 2) * $nbre_show;

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($i < sizeof($all_region)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                            $count++;
                                        }
                                    }

                                    if ($start > 0) {
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    } else {
                                        $message = \Yii::t('app', 'SELECT_REGION') . "\n" . $message . "\n";
                                    }
                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                    $find_transaction->page_menu = $page_actuelle - 1;
                                } else {

                                    $message = \Yii::t('app', 'SELECT_REGION');

                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        if ($i <= sizeof($all_region)) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                        }
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                }

                                $find_transaction->message_send = $message;
                            }else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else if ($response == $nest_show) {

                            $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();

                            if (sizeof($all_region) > 0) {
                                $message = "";
                                $i = 1;

                                $page_actuelle = (int) $find_transaction->page_menu;
                                $start = $page_actuelle * $nbre_show;

                                if (sizeof($all_region) < ($nbre_show + $start)) {

                                    $nbre_reste = sizeof($all_region) - $start;

                                    if ($nbre_reste >= 1) {
                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                            $count++;
                                        }

                                        if ($page_actuelle > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        }

                                        if ($count == $nbre_show) {
                                            if (sizeof($all_region) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    } else {

                                        $start = ($page_actuelle - 1) * $nbre_show;
                                        for ($i = $start; $i < sizeof($all_region); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                        }
                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    }
                                }else {

                                    $count = 0;
                                    for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                        if ($message != "")
                                            $message .= "\n";
                                        $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                    if ($count == $nbre_show) {
                                        if (sizeof($all_region) > ($nbre_show + $start)) {
                                            $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        }
                                    }

                                    $find_transaction->page_menu = $page_actuelle + 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                $find_transaction->etat_transaction = 2;
                            }


                            $find_transaction->save();
                        } else {
                            $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();

                            if ((int) $response <= sizeof($all_region)) {

                                $region = $all_region[((int) $response) - 1];

                                $info_message = $find_transaction->message . " dans la region " . $region->nomregion;
                                $message = $info_message . "\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER');



                                $find_transaction->message = $info_message;

                                $orther = $find_transaction->others . ',"regionId":"' . $region->id . '"';
                                $find_transaction->others = $orther;
                                $find_transaction->sub_menu = 4;
                                $find_transaction->save();
                            } else {

                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                        }

                        break;

                    case "4":

                        if ($response == "1") {

                            //Recherche du produit									

                            $recup_information = Json::decode("[{" . $find_transaction->others . "}]");
                            $information = $recup_information[0];

                            $regionId = $information['regionId'];
                            $produitId = $information['categorieId'];





                            //$search_price=PostAgent::find()->select(["GROUP_CONCAT(prix SEPARATOR  ',') as prix", "post_agent.*"])->where("statut!='2' and regionId ='".$regionId."' and produitId='".$produitId."' group by produitId,dateCreation,lieu,ville order by id  DESC limit 0,4")->all();
                            $search_price = PostAgent::find()->select(["GROUP_CONCAT(prix SEPARATOR  ',') as prix", "ville", "lieu", "unitesId", "deviseId"])->where("statut!='2' and regionId ='" . $regionId . "' and produitId='" . $produitId . "' group by produitId,dateCreation,lieu,ville order by id  DESC limit 0,4")->all();

                            //print_r($search_price[0]);

                            if (sizeof($search_price) > 0) {

                                $info_categorie = CategorieFille::findOne(['id' => $produitId]);
                                $sms = $info_categorie->nomCategorie_fille;

                                foreach ($search_price as $annonce) {
                                    if ($sms != "")
                                        $sms .= "\n";
                                    $unites = $annonce->unites->nom;
                                    $sms .= \Yii::t('app', 'VILLE') . ": " . $annonce->ville . ", " . \Yii::t('app', 'LIEU') . ":" . $annonce->lieu . ", " . \Yii::t('app', 'PRIX_PAQUET') . ":(" . $annonce->prix . ") " . $annonce->devise->name . "/" . $annonce->unites->abrev;
                                }
                                //envoyer un message a l'annonceur											

                                $receiver = $find_transaction->username;
                                $sender = "E-agri";
                                $message = \Yii::t('app', 'SEND_INFORMATION_SMS');
                                $this->send_sms($sms, $sender, $receiver);

                                $find_transaction->sub_menu = 5;
                                $find_transaction->etat_transaction = 1;
                                $find_transaction->save();
                            }else {
                                $message = \Yii::t('app', 'EMPTY_RESULT');
                                $find_transaction->etat_transaction = 2;
                                $find_transaction->save();
                            }
                        } else {

                            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                            if (sizeof($all_menu) > 0) {
                                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                $i = 1;

                                if (sizeof($all_menu) < $nbre_show) {

                                    foreach ($all_menu as $menu) {
                                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                        $i++;
                                    }
                                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                    $find_transaction->page_menu = 0;
                                } else {

                                    $count = 0;
                                    for ($i = 0; $i < $nbre_show; $i++) {
                                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                        $count++;
                                    }

                                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                    $find_transaction->page_menu = 1;
                                }
                                $find_transaction->message_send = $message;
                            } else {
                                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                            }

                            $find_transaction->menu = -1;
                            $find_transaction->save();
                        }
                        break;

                    default:
                        $message = \Yii::t('app', 'RESTART_TEST');
                        $find_transaction->etat_transaction = 2;
                        $find_transaction->save();
                        break;
                }
                break;
        }


        return $message;
    }

    public function recharger_compte($response, $id_trans, $status) {

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;


        switch (trim($status)) {
            case "0":
                $message = \Yii::t('app', 'AMOUNT_CHARGE');
                $find_transaction->message_send = $message;
                $find_transaction->sub_menu = 1;
                $find_transaction->save();
                break;

            case "1":

                if ($response == "0") {
                    $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                    if (sizeof($all_menu) > 0) {
                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                        $i = 1;

                        if (sizeof($all_menu) < $nbre_show) {

                            foreach ($all_menu as $menu) {
                                $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                $i++;
                            }
                            $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 0;
                        } else {

                            $count = 0;
                            for ($i = 0; $i < $nbre_show; $i++) {
                                $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                $count++;
                            }

                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                            $message .= "\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 1;
                        }
                        $find_transaction->message_send = $message;
                    } else {
                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    }

                    $find_transaction->menu = -1;
                    $find_transaction->sub_menu = 0;
                    $find_transaction->save();
                } else {
                    switch (trim($sub_menu)) {
                        case "1":

                            if (is_numeric($response)) {

                                $message = \Yii::t('app', 'CHARGE_OF') . " " . $response . " Fcfa " . \Yii::t('app', 'ON_ACCOUNT') . " \n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER') . "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');


                                $find_transaction->others = $response;
                                $find_transaction->message_send = $message;
                                $find_transaction->sub_menu = 2;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                            break;
                        case "2":

                            if ($response == "1") {

                                $amount_charge = (int) $find_transaction->others;
                                $info_user = User::findOne(['id' => $find_transaction->iduser]);
                                $amount_compte = $info_user->solde;
                                $info_user->solde = $amount_charge + $amount_compte;
                                $info_user->save();

                                $message = \Yii::t('app', 'SUCCES_CREDIT') . ": " . $info_user->solde . " Fcfa";

                                //envoyer un message a l'annonceur											

                                $receiver = $find_transaction->username;
                                $sender = "E-agri";
                                $sms = $message;
                                $this->send_sms($sms, $sender, $receiver);



                                //cloturer la transaction avec succes
                                $find_transaction->message = $message;
                                $find_transaction->etat_transaction = 1;
                                $find_transaction->save();
                            } else if ($response == "2") {
                                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                                if (sizeof($all_menu) > 0) {
                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    $i = 1;

                                    if (sizeof($all_menu) < $nbre_show) {

                                        foreach ($all_menu as $menu) {
                                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                            $i++;
                                        }
                                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                }

                                $find_transaction->menu = -1;
                                $find_transaction->sub_menu = 0;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }

                            break;
                    }
                }
                break;
        }

        return $message;
    }

    public function forfait_contact($response, $id_trans, $status) {

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;


        switch (trim($status)) {
            case "0":
                $message = \Yii::t('app', 'AMOUNT_FORFAIT') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                $find_transaction->message_send = $message;
                $find_transaction->sub_menu = 1;
                $find_transaction->save();
                break;

            case "1":

                if ($response == "0") {
                    $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                    if (sizeof($all_menu) > 0) {
                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                        $i = 1;

                        if (sizeof($all_menu) < $nbre_show) {

                            foreach ($all_menu as $menu) {
                                $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                $i++;
                            }
                            $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 0;
                        } else {

                            $count = 0;
                            for ($i = 0; $i < $nbre_show; $i++) {
                                $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                $count++;
                            }

                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                            $message .= "\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 1;
                        }
                        $find_transaction->message_send = $message;
                    } else {
                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    }

                    $find_transaction->menu = -1;
                    $find_transaction->sub_menu = 0;
                    $find_transaction->save();
                } else {
                    switch (trim($sub_menu)) {
                        case "1":

                            if (is_numeric($response)) {
                                //recuperer le nombre de jour correspondant
                                $jour = $this->abnjour($response);

                                $message = \Yii::t('app', 'MOYEN_PAYMENT') . "\n1. " . \Yii::t('app', 'PAYMENT_EAGRI') . "\n2. " . \Yii::t('app', 'PAYMENT_MOBILE') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');


                                $content = \Yii::t('app', 'ACTIVATION_FORFAIT') . " " . $jour . " " . \Yii::t('app', 'DAY') . " " . \Yii::t('app', 'PRIX_PAQUET') . ": " . $response . " Fcfa ";
                                $find_transaction->others = $response . "-" . $jour;
                                $find_transaction->message_send = $message;
                                $find_transaction->message = $content;
                                $find_transaction->sub_menu = 2;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                            break;
                        case "2":

                            if ($response == "1" or $response == "2") {


                                $content = "";
                                if ($response == "1") {
                                    $content = $find_transaction->message . " " . \Yii::t('app', 'WITH') . " " . \Yii::t('app', 'PAYMENT_EAGRI') . ".";
                                } else if ($response == "2") {
                                    $content = $find_transaction->message . " " . \Yii::t('app', 'WITH') . " " . \Yii::t('app', 'PAYMENT_MOBILE') . ".";
                                }



                                $message = $content . "\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER') . "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                                $selection = $find_transaction->others;


                                $find_transaction->others = $selection . "-" . $response;
                                $find_transaction->message = $content;
                                $find_transaction->message_send = $message;
                                $find_transaction->sub_menu = 3;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                            break;
                        case "3":

                            if ($response == "1") {

                                $recup_info = explode("-", $find_transaction->others);

                                $montant = $recup_info[0];
                                $nbre_jours = $recup_info[1];
                                $moyen = $recup_info[2];

                                if ($moyen == "1") {
                                    // SELECTION DU MOYEN DE PAYEMENT E-agri
                                    //recuperer les info de l'utilisateur
                                    $info_user = User::findOne(['id' => $find_transaction->iduser]);

                                    $amount_compte = $info_user->solde;
                                    $abnexpire = $info_user->abnexpire;

                                    if ($amount_compte >= $montant) {

                                        $new_solde = $amount_compte - $montant;

                                        $date_operation = $abnexpire;
                                        if ($abnexpire == "" or $abnexpire < date("Y-m-d")) {
                                            $date_operation = date("Y-m-d");
                                        }



                                        list($Y, $m, $d) = explode('-', $date_operation);
                                        $validite = Date("Y-m-d", mktime(0, 0, 0, $m, $d + $nbre_jours, $Y));

                                        $info_user->abnexpire = $validite;
                                        $info_user->solde = $new_solde;
                                        $info_user->save();

                                        $message = $find_transaction->message . " " . \Yii::t('app', 'SOLDE') . ": " . $info_user->solde . "F cfa. " . \Yii::t('app', 'VALIDITE') . ": " . $info_user->abnexpire;

                                        $receiver = $find_transaction->username;
                                        $sender = "E-agri";
                                        $sms = $message;
                                        $this->send_sms($sms, $sender, $receiver);


                                        $find_transaction->message = $message;
                                        $find_transaction->etat_transaction = 1;
                                        $find_transaction->save();
                                    } else {
                                        $message = \Yii::t('app', 'SOLDE1_INSUFFISANT');
                                        $find_transaction->etat_transaction = 2;
                                        $find_transaction->save();
                                    }
                                } else if ($moyen == "2") {
                                    // SELECTION DU MOYEN DE PAYEMENT MOBILE MONEY

                                    $message = $find_transaction->message . " " . \Yii::t('app', 'SUCCES_ACTIVATION');

                                    $find_transaction->message = $message;
                                    $find_transaction->etat_transaction = 1;
                                    $find_transaction->save();
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                    $find_transaction->save();
                                }
                            } else if ($response == "2") {
                                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                                if (sizeof($all_menu) > 0) {
                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    $i = 1;

                                    if (sizeof($all_menu) < $nbre_show) {

                                        foreach ($all_menu as $menu) {
                                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                            $i++;
                                        }
                                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                }

                                $find_transaction->menu = -1;
                                $find_transaction->sub_menu = 0;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }

                            break;
                    }
                }
                break;
        }

        return $message;
    }

    public function mon_compte($response, $id_trans, $status) {

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);
        $page_menu = trim($find_transaction->page_menu);

        $id_pays = ConsoleappinitController::ID_COUNTRY;
        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        switch (trim($status)) {
            case "0":

                $message = \Yii::t('app', 'INFO_COMPTE') . "\n1. " . \Yii::t('app', 'CONSULT_SOLDE') . " \n2. " . \Yii::t('app', 'UPDATE_PASSE') . " \n3. " . \Yii::t('app', 'MY_COUNTRY') . " \n4. " . \Yii::t('app', 'UPDATE_REGION') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                $find_transaction->message_send = $message;
                $find_transaction->sub_menu = 1;
                $find_transaction->save();
                break;

            case "1":

                if ($response == "0") {
                    $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                    if (sizeof($all_menu) > 0) {
                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                        $i = 1;

                        if (sizeof($all_menu) < $nbre_show) {

                            foreach ($all_menu as $menu) {
                                $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                $i++;
                            }
                            $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 0;
                        } else {

                            $count = 0;
                            for ($i = 0; $i < $nbre_show; $i++) {
                                $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                $count++;
                            }

                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                            $message .= "\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 1;
                        }
                        $find_transaction->message_send = $message;
                    } else {
                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    }

                    $find_transaction->menu = -1;
                    $find_transaction->sub_menu = 0;
                    $find_transaction->save();
                } else {
                    switch (trim($sub_menu)) {
                        case "1":
                            switch (trim($response)) {
                                case "1":
                                    $message = \Yii::t('app', 'YOUR_PASSE') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                                    $find_transaction->page_menu = 1;
                                    $find_transaction->sub_menu = 2;
                                    $find_transaction->message_send = $message;
                                    $find_transaction->message = "";
                                    $find_transaction->others = "";
                                    $find_transaction->save();
                                    break;

                                case "2":
                                    $message = \Yii::t('app', 'OLD_PASSE') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                    ;

                                    $find_transaction->page_menu = 2;
                                    $find_transaction->sub_menu = 3;
                                    $find_transaction->message_send = $message;
                                    $find_transaction->message = "";
                                    $find_transaction->others = "";
                                    $find_transaction->save();
                                    break;

                                case "3":

                                    $info_pays = Pays::findOne(['id' => $id_pays]);

                                    if ($info_pays !== null) {

                                        $message = \Yii::t('app', 'ACTUEL_COUNTRY') . ": " . $info_pays->nom_fr_fr . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                    } else {
                                        $find_transaction->etat_transaction = 1;
                                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    }

                                    $find_transaction->page_menu = 3;
                                    $find_transaction->sub_menu = 4;
                                    $find_transaction->message_send = $message;
                                    $find_transaction->message = "";
                                    $find_transaction->others = "";
                                    $find_transaction->save();

                                    break;

                                case "4":


                                    $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();
                                    if (sizeof($all_region) > 0) {
                                        $message = \Yii::t('app', 'NEW_REGION');
                                        $i = 1;

                                        if (sizeof($all_region) < $nbre_show) {

                                            foreach ($all_region as $regions) {
                                                $message .= "\n" . $i . ". " . $regions->nomregion;
                                                $i++;
                                            }
                                            $find_transaction->page_menu = 0;
                                        } else {

                                            $count = 0;
                                            for ($i = 0; $i < $nbre_show; $i++) {
                                                $message .= "\n" . ($i + 1) . ". " . $all_region[$i]->nomregion;
                                                $count++;
                                            }

                                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            $find_transaction->page_menu = 1;
                                        }
                                        $find_transaction->message_send = $message;
                                    } else {
                                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                        $find_transaction->etat_transaction = 2;
                                    }

                                    $find_transaction->sub_menu = 5;
                                    $find_transaction->message_send = $message;
                                    $find_transaction->message = "";
                                    $find_transaction->others = "";
                                    $find_transaction->save();


                                    break;

                                default:
                                    $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                                    break;
                            }

                            break;
                        case "2":

                            $info_user = User::findOne(['id' => $find_transaction->iduser]);
                            $test_password = Yii::$app->security->validatePassword($response, $info_user->password_hash);
                            if ($test_password) {

                                $message = \Yii::t('app', 'SOLDE') . ": " . $info_user->solde . "Fcfa. " . \Yii::t('app', 'ALERT_SMS') . ": " . $info_user->alerte . ". " . \Yii::t('app', 'VALIDITE_ABN') . ": " . $info_user->abnexpire;
                                $find_transaction->etat_transaction = 1;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                            break;
                        case "3":

                            $old_password = $find_transaction->others;
                            $new_password = $find_transaction->message;
                            if ($old_password == "") {

                                $message = \Yii::t('app', 'NEW_PASSE') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                                $find_transaction->others = $response;
                                $find_transaction->message_send = $message;
                                $find_transaction->save();
                            } else if ($new_password == "") {

                                if ($old_password != $response) {
                                    $message = \Yii::t('app', 'CONFIRMER_PASSE') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                                    $find_transaction->message = $response;
                                    $find_transaction->message_send = $message;
                                    $find_transaction->save();
                                } else {
                                    $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                                }
                            } else {
                                if ($new_password == $response) {

                                    //confirmer si l'ancien mot de passe est correct
                                    $info_user = User::findOne(['id' => $find_transaction->iduser]);
                                    $test_password = Yii::$app->security->validatePassword($old_password, $info_user->password_hash);

                                    if ($test_password) {
                                        $message = \Yii::t('app', 'SUCCES_PASSWORD');

                                        $info_user->password_hash = Yii::$app->security->generatePasswordHash($response);
                                        $info_user->save();

                                        $find_transaction->message = $message;
                                        $find_transaction->etat_transaction = 1;
                                        $find_transaction->save();
                                    } else {

                                        $message = \Yii::t('app', 'ERREUR') . ": " . \Yii::t('app', 'OLD_PASSE') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                                        $find_transaction->message_send = \Yii::t('app', 'OLD_PASSE') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                        $find_transaction->message = "";
                                        $find_transaction->others = "";
                                        $find_transaction->save();
                                    }
                                } else {
                                    $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                                }
                            }

                            break;
                        case "5":
                            if ($response == $previor_show) {

                                $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();

                                if (sizeof($all_region) > 0) {


                                    $page_actuelle = (int) $find_transaction->page_menu;

                                    if ($page_actuelle > 1) {

                                        $message = "";
                                        $start = ($page_actuelle - 2) * $nbre_show;

                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                            if ($i < sizeof($all_region)) {
                                                if ($message != "")
                                                    $message .= "\n";
                                                $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                                $count++;
                                            }
                                        }

                                        if ($start > 0) {
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        } else {
                                            $message = \Yii::t('app', 'NEW_REGION') . "\n" . $message . "\n";
                                        }
                                        $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');

                                        $find_transaction->page_menu = $page_actuelle - 1;
                                    } else {

                                        $message = \Yii::t('app', 'NEW_REGION');

                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            if ($i <= sizeof($all_region)) {
                                                if ($message != "")
                                                    $message .= "\n";
                                                $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                            }
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                    }

                                    $find_transaction->message_send = $message;
                                }else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                }


                                $find_transaction->save();
                            } else if ($response == $nest_show) {

                                $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();

                                if (sizeof($all_region) > 0) {
                                    $message = "";
                                    $i = 1;

                                    $page_actuelle = (int) $find_transaction->page_menu;
                                    $start = $page_actuelle * $nbre_show;

                                    if (sizeof($all_region) < ($nbre_show + $start)) {

                                        $nbre_reste = sizeof($all_region) - $start;

                                        if ($nbre_reste >= 1) {
                                            $count = 0;
                                            for ($i = $start; $i < ($nbre_reste + $start); $i++) {
                                                if ($message != "")
                                                    $message .= "\n";
                                                $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                                $count++;
                                            }

                                            if ($page_actuelle > 0) {
                                                $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                            }

                                            if ($count == $nbre_show) {
                                                if (sizeof($all_region) > ($nbre_show + $start)) {
                                                    $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                                }
                                            }

                                            $find_transaction->page_menu = $page_actuelle + 1;
                                        } else {

                                            $debut = ($page_actuelle - 1) * $nbre_show;
                                            for ($i = $debut; $i < sizeof($all_region); $i++) {
                                                if ($message != "")
                                                    $message .= "\n";
                                                $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                            }
                                            $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        }
                                    }else {

                                        $count = 0;
                                        for ($i = $start; $i < ($nbre_show + $start); $i++) {
                                            if ($message != "")
                                                $message .= "\n";
                                            $message .= ($i + 1) . ". " . $all_region[$i]->nomregion;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $previor_show . " " . \Yii::t('app', 'PRECEDENT');
                                        if ($count == $nbre_show) {
                                            if (sizeof($all_region) > ($nbre_show + $start)) {
                                                $message .= "\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                            }
                                        }

                                        $find_transaction->page_menu = $page_actuelle + 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                }


                                $find_transaction->save();
                            } else {
                                $all_region = Regions::find()->where(['paysId' => $id_pays])->orderBy('nomregion ASC')->all();

                                if ((int) $response <= sizeof($all_region)) {

                                    $message = \Yii::t('app', 'SUCCES_REGION') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                    $region = $all_region[((int) $response) - 1];
                                    $info_user = User::findOne(['id' => $find_transaction->iduser]);
                                    $info_user->regionsId = $region->id;
                                    $info_user->save();

                                    $find_transaction->sub_menu = 5;
                                    $find_transaction->message_send = $message;
                                    $find_transaction->message = "";
                                    $find_transaction->others = "";
                                    $find_transaction->save();
                                } else {

                                    $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                                }
                            }


                            break;
                        default:
                            $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            $find_transaction->sub_menu = 1;
                            $find_transaction->save();
                            break;
                    }
                }
                break;
        }

        return $message;
    }

    public function recommander_solution($response, $id_trans, $status) {

        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $sub_menu = trim($find_transaction->sub_menu);

        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;


        switch (trim($status)) {
            case "0":
                $message = \Yii::t('app', 'NUMERO_FRIEND') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                $find_transaction->message_send = $message;
                $find_transaction->sub_menu = 1;
                $find_transaction->save();
                break;

            case "1":

                if ($response == "0") {
                    $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                    if (sizeof($all_menu) > 0) {
                        $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                        $i = 1;

                        if (sizeof($all_menu) < $nbre_show) {

                            foreach ($all_menu as $menu) {
                                $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                $i++;
                            }
                            $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 0;
                        } else {

                            $count = 0;
                            for ($i = 0; $i < $nbre_show; $i++) {
                                $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                $count++;
                            }

                            $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                            $message .= "\n0. " . \Yii::t('app', 'AIDE');
                            $find_transaction->page_menu = 1;
                        }
                        $find_transaction->message_send = $message;
                    } else {
                        $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                    }

                    $find_transaction->menu = -1;
                    $find_transaction->sub_menu = 0;
                    $find_transaction->save();
                } else {
                    switch (trim($sub_menu)) {
                        case "1":

                            $message = \Yii::t('app', 'NUMERO_FRIEND_SUGERE') . " " . $response . "\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER') . "\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                            $find_transaction->others = $response;
                            $find_transaction->message_send = $message;
                            $find_transaction->sub_menu = 2;
                            $find_transaction->save();
                            break;
                        case "2":

                            if ($response == "1") {


                                $sms = \Yii::t('app', 'SUGES_MESSAGE') . " *228#";
                                $sender = $find_transaction->username;
                                $receiver = $find_transaction->others;
                                $this->send_sms($sms, $sender, $receiver);

                                $find_transaction->message = $sms;
                                $find_transaction->etat_transaction = 1;
                                $find_transaction->save();


                                $message = \Yii::t('app', 'SUGGESTION_SUCCESS');
                            } else if ($response == "2") {
                                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                                if (sizeof($all_menu) > 0) {
                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    $i = 1;

                                    if (sizeof($all_menu) < $nbre_show) {

                                        foreach ($all_menu as $menu) {
                                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                            $i++;
                                        }
                                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                }

                                $find_transaction->menu = -1;
                                $find_transaction->sub_menu = 0;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }

                            break;
                    }
                }
                break;
        }

        return $message;
    }

    public function meteo_utilisateur($response, $id_trans, $status) {
//        return 1111;
        $id_trans = trim($id_trans);
        $response = trim($response);

        $find_transaction = Ussdtransation::findOne(['id' => $id_trans]);

        $prix_unitaire = ConsoleappinitController::PRIX_METEO;
        $prix_unitaire_mois = ConsoleappinitController::PRIX_METEO_MOIS;
        $nbre_show = ConsoleappinitController::MENU_SYSTEME;
        $nest_show = ConsoleappinitController::SUIVANT_SYSTEME;
        $previor_show = ConsoleappinitController::PRECEDENT_SYSTEME;

        $sub_menu = trim($find_transaction->sub_menu);
        $nbre = (int) $response;
        if ($nbre == 0) {
            $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

            if (sizeof($all_menu) > 0) {
                $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                $i = 1;

                if (sizeof($all_menu) < $nbre_show) {

                    foreach ($all_menu as $menu) {
                        $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                        $i++;
                    }
                    $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 0;
                } else {

                    $count = 0;
                    for ($i = 0; $i < $nbre_show; $i++) {
                        $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                        $count++;
                    }

                    $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                    $message .= "\n0. " . \Yii::t('app', 'AIDE');
                    $find_transaction->page_menu = 1;
                }
                $find_transaction->message_send = $message;
            } else {
                $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
            }

            $find_transaction->menu = -1;
            $find_transaction->sub_menu = 0;
            $find_transaction->save();
        } else {

            switch (trim($status)) {
                case "0":
//                        $message = "1. Meteo du jour\n2. Un autre jour\n3. aujourd'hui a ...\n4. Alerte météo\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                        $message = "Code de l'editeur. " . \Yii::t('app', 'MENU PRINCIPAL');
                        $find_transaction->message_send = $message;
                        $find_transaction->sub_menu = 1;
                        $find_transaction->save();
                   
                 break;

                case "1":
                    
                    switch (trim($sub_menu)) {
                        case "1":
//                        return 11;
                            $editeur = User::find()->where(['status'=>10,'identifiant'=>$response])->one();
//                             return $editeur->id;
                            if(sizeof($editeur)==1){
                                $activites = $editeur->activites;
                                $message=\Yii::t('app', 'SELECT_ACTIVITE');
                                    $i=1;
                                    if(sizeof($activites)< $nbre_show ){

                                            foreach ($activites as $activite){
                                                    $message.="\n".$i.". ".$activite->designation;
                                                    $i++;
                                            }
                                            $find_transaction->page_menu=0;
                                    }else{

                                            $count=0;
                                            for($i=0;$i<$nbre_show;$i++){											
                                                    $message.="\n".($i+1).". ".$activites[$i]->designation;
                                                    $count++;
                                            }

                                            $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
                                            $find_transaction->page_menu=1;											
                                    }
                                    $orther='"editeurIdentif":"'.$response.'"';
                                    $find_transaction->others = $orther;
                                    $find_transaction->message_send=$message;
                                    $find_transaction->sub_menu = 2;
                                    $find_transaction->save();
//                                return $activites;
                            }else{
                                 $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send;
                            }

                            break;
                        case "2":
                          if($response==$previor_show){
                                    $editeur = User::find()->where(['status'=>10,'identifiant'=>$response])->one();
                                     $activites = $editeur->activites;
//                                        $all_categorie=Categorie::find()->orderBy('name ASC')->all();

                                    if(sizeof($activites)>0){

                                            $page_actuelle=(int)$find_transaction->page_menu;

                                            $message="";
                                            if($page_actuelle>1){

                                                    $start=($page_actuelle-2)*$nbre_show;

                                                    $count=0;
                                                    for($i=$start;$i<($nbre_show+$start);$i++){	
                                                            if($i<sizeof($activites)){

                                                                    if($message!="")$message.="\n";
                                                                    $message.=($i+1).". ".$activites[$i]->designation;
                                                                    $count++;
                                                            }
                                                    }

                                                    if($start>0){
                                                            $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                    }else{
                                                            $message=\Yii::t('app', 'SELECT_ACTIVITE')."\n".$message."\n";											 
                                                    }
                                                    $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');

                                                    $find_transaction->page_menu=$page_actuelle-1;

                                            }else{

                                                    $message=\Yii::t('app', 'SELECT_ACTIVITE');

                                                    for($i=0;$i<$nbre_show;$i++){	
                                                            if($i<=sizeof($activites)){
                                                                    $message.="\n".($i+1).". ".$activites[$i]->designation;
                                                            }
                                                    }											

                                                    $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                            }


                                            $find_transaction->message_send=$message;	

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else if($response==$nest_show){
                                    
                                      $editeur = User::find()->where(['status'=>10,'identifiant'=>$response])->one();
                                         $activites = $editeur->activites;
//                                        $activites=Categorie::find()->orderBy('name ASC')->all();
                                            return sizeof($activites);
                                        if(sizeof($activites)>0){
                                                $message="";
                                                $i=1;

                                                $page_actuelle=(int)$find_transaction->page_menu;
                                                $start=$page_actuelle*$nbre_show;

                                                if(sizeof($activites)<($nbre_show+$start) ){
                                                    

                                                        $nbre_reste=sizeof($activites)-$start;


                                                        if($nbre_reste>=1){
                                                                $count=0;
                                                                for($i=$start;$i<($nbre_reste+$start);$i++){
                                                                    if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$activites[$i]->designation;
                                                                        $count++;
                                                                }

                                                                if($page_actuelle>0){
                                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                                }

                                                                if($count==$nbre_show){
                                                                        if(sizeof($activites)>($nbre_show+$start)){
                                                                                $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                        }
                                                                }

                                                                $find_transaction->page_menu=$page_actuelle+1;
                                                        }else{

                                                                $start=($page_actuelle-1)*$nbre_show;
                                                                for($i=$start;$i<sizeof($activites);$i++){
                                                                        if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$activites[$i]->designation;
                                                                }
                                                                $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');

                                                        }

                                                }else{

                                                        $count=0;
                                                        for($i=$start;$i<($nbre_show+$start);$i++){		
                                                                if($message!="")$message.="\n";
                                                                $message.=($i+1).". ".$activites[$i]->designation;
                                                                $count++;
                                                        }

                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        if($count==$nbre_show){
                                                                if(sizeof($activites)>($nbre_show+$start)){
                                                                        $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                }
                                                        }

                                                        $find_transaction->page_menu=$page_actuelle+1;
                                                }
                                                $find_transaction->message_send=$message;

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									


                                        $find_transaction->save();

                                }else{
                                       $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                        $information=$recup_information[0];	
                                        $identifiant= $information['editeurIdentif'];
                                      $editeur = User::find()->where(['status'=>10,'identifiant'=>$identifiant])->one();
                                         $activites = $editeur->activites;
                                            if((int)$response<=sizeof($activites)){
						
                                                            $activite=$activites[(int)$response-1];
                                                            $all_ticket=Ticket::find()->where(['activiteId'=>$activite->id])->orderBy('prix ASC')->all();					
                                                            if(sizeof($all_ticket)>0){

                                                                    $message=\Yii::t('app', 'SELECT_TICKET');
                                                                    $i=1;
                                                                    if(sizeof($all_ticket)< $nbre_show ){

                                                                            foreach ($all_ticket as $ticket){
                                                                                    $message.="\n".$i.". ".$ticket->designation;
                                                                                    $i++;
                                                                            }
                                                                            $find_transaction->page_menu=0;
                                                                    }else{

                                                                            $count=0;
                                                                            for($i=0;$i<$nbre_show;$i++){											
                                                                                    $message.="\n".($i+1).". ".$all_ticket[$i]->designation;
                                                                                    $count++;
                                                                            }
                                                                            $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');											
                                                                            $find_transaction->page_menu=1;											
                                                                    }

                                                                    $find_transaction->message_send=$message;
                                                                    
                                                            }else{
                                                                    $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                                    $find_transaction->etat_transaction=2;
                                                            }
//                                                            return 12;
                                                     $orther=$find_transaction->others.',"activiteId":"'.$activite->id.'"';
//                                                    $find_transaction->message_send=$message;
                                                    $find_transaction->others=$orther;
                                                    $find_transaction->sub_menu=3;
                                                    $find_transaction->save();	
                                                
//                                                    $activite=$activites[(int)$response-1];
                                                    										
                                            }else{
                                                $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
                                            }									
                                }	
                            break;
                        case "3":
                          if($response==$previor_show){
                                     $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                    $information=$recup_information[0];	
                                    $activiteId= $information['activiteId'];
                                    $all_ticket=Ticket::find()->where(['activiteId'=>$activiteId])->orderBy('prix ASC')->all();					
//                                        $all_categorie=Categorie::find()->orderBy('name ASC')->all();
                                    if(sizeof($all_ticket)>0){

                                            $page_actuelle=(int)$find_transaction->page_menu;

                                            $message="";
                                            if($page_actuelle>1){

                                                    $start=($page_actuelle-2)*$nbre_show;

                                                    $count=0;
                                                    for($i=$start;$i<($nbre_show+$start);$i++){	
                                                            if($i<sizeof($all_ticket)){

                                                                    if($message!="")$message.="\n";
                                                                    $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                    $count++;
                                                            }
                                                    }

                                                    if($start>0){
                                                            $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                    }else{
                                                            $message=\Yii::t('app', 'SELECT_TICKET')."\n".$message."\n";											 
                                                    }
                                                    $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');

                                                    $find_transaction->page_menu=$page_actuelle-1;

                                            }else{

                                                    $message=\Yii::t('app', 'SELECT_TICKET');

                                                    for($i=0;$i<$nbre_show;$i++){	
                                                            if($i<=sizeof($all_ticket)){
                                                                    $message.="\n".($i+1).". ".$all_ticket[$i]->designation;
                                                            }
                                                    }											

                                                    $message.="\n\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                            }


                                            $find_transaction->message_send=$message;	

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else if($response==$nest_show){
                                     $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                    $information=$recup_information[0];	
                                    $activiteId= $information['activiteId'];
                                    $all_ticket=Ticket::find()->where(['activiteId'=>$activiteId])->orderBy('prix ASC')->all();	
                                        if(sizeof($all_ticket)>0){
                                                $message="";
                                                $i=1;

                                                $page_actuelle=(int)$find_transaction->page_menu;
                                                $start=$page_actuelle*$nbre_show;

                                                if(sizeof($all_ticket)<($nbre_show+$start) ){
                                                        $nbre_reste=sizeof($all_ticket)-$start;
                                                        if($nbre_reste>=1){
                                                                $count=0;
                                                                for($i=$start;$i<($nbre_reste+$start);$i++){
                                                                    if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                        $count++;
                                                                }

                                                                if($page_actuelle>0){
                                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                                }

                                                                if($count==$nbre_show){
                                                                        if(sizeof($all_ticket)>($nbre_show+$start)){
                                                                                $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                        }
                                                                }

                                                                $find_transaction->page_menu=$page_actuelle+1;
                                                        }else{

                                                                $start=($page_actuelle-1)*$nbre_show;
                                                                for($i=$start;$i<sizeof($all_ticket);$i++){
                                                                        if($message!="")$message.="\n";
                                                                        $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                }
                                                                $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        }
                                                }else{
                                                        $count=0;
                                                        for($i=$start;$i<($nbre_show+$start);$i++){		
                                                                if($message!="")$message.="\n";
                                                                $message.=($i+1).". ".$all_ticket[$i]->designation;
                                                                $count++;
                                                        }

                                                        $message.="\n\n".$previor_show." ".\Yii::t('app', 'PRECEDENT');
                                                        if($count==$nbre_show){
                                                                if(sizeof($all_ticket)>($nbre_show+$start)){
                                                                        $message.="\n".$nest_show." ".\Yii::t('app', 'SUIVANT');
                                                                }
                                                        }

                                                        $find_transaction->page_menu=$page_actuelle+1;
                                                }
                                                $find_transaction->message_send=$message;

                                        }else{
                                                $message=\Yii::t('app', 'TRANSACTION ECHOUEE');
                                                $find_transaction->etat_transaction=2;
                                        }									
                                        $find_transaction->save();

                                }else{
                                           $recup_information=Json::decode("[{".$find_transaction->others."}]");										
                                            $information=$recup_information[0];	
                                            $activiteId= $information['activiteId'];
                                            $all_ticket=Ticket::find()->where(['activiteId'=>$activiteId])->orderBy('prix ASC')->all();	
//                                         $all_categorie=Categorie::find()->orderBy('name ASC')->all();
                                            if((int)$response<=sizeof($all_ticket)){
                                                 $ticket = $all_ticket[(int)$response-1];
//                                                 return $ticket->id;
                                                    $message = "nombre de tickets ";
                                                    $orther=$find_transaction->others.',"ticketId":"'.$ticket->id.'"';
                                                    $find_transaction->others = $orther;
                                                    $find_transaction->message_send = $message;
                                                    $find_transaction->sub_menu = 4;
                                                    $find_transaction->save();
//                                           										
                                            }else{
                                                $message=\Yii::t('app', 'ERREUR').": ".$find_transaction->message_send;
                                            }									
                                }	
                            break;
                        case "4":
                           $nbre = (int) $response;
//                            if ($nbre <= 10) {
                               $recup_information=Json::decode("[{".$find_transaction->others."}]");
                                $information=$recup_information[0];	
                                $activiteId= $information['activiteId'];
                                $activite = Activite::findOne($activiteId);
                                $ticketId= $information['ticketId'];
                                $ticket = Ticket::findOne($ticketId);
                                $total = (int)$ticket->prix * $nbre;
                                $message = $activite->designation."\n"." Achat de ".$nbre." ticket(s) de ".$ticket->prix." F CFA "."\n\n1. ".\Yii::t('app', 'CONFIRMER')."\n2. ".\Yii::t('app', 'ANNULER');
                                $find_transaction->message_send = $message;
                                $orther=$find_transaction->others.',"nbre":"'.$nbre.'"';
                                $find_transaction->others = $orther;
                                $find_transaction->sub_menu = 5;
//                                $find_transaction->message = "1";
                                $find_transaction->save();
//                            } else {
//                                $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send;
//                            }
                            break;
                        case "5":
                            $response;
                            if (is_numeric($response)) {
                                $info_prix = "(" . \Yii::t('app', 'SERVICE_COST') . " " . $prix_unitaire_mois . " F CFA)";
                                if ($nbre > 1)
                                    $info_prix = "(" . \Yii::t('app', 'SERVICE_COST') . " " . $nbre . "*" . $prix_unitaire_mois . "=" . $prix_unitaire_mois * $nbre . " F CFA)";
                                $message = \Yii::t('app', 'MOYEN_PAYMENT') . " " . $info_prix . "\n1. " . \Yii::t('app', 'PAYMENT_EAGRI') . "\n2. " . \Yii::t('app', 'PAYMENT_MOBILE') . " \n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');

                                $find_transaction->message_send = $message;
                                $find_transaction->others = $response;
                                $find_transaction->sub_menu = 6;
                                $find_transaction->save();
                            }else {
                                $message = \Yii::t('app', 'ERREUR') . ":" . $find_transaction->message_send;
                            }
                            break;
                        case "6":
                            if ($response == "1" or $response == "2") {

                                $selection = $find_transaction->others;

                                $nbre = (int) $selection;
                                $content = "";
                                if ($response == "1") {
                                    $content = \Yii::t('app', 'WITH') . " " . \Yii::t('app', 'PAYMENT_EAGRI') . ".";
                                } else if ($response == "2") {
                                    $content = \Yii::t('app', 'WITH') . " " . \Yii::t('app', 'PAYMENT_MOBILE') . ".";
                                }

                                $info_prix = \Yii::t('app', 'SERVICE_COST') . " " . $prix_unitaire_mois . " F CFA";
                                if ($nbre > 1)
                                    $info_prix = \Yii::t('app', 'SERVICE_COST') . " " . $nbre . "*" . $prix_unitaire_mois . "=" . $prix_unitaire_mois * $nbre . " F CFA";


                                $content = Yii::t('app', 'CONFIRMER_SMS_METEO') . " " . $content . $info_prix;
                                $message = $content . "\n\n1. " . Yii::t('app', 'CONFIRMER') . "\n2. " . Yii::t('app', 'ANNULER') . "\n0. " . Yii::t('app', 'MENU PRINCIPAL');

                                $find_transaction->others = $selection . "-" . $response;
                                $find_transaction->message_send = $message;
                                $find_transaction->message = $content;
                                $find_transaction->sub_menu = 7;
                                $find_transaction->save();
                            }else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }
                            break;
                        case "7":
                            if ($response == "1") {

                                $recup_info = explode("-", $find_transaction->others);

                                $nbre = $recup_info[0];
                                $total_payed = $nbre * $prix_unitaire_mois;
                                $moyen = $recup_info[1];

                                if ($moyen == "1") {
                                    // SELECTION DU MOYEN DE PAYEMENT E-agri
                                    //recuperer les info de l'utilisateur
                                    $info_user = $find_transaction->user;

                                    $amount_compte = $info_user->solde;

                                    if ($amount_compte >= $total_payed) {

                                        $new_solde = $amount_compte - $total_payed;

                                        $meteoexpire = $info_user->meteoexpire;
                                        $date_operation = $meteoexpire;
                                        if ($meteoexpire == "" or $meteoexpire < date("Y-m-d")) {
                                            $date_operation = date("Y-m-d");
                                        }

                                        list($Y, $m, $d) = explode('-', $date_operation);
                                        $validite = Date("Y-m-d", mktime(0, 0, 0, $m + $nbre, $d, $Y));
                                        $validite_show = Date("d-m-Y", mktime(0, 0, 0, $m + $nbre, $d, $Y));

                                        $info_user->solde = $new_solde;
                                        $info_user->meteoexpire = $validite;
                                        $info_user->save();

                                        $sms = $find_transaction->message . " " . \Yii::t('app', 'SUCCES_SOUSCRIPTION') . " valable jusqu'au " . $validite_show;

                                        $message = \Yii::t('app', 'SUCCES_SOUSCRIPTION');
                                        $receiver = $find_transaction->username;

                                        $sender = "E-agri";
                                        $this->send_sms($sms, $sender, $receiver);


                                        $find_transaction->message = $sms;
                                        $find_transaction->etat_transaction = 1;
                                        $find_transaction->save();
                                    } else {
                                        $message = \Yii::t('app', 'SOLDE1_INSUFFISANT');
                                        $find_transaction->etat_transaction = 2;
                                        $find_transaction->save();
                                    }
                                } else if ($moyen == "2") {

                                    // SELECTION DU MOYEN DE PAYEMENT MOBILE MONEY
                                    $info_user = $find_transaction->user;

                                    $meteoexpire = $info_user->meteoexpire;
                                    $date_operation = $meteoexpire;
                                    if ($meteoexpire == "" or $meteoexpire < date("Y-m-d")) {
                                        $date_operation = date("Y-m-d");
                                    }

                                    list($Y, $m, $d) = explode('-', $date_operation);
                                    $validite = Date("Y-m-d", mktime(0, 0, 0, $m + $nbre, $d, $Y));
                                    $validite_show = Date("d-m-Y", mktime(0, 0, 0, $m + $nbre, $d, $Y));

                                    $info_user->meteoexpire = $validite;
                                    $info_user->save();

                                    $sms = $find_transaction->message . " " . \Yii::t('app', 'SUCCES_SOUSCRIPTION') . " valable jusqu'au " . $validite_show;

                                    $message = \Yii::t('app', 'SUCCES_SOUSCRIPTION');
                                    $receiver = $find_transaction->username;

                                    $sender = "E-agri";
                                    $this->send_sms($sms, $sender, $receiver);


                                    $find_transaction->message = $sms;
                                    $find_transaction->etat_transaction = 1;
                                    $find_transaction->save();
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                    $find_transaction->etat_transaction = 2;
                                    $find_transaction->save();
                                }
                            } else if ($response == "2") {

                                $all_menu = MenuUssd::find()->where(['status' => '1'])->orderBy('position_menu_ussd ASC')->all();

                                if (sizeof($all_menu) > 0) {

                                    $message = \Yii::t('app', 'BIENVENUE DANS E-TICKET');
                                    $i = 1;

                                    if (sizeof($all_menu) < $nbre_show) {

                                        foreach ($all_menu as $menu) {
                                            $message .= "\n" . $menu->position_menu_ussd . ". " . $menu->denomination;
                                            $i++;
                                        }
                                        $message .= "\n\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 0;
                                    } else {

                                        $count = 0;
                                        for ($i = 0; $i < $nbre_show; $i++) {
                                            $message .= "\n" . $all_menu[$i]->position_menu_ussd . ". " . $all_menu[$i]->denomination;
                                            $count++;
                                        }

                                        $message .= "\n\n" . $nest_show . " " . \Yii::t('app', 'SUIVANT');
                                        $message .= "\n0. " . \Yii::t('app', 'AIDE');
                                        $find_transaction->page_menu = 1;
                                    }
                                    $find_transaction->message_send = $message;
                                } else {
                                    $message = \Yii::t('app', 'TRANSACTION ECHOUEE');
                                }

                                $find_transaction->menu = -1;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . ": " . $find_transaction->message_send;
                            }

                            break;
                        case "8":
                            if ($response == "1") {
                                $message = "Entrez la longitude de votre champ\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                                $find_transaction->message_send = $message;
                                $find_transaction->sub_menu = 9;
                                $find_transaction->save();
                            } else if ($response == "2") {
                                $message = \Yii::t('app', 'CALL_CENTRE');
                                $find_transaction->message_send = $message;
                                $find_transaction->etat_transaction = 2;
                                $find_transaction->save();
                            } else {
                                $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send;
                            }
                            break;
                        case "9":
                            $message = "Entrez la latitude de votre champ\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                            $find_transaction->message_send = $message;
                            $find_transaction->others = (string) $response;
                            $find_transaction->sub_menu = 10;
                            $find_transaction->save();

                            break;
                        case "10":
                            //modification 											
                            $recup_user = $find_transaction->user;
                            $recup_user->longitude = $find_transaction->others;
                            $recup_user->latitude = $response;
                            $recup_user->save();

                            $message = "1. Meteo du jour\n2. Un autre jour\n3. aujourd'hui a ...\n4. Alerte météo\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
                            $find_transaction->message_send = $message;
                            $find_transaction->page_menu = 1;
                            $find_transaction->sub_menu = 1;
                            $find_transaction->others = "";
                            $find_transaction->save();

                            break;
                        
                        //                        case "1":
//                            if ($response == "1") {
//
//                                $info_prix = "(" . \Yii::t('app', 'SERVICE_COST') . " " . $prix_unitaire . " F CFA)";
//                                $message = \Yii::t('app', 'CONFIRMER_METEO') . " la date d'aujourd'hui " . $info_prix . "\n\n1. " . \Yii::t('app', 'CONFIRMER') . "\n2. " . \Yii::t('app', 'ANNULER');
//                                $find_transaction->message_send = $message;
//                                $find_transaction->others = (string) $nbre;
//                                $find_transaction->sub_menu = 2;
//                                $find_transaction->message = "0";
//                                $find_transaction->save();
//                            } else if ($response == "2") {
//
//                                $message = \Yii::t('app', 'SELECT_DAY');
//                                for ($i = 1; $i <= 10; $i++) {
//                                    $message .= "\n" . $i . ". " . date('d-m-Y', strtotime(date('Y-m-d') . ' + ' . $i . ' days'));
//                                }
//                                $message .= "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
//                                $find_transaction->message_send = $message;
//                                $find_transaction->others = "1";
//                                $find_transaction->sub_menu = 3;
//                                $find_transaction->save();
//                            } else if ($response == "3") {
//
//                                $message = \Yii::t('app', 'ENTRER_DAY') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
//                                $find_transaction->message_send = $message;
//                                $find_transaction->sub_menu = 4;
//                                $find_transaction->save();
//                            } else if ($response == "4") {
//
//                                $message = \Yii::t('app', 'ENTRER_MONTH') . "\n\n0. " . \Yii::t('app', 'MENU PRINCIPAL');
//                                $find_transaction->message_send = $message;
//                                $find_transaction->sub_menu = 5;
//                                $find_transaction->save();
//                            } else {
//                                $message = \Yii::t('app', 'ERREUR') . "\n" . $find_transaction->message_send;
//                            }
//
//                            break;
                    }

                    break;
            }
        }
        return $message;
    }

    public function get_meteo($nbre, $longitude, $latitude, $idUser, $phone_number, $type) {

        $new_meteo = new MeteoInformation();
        $new_meteo->lontitude = $longitude;
        $new_meteo->latitude = $latitude;
        $new_meteo->idUser = $idUser;
        $new_meteo->message = "";
        $new_meteo->date_create = date("Y-m-d H:i:s");
        $new_meteo->save();

        $all_message = "";


        $request = "APPID=1b76d749738a2d30892ccf812d88249a&lat=" . $latitude . "&lon=" . $longitude . "&cnt=" . $nbre . "&lang=fr&units=metric";
        $url = "http://api.openweathermap.org/data/2.5/forecast/daily?" . $request;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resultat = curl_exec($ch);
        curl_close($ch);
        $content = trim($resultat);

        $recup_message = Json::decode($content);
        $information = $recup_message['list'];
        $nbre_response = sizeof($information);
        if (sizeof($information) > 0) {

            $sender = "E-agri";

            if ($type == "0") {
                foreach ($information as $response) {

                    $date = $response['dt'];
                    $temp_day = $response['temp']['day'];
                    $temp_min = $response['temp']['min'];
                    $temp_max = $response['temp']['max'];
                    $temp_night = $response['temp']['night'];
                    $temp_morn = $response['temp']['morn'];
                    $temp_eve = $response['temp']['eve'];
                    $humidity = $response['humidity'];
                    $description = $response['weather'][0]['description'];
                    // setlocale(LC_TIME,"fr-FR");
                    $message = strftime("%d-%m-%Y", $date) . " " . \Yii::t('app', 'TENSE_METEO1') . $description . ". " . \Yii::t('app', 'TEMPERATURE_MOYENNE') . $temp_day .
                            " C. " . \Yii::t('app', 'TEMPERATURE_MORNING') . $temp_morn . " C, " . \Yii::t('app', 'TEMPERATURE_EVERNING') . $temp_eve .
                            " C, " . \Yii::t('app', 'TEMPERATURE_NIGHT') . $temp_night . " C. " . \Yii::t('app', 'HUMIDITE') . $humidity;

                    $this->send_sms($message, $sender, $phone_number);
                    $all_message .= "\n" . $message;
                }
            } else {
                $response = $information[$nbre_response - 1];
                $date = $response['dt'];
                $temp_day = $response['temp']['day'];
                $temp_min = $response['temp']['min'];
                $temp_max = $response['temp']['max'];
                $temp_night = $response['temp']['night'];
                $temp_morn = $response['temp']['morn'];
                $temp_eve = $response['temp']['eve'];
                $humidity = $response['humidity'];
                $description = $response['weather'][0]['description'];
                // setlocale(LC_TIME,"fr-FR");
                $message = strftime("%d-%m-%Y", $date) . " " . \Yii::t('app', 'TENSE_METEO1') . $description . ". " . \Yii::t('app', 'TEMPERATURE_MOYENNE') . $temp_day .
                        " C. " . \Yii::t('app', 'TEMPERATURE_MORNING') . $temp_morn . " C, " . \Yii::t('app', 'TEMPERATURE_EVERNING') . $temp_eve .
                        " C, " . \Yii::t('app', 'TEMPERATURE_NIGHT') . $temp_night . " C. " . \Yii::t('app', 'HUMIDITE') . $humidity . "%";

                $this->send_sms($message, $sender, $phone_number);
                $all_message .= "\n" . $message;
            }
        }



        $new_meteo->message = $all_message;
        $new_meteo->save();

        return trim($all_message);
    }
    
    public function get_conseil($info_conseil, $phone, $idUser) {

        $recup_information = Json::decode("[{" . $info_conseil . "}]");
        $information = $recup_information[0];

        $type_search = $information['type_search'];
        $categorieId = $information['categorieId'];
        if ($type_search == "1") {
            //recuperer le nombre de conseil recup_info ->orderBy(['usertype'=>SORT_ASC])
            $info_conseil = ConseilUser::find()->where("id_speculation='" . $categorieId . "' and id_user='" . $idUser . "' order by id_conseilUser desc limit 0,1")->all();

            $id_conseil = 0;
            if (sizeof($info_conseil) == 1) {
                $id_conseil = $info_conseil[0]->id_conseil;
            }

            //recuperer les informations du message
            $info_message = Conseil::find()->where("statut='1' and id_speculation='" . $categorieId . "' and id_conseil>'" . $id_conseil . "' order by id_conseil ASC limit 0,2")->all();

            if (sizeof($info_message) > 0) {

                $ConseilUser = new ConseilUser();
                $ConseilUser->id_speculation = $categorieId;
                $ConseilUser->id_user = $idUser;
                $ConseilUser->id_conseil = $info_message[0]->id_conseil;
                $ConseilUser->date_create = date("Y-m-d H:i:s");
                $ConseilUser->save();

                $plus = "";
                if (sizeof($info_message) == 2) {
                    $plus = "\n" . \Yii::t('app', 'MORE_INFO_CONSEIL');
                }
                $message = $info_message[0]->content . $plus;

                $sender = "E-agri";
                $this->send_sms($info_message[0]->content, $sender, $phone);
            } else {
                $message = \Yii::t('app', 'NO_INFO_CONSEIL');
            }
        } else if ($type_search == "2") {
            $message = \Yii::t('app', 'CALL_CENTRE_CONSEIL');
        }

        return $message;
    }

    public function abnjour($montant) {
        switch ($montant) {
            case(5000):
                return 30;
                break;

            case $montant < 5000:
                $prix_jour = 240;
                $bonus = -2;
                $nbre_jour = ($montant / $prix_jour) - $bonus;
                return ceil($nbre_jour);
                break;

            case $montant > 5000:
                $prix_jour = 150;
                $bonus = 2;
                $nbre_jour = ($montant / $prix_jour) - $bonus;
                return ceil($nbre_jour);
                break;

            default:
                return 0;
                break;
        }
    }

    public function paquet_sms($id_operateur) {

        $tab_paquet = array();
        //recuperer le prix du service
        $facturation = Facturation::findOne(['serviceId' => 13, 'operateursId' => $id_operateur]);
        if ($facturation !== null) {
            $amount_sms = $facturation->prix;

            $nbre_sms = 10;
            $pourcent = 0;
            $amount = ($amount_sms * $nbre_sms) * (1 - $pourcent);
            $tab_paquet[0] = array("nbre" => $nbre_sms, "prix" => $amount);

            $nbre_sms = 100;
            $pourcent = 0.05;
            $amount = ($amount_sms * $nbre_sms) * (1 - $pourcent);
            $tab_paquet[1] = array("nbre" => $nbre_sms, "prix" => $amount);

            $nbre_sms = 500;
            $pourcent = 0.1;
            $amount = ($amount_sms * $nbre_sms) * (1 - $pourcent);
            $tab_paquet[2] = array("nbre" => $nbre_sms, "prix" => $amount);

            $nbre_sms = 1000;
            $pourcent = 0.15;
            $amount = ($amount_sms * $nbre_sms) * (1 - $pourcent);
            $tab_paquet[3] = array("nbre" => $nbre_sms, "prix" => $amount);
        }
        return $tab_paquet;
    }

    public function actionCheck_user($numero, $name, $firstname, $status) {

        $find_user = User::findOne(['contact' => $numero]);
        $nbre_user = sizeof($find_user);

        if ($nbre_user == 0) {
            $type_user = \console\models\TypeUser::findOne(['designation' => 'client']);
            $password = rand(123456, 999999);
            $user = new User();
            $user->username = $name;
            $user->prenoms = $firstname;
            $user->contact = $numero;
            $user->type_userId = $type_user->id;
            $user->status = 10;
            $user->created_at = time();
            $user->auth_key = Yii::$app->security->generateRandomString(32);
            $user->password_hash = Yii::$app->security->generatePasswordHash($password);
            if ($user->save()) {
                $id = $user->id;

                $message = \Yii::t('app', 'INFO_CONNEXION') . "." . \Yii::t('app', 'LOGIN') . ":" . $numero . " " . \Yii::t('app', 'PASSWORD') . ":" . $password . ". " . \Yii::t('app', 'TEXTE_UPDATE_PASSWORD') . "\n.www.e-agribusiness.com";

                $sender = "E-ticket";
                $receiver = $numero;

//				$this->send_sms($message,$sender,$receiver);
            } else {
//                            print_r($user);exit;
                $id = 0;
            }
        } else {
            if ($status == 0) {

                $find_user->username = $name;
                $find_user->prenoms = $firstname;

                if ($find_user->save()) {
                    $id = $find_user->id;
                } else {
                    $id = 0;
                }
            } else {
                $id = $find_user->id;
            }
        }
        return $id;
    }

//	public function actionCheck_transaction($idtransaction,$telephone,$iduser,$status){
    public function actionCheck_transaction($idtransaction, $telephone, $status) {

        $find_transaction = Ussdtransation::findOne(['idtransaction' => $idtransaction, 'username' => $telephone, 'etat_transaction' => 0]);
//	    $find_transaction = Ussdtransation::findOne(['idtransaction'=>$idtransaction,'username'=>$telephone,'iduser'=>$iduser,'etat_transaction'=>0]);
        $nbre_transaction = sizeof($find_transaction);


        $id_transaction = 0;
        if ($nbre_transaction == 0) {

            if ($status == "0") {
                $transaction = new Ussdtransation();
                $transaction->idtransaction = $idtransaction;
                $transaction->username = $telephone;
//				$transaction->iduser = $iduser;
                $transaction->menu = "-1";
                $transaction->datecreation = date("Y-m-d H:i:s");
                $transaction->sub_menu = 0;
                $transaction->page_menu = 0;
                $transaction->etat_transaction = 0;
                $transaction->reference = "121212";
                $transaction->others = "";

                if ($transaction->save()) {
                    $id_transaction = $transaction->id;
                } else {
                    print_r($transaction->getErrors());
                    exit;
                }
            }
        } else {
            $id_transaction = $find_transaction->id;
        }

        return $id_transaction;
    }

    public function send_sms($message, $receiver) {

        set_time_limit(0);
        $sender = "e-Ticket";
        $text = urlencode($message);
        $dlrurl = "";
        $url = "http://www.wassasms.com/wassasms/api/web/v3/sends?access-token=O1Yk--5TCb-792TKyOTBG5RVJTlrNIML&sender=".$sender."&receiver=".$receiver."&text=".$text."&dlr_url=".$dlrurl;
        // $url = "http://".$_SERVER["HTTP_HOST"].Yii::$app->request->baseUrl."/api/web/v3/sends?access-token=O1Yk--5TCb-792TKyOTBG5RVJTlrNIML";
        $curl = curl_init();
        //trim($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $return = curl_exec($curl);
        $retour = trim($return);
        if ($retour) {
            return true;
        }
    }
    
        public function random($taille) {
            $string = "";
            $chaine = "123456789";
            srand((double)microtime()*1000000);
            for($i=0; $i<$taille; $i++) {
            $string .= $chaine[rand()%strlen($chaine)];
            }
            return $string;
        }

    public function save_autorisation($user_id, $annonce_id) {

        $find_autorisation = Autorisation::findOne(['userId' => $user_id, 'annonceId' => $annonce_id]);

        if (sizeof($find_autorisation) == 0) {
            $autorisation = new Autorisation();
            $autorisation->userId = $user_id;
            $autorisation->annonceId = $annonce_id;
            $autorisation->jour = date("Y-m-d");
            $autorisation->heure = date("H:i:s");
            $autorisation->save();
        }
    }

    function wd_remove_accents($str, $charset) {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

        return $str;
    }

}
