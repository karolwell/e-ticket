<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\editeur\models\AbonnementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Abonnements';
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<div class="abonnement-index">

    <?php if ($dataProvider!=null): ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-md-12" style="float:right;">

            <div class="col-md-4" style="top:-10px;">
                <?= Html::a('Nouvel abonnement', ['create'], ['class' => 'btn btn-success']) ?>
            </div>


            <div class="col-md-7" style="top:-7px; ">
                <input class="form-control" type="" name="" placeholder="Recherche..."  oninput="filter(this, 'exp')" />
            </div>

            <div class="col-md-1">
                <i class="fa fa-2x fa-search"></i>
            </div>

        </div>
        <div class="col-md-12">
            <h6 class="text-muted text-normal text-uppercase"><?= Html::encode($this->title) ?></h6>
            <hr class="margin-bottom-1x">
        </div>
    </div>

    <div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
        //'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-bordered  table-vertical-middle  table-hover table-condensed table-striped ',
                'id' => 'exp',
                'style' => 'font-size:15px;',
            ],

            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

            //'id',
                //'editeurId',
                'type_abonnementId'=>[
                    "label"=>"Type abonnement",
                    "value"=>"typeAbonnement.designation"
                ],
                'date_detut_abonnement:date'=>[
                'label'=>'Debut',
                'value'=>'date_detut_abonnement',
            ],
                'date_fin_abonnement:date'=>[
                'label'=>'Fin',
                'value'=>'date_fin_abonnement',
            ],
            // 'etat',

                ['class' => 'yii\grid\ActionColumn'],
            ],
            ]); ?>
        </div>
    <?php else: ?>

        <div class="alert alert-info col-md-12"> Aucune souscription n'est en cours ...</div>

    <?php endif ?>