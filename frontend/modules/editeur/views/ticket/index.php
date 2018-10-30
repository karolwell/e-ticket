<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\editeur\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>

<br>
<div class="ticket-index">

    <?php if ($dataProvider!=null): ?>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="row">
            <div class="col-md-12" style="float:right;">

                <div class="col-md-4" style="top:-10px;">
                    <?= Html::a('Nouveau ticket', ['create'], ['class' => 'btn btn-success']) ?>
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


                <div class="row container">

            <?php
                       //$pjax =  Pjax::begin();
            $empty_message = '<div class="alert-danger alert fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>';


            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'class' => '.list-view col-md-10',
                ],
                'itemOptions' => ['class' => ''],
                'emptyText' => $empty_message,
                'summary' => false,
                'layout' => '{items}<div class="pagination-wrap">{pager}</div>',
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_ticket', ['model' => $model]);
                },

            ]);
                        //Pjax::end();
            ?> 


        </div>
    </div>
    <?php else: ?>

        <div class="alert alert-info col-md-12"> Aucun ticket disponible ...</div>

    <?php endif ?>
 
