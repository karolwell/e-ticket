<?php 
use frontend\modules\editeur\models\CategorieActivite;
use frontend\modules\editeur\models\Activite;
?>

<div class="order-md-2">
	<div class="card-deck row">
		<div class="card_ margin-bottom-1x col-lg-12 col-md-12  ">
			<div class="" style="float:left; width:25%;">
				<img class="" src="<?php echo Yii::$app->homeUrl.'images/activites/'.$model->image ?>" alt="Card image" style="height:200px; width:100%;" />
			</div>
			<div style="width:100%; float:left; text-align: justify;" class="card-body col-lg-8 col-md-8" style="margin-top:-2%">
				<h5 class="card-title"><?= $model->designation  ?></h5> 
				<p class="card-text"><?= strlen($model->description )>34?substr($model->description , 0,34).' ...' : $model->description ?> </p>
				<hr class="margin-bottom-1x">
				<table class="table table-striped table-condensed table-hover">
				<tr><th>Lieu</th> <td><?= $model->lieu ?></td> </tr>
				<tr><th>Début</th> <td><?= $model->datedebut.' '.$model->heuredebut ?></td> </tr>
				<tr><th>Fin</th> <td><?= $model->datefin.' '.$model->heurefin   ?></td> </tr>
					
				</table>
				<!-- <p class="card-text"> <strong>Lieu :</strong> </p>
				<p class="card-text"> <strong>Début :</strong> <?= $model->datedebut.' '.$model->heuredebut ?></p>
				<p class="card-text"> <strong>Fin :</strong> <?= $model->datefin.' '.$model->heurefin   ?></p> -->
			</div>

			<div class=" text-center col-lg-1 col-md-1 row" style="color: #FFF; font-size: 20px; margin-top: 4%; with:5%;">
				<hr class="margin-top-1x">
				<div class="col-sm-12"> <a style="color:#3FAABF" href="<?php echo Yii::$app->homeUrl ?>editeur/activite/view?id=<?php echo $model->id ?>"  > <i class="fa fa-eye"></i> </a> </div>
				<div class="col-sm-12"> <a style="color:#3FAABF" href="<?php echo Yii::$app->homeUrl ?>editeur/activite/update?id=<?php echo $model->id ?>"> <i class="fa fa-pencil"></i> </a> </div>
				<div class="col-sm-12"> <a style="color:#182225" href="" type="button" data-toggle="modal" data-target="#modalDefault"> <i class="fa <?= $model->etat==Activite::STATUS_ACTIVE ?'fa-times':'fa-check'  ?>" ></i> </a> </div>
				<div class="col-sm-12"> <a style="color:#D73C27" href="" type="button" data-toggle="modal" data-target="#modalDefault"> <i class="fa fa-trash"></i> </a> </div>
				<div class="text-center col-sm-12" ><a style="color: #FFF; <?= $model->etat==Activite::STATUS_ACTIVE ?'background-color: /*#43d9a3*/; color:#43d9a3;':'background-color: rgba(255, 255, 255, 0.7); color:#aaa;'  ?> padding: 2px; margin-left:0%; float: right;" href="" type="button" data-toggle="modal" data-target="#modalDefault"> <?= $model->etat==Activite::STATUS_ACTIVE ?'<i class="fa fa-share"></i>':'<del><i class="fa fa-recycle"></i></del>'  ?></a> </div>
			</div>
		</div>
	</div>
</div>