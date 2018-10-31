<?php 
use frontend\modules\editeur\models\CategorieActivite;
use frontend\modules\editeur\models\Activite;
?>

<div class="order-md-2">
	<div class="card-deck row">
		<div class="card_ margin-bottom-1x col-lg-12 col-md-12  ">
			<div class="" style="float:left; width:25%;">
				<img class="" src="<?php echo Yii::$app->homeUrl.'images/abonnements/'.strtolower($model->typeAbonnement->designation).'-card.jpg' ?>" alt="Card image" style="height:200px; width:100%;" />
			</div>
			<div style="width:100%; float:left; text-align: justify;" class="card-body col-lg-8 col-md-8" style="margin-top:-2%">
				<h5 class="card-title"><?= $model->typeAbonnement->designation  ?></h5> 
				<p class="card-text"><?= strlen($model->typeAbonnement->description )>200?substr($model->typeAbonnement->description , 0,200).' ...' : $model->typeAbonnement->description ?> </p>
				<hr class="margin-bottom-1x">
				<table class="table table-striped table-condensed table-hover">
				<tr><th>Début</th> <td><?= $model->date_detut_abonnement ?></td> </tr>
				<tr><th>Fin</th> <td><?= $model->date_fin_abonnement ?></td> </tr>
					
				</table>
			</div>

			<div class=" text-center col-lg-1 col-md-1 row" style="color: #FFF; font-size: 20px; margin-top: 4%; with:5%;">
				<hr class="margin-top-1x">
				<div class="col-sm-12"> <a style="color:#3FAABF" href="<?php echo Yii::$app->homeUrl ?>editeur/abonnement/view?id=<?php echo $model->id ?>"  > <i class="fa fa-eye"></i> </a> </div>
<!-- 				<div class="col-sm-12"> <a style="color:#3FAABF" href="<?php echo Yii::$app->homeUrl ?>editeur/abonnement/update?id=<?php echo $model->id ?>"> <i class="fa fa-pencil"></i> </a> </div> -->
				<div class="col-sm-12"> <a style="color:#182225" href="" type="button" data-toggle="modal" data-target="#modalDefault"> <i class="fa <?= $model->etat==Activite::STATUS_ACTIVE ?'fa-times':'fa-check'  ?>" ></i> </a> </div>
				<div class="col-sm-12"> <a style="color:#D73C27" href="" type="button" data-toggle="modal" data-target="#modalDefault"> <i class="fa fa-trash"></i> </a> </div>
			</div>
		</div>
	</div>
</div>