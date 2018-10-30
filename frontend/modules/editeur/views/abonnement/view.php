<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Abonnement */

$this->title = $model->typeAbonnement->designation;
$this->params['breadcrumbs'][] = ['label' => 'Abonnements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="abonnement-view">

<div class="col-md-9">
    <h6 class="text-muted text-normal text-uppercase"><?= Html::encode($this->title) ?></h6>
    <hr class="margin-bottom-1x">
</div>

<div class="col-md-3">

    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
'data-toggle' => 'modal',
                     'class' => 'btn btn-danger',
               'data-target' => '#modalDefault'
/*            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],*/
        ]) ?>
    </p>

</div>

<div class="col-md-12">

    <div class="col-md-5" style="margin-top:-1%; ">
        <img class="" src="<?php echo Yii::$app->homeUrl.'images/abonnements/'.strtolower($model->typeAbonnement->designation).'-card.jpg' ?>" alt="Card image" style="height:200px; width:100%;" />
    </div>

    <div class="col-md-7">

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            //'id',
        'editeurId'=>[
            "label"=>"editeur",
            "value"=> Yii::$app->user->identity->username,
        ],
        'type_abonnementId'=>[
            "label"=>"Type abonnement",
            "value"=> $model->typeAbonnement->designation,
        ],
        'date_detut_abonnement',
        'date_fin_abonnement',
        'etat'=>[
            "label"=>"etat",
            "value"=> $model->etat? 'Actif':'Inactif',
        ],
    ],
]) ?>

</div>
</div>
