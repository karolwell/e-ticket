<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\editeur\models\ProtocoleFacturierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Protocole Facturiers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="protocole-facturier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Protocole Facturier', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userId',
            'url:url',
            'ftp_ip',
            'ftp_username',
            // 'ftp_password',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
