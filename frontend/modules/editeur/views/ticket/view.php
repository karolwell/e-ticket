<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Ticket */
/**/
$this->title = $model->activite->designation.'|'.$model->designation;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Default Modal-->
<div class="modal fade" id="modalDefault" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal title</h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <p>Modal body text goes here.</p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-white btn-sm" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-sm" type="button">Save changes</button>
    </div>
</div>
</div>
</div>

<div class="ticket-view">

 <!--  <h1><?= Html::encode($this->title) ?></h1> -->

 <div class="col-md-9">
    <h6 class="text-muted text-normal text-uppercase"><?= Html::encode($this->title) ?></h6>
    <hr class="margin-bottom-1x">
</div>

<div class="col-md-3">

    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary','type' => 'button']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger', 'type' => 'button',
            'data-toggle'=>'modal',
            'data-target'=>'#modalDefault'
/*            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],*/
        ]) ?>
    </p>

</div>

<div class="col-md-12">

    <div class="col-md-5" style="margin-top: -3%;">
        <img src="<?= Yii::$app->homeUrl.'images/tickets/'.$model->image ?>" style="width: 100%; height: 225px;
        margin-top: 60px; border: solid 2px #dddddd;" />
    </div>

    <div class="col-md-7" style="padding-bottom: 50px;">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            //'id',
              'activiteId'=>[
                "label"=>"Activite",
                "value"=> $model->activite->designation,
            ],
            'designation',
            'prix',
            'nombre_ticket',
            /*'type_ticketId'=>[
                "label"=>"Type",
                "value"=> $model->typeTicket->designation,
            ],*/
            'validiteId'=>[
                "label"=>"Validite",
                "value"=> $model->validite->designation,
            ],
                'periode'=>[
                "label"=>"Période (Min)",
                "value"=> $model->periode,
            ],
            'duree_validite'=>[
                "label"=>"Duree (J)",
                "value"=> $model->periode,
            ],
            'nombre_validation'=>[
                "label"=>"Nombre validation (J)",
                "value"=> $model->nombre_validation,
            ],
        ],
    ]) ?>

</div>
</div>

