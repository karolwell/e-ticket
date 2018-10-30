<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\modules\editeur\models\CategorieActivite;
use frontend\modules\editeur\models\Activite;

/* @var $this yii\web\View */
/* @var $model frontend\modules\editeur\models\Activite */

$this->title = $model->designation;
$this->params['breadcrumbs'][] = ['label' => 'Activites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$designation = CategorieActivite::findOne(['id'=>$model->categorie_activiteId])->designation;

$model->etat = Activite::STATUS_ACTIVE?$etat='Active':$etat='Inactive';
?>

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
            'data-target' => '#modalDefault'
/*            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],*/
        ]) ?>
    </p>

</div>

<div class="col-md-12">

    <div class="col-md-5" style="height: ">
        <img src="<?= Yii::$app->homeUrl.'images/activites/'.$model->image ?>" style="width: 100%; height: 225px;"/>
    </div>

    <div class="col-md-7">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            //'id',
                'designation',
                'description'=>[

                    'label'=>'Description',
                    'value'=>$model->description?$model->description:'...',
                ],
           // 'editeurId',
                'categorie_activiteId'=>[

                    'label'=>'Categorie',
                    'value'=>$designation,
                ],
                'lieu',
                'datedebut'=>[

                    'label'=>'Debut',
                    'value'=>$model->datedebut.' '.$model->heuredebut,
                ],
            //'heuredebut',
                'datefin'=>[

                    'label'=>'Fin',
                    'value'=>$model->datefin.' '.$model->heurefin,
                ],
            //'heurefin',
            //'reference',
            /*'image'=>[

                'attributes'=>'image',
                'value'=>function($data){
                    //return Html::img(Yii::$app->homeUrl.'images/activite/'.$model->image, ['alt' => 'My logo']);
                    echo  '< img src="'.Yii::$app->homeUrl.'images/activite/"'.$data['image'].'>';
                },
            ],*/
            /*[
                'attribute'=>'image',
                'value'=>Yii::$app->homeUrl.'images/activites/'.$model->image,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],*/
            //'latitude',
            //'longitude',
            //'etat',
            //'created_by',
            //'date_create',
            //'updated_by',
            //'date_update',
        ],
    ]) ?>

</div>
</div>
