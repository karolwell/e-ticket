<?php

use yii\helpers\Html;
use frontend\models\Ticket;
use yii\helpers\Url;
use dosamigos\qrcode\QrCode;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ticket */

//$this->title = $model->id;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Abonnement */
/* @var $form yii\widgets\ActiveForm */

?>


<div  class="impression-imprimer-result">

	<?php if (isset($results["ticket"])): ?>


		<?php foreach ($results as $key => $value): ?>



			<div class="col-md-12">
				<div class="col-md-3" style="margin-top: 5px; border: 1px solid grey;">
					<p> <?php echo $value->ticket->activite->designation ?>  </p>
					<p> Du <?php echo $value->ticket->activite->datedebut ?> à <?php echo $value->ticket->activite->heuredebut ?>
					au <?php echo $value->ticket->activite->datefin ?>  à <?php echo $value->ticket->activite->heurefin ?>   </p>
					<p> lieu :  <?php echo $value->ticket->activite->lieu ?> </p>
				</div>
				<div class="col-md-7" style="margin-top: 5px; border: 1px solid grey;">
					<!-- <img src="<?php echo Yii::$app->homeUrl ?>images/<?php echo $value->ticket->typeTicket->designation ?>"> -->
					<img src="<?php echo Yii::$app->homeUrl ?>img/cart-dropdown/ticket.jpg" style="height: 150px; width: 200px;">
					<span> <?php echo $value->code ?></span>
					<?php  //print_r($value); ?>
				</div>
				<div class="col-md-1" style="margin-top: 5px; border: 1px solid grey;">
					<?php echo $value->ticket->prix ?>
				</div>

			</div>
		<?php endforeach ?>

		<?php elseif($results["tickets"]): ?>
			<?php foreach ($results["tickets"] as $key => $value): ?>

				<div onloadeddata="" class="col-md-12" style="margin: 10px;">

					<div class="ticket" >
						<input id="code" type="hidden" name="" value="<?= $value->code ?>" />
						<table border="1" border-color="#000">
							<tr>
								<td rowspan="4" style="width:30px">&nbsp;</td>
								<td colspan="2" width="50"><p style="font-size:14px;font-weight: bold"><?php echo $value->activite->designation ?></p></td>
								<td rowspan="2">
									<img src="<?php echo Yii::$app->homeUrl ?>img/cart-dropdown/ticket.jpg" style="height: 150px; width: 300px;">
								</td>
							</tr>
							<tr>
								<td>
									<p> Du <?php echo $value->activite->datedebut ?> à <?php echo $value->activite->heuredebut ?></p>
									<p> au <?php echo $value->activite->datefin ?>  à <?php echo $value->activite->heurefin ?> </p>
								</td>
								<td><p><p style="font-size:11px">Lieu</p>  <?php echo $value->activite->lieu ?> </p></td>
							</tr>
							<tr>
								<!-- <td colspan="2">Ticket N° : ...</td> -->
								<td colspan="2"><?php echo $value->prix ?></td>
								<td rowspan="2" >


								</td>
							</tr>
							<tr>
								<td colspan="2" id="barcode_<?= $key ?>"></td>
							</tr>
						</table>
					</div>
					<div class="row">
						<!-- <img src="../views/ticket/template/scissors.png" style="width:20"/> -->
						<!-- <div class="col-md-10" style="border-style:dashed; border-top:1"></div> -->
					</div>

				</div>



			<?php endforeach ?>

		<?php endif ?>


		<script type="text/javascript">

			window.onload = function() {
				$('.ticket').each(function(i) {
					var m = $('#barcode_'+i).text();
					//var q = $('#q_'+i).val();
                //alert(q);
                //$('#qrcode_'+i).qrcode({width: 110,height: 110,text: q});
                $('#codebare_'+i).barcode(m, "code128",{barWidth:2, barHeight:30});
            });

			};

		</script>
