<!--  -->
<!-- <div>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,

		'layout' => '{items}{pager}',
        //'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

            //'id',
			'designation',
			'prix',
			'nombre_ticket'=>[
				'label'=>'Nombre',
				'value'=>'nombre_ticket',
			],
			[
				'attribute'=>'type_ticketId',
				'label'=>'Type',
                    //'value'=>'type_ticketId'
				'value'=>function($data){
                                //echo $data['type_ticketId'];
					$type=TypeTicket::find()->where(['id'=>$data['type_ticketId']])->one()->designation;
					return $type;
				}
			],
			'activiteId'=>[
				'label'=>'Activite',
				'value'=>function($data){
                                //echo $data['type_ticketId'];
					$activite=Activite::find()->where(['id'=>$data['activiteId']])->one()->designation;
					return $activite;
				}
			],

			'periode'=>[
				'label'=>'Periode',
				'value'=>function($data){
                                //echo $data['type_ticketId'];
					$data['periode']?$periode=$data['periode']:$periode="-";
					return $periode;
				}
			],
			'validiteId'=>[
				'label'=>'Validite',
				'value'=>function($data){
                                //echo $data['type_ticketId'];
					$Validite=Validite::find()->where(['id'=>$data['validiteId']])->one()->designation;
					return $Validite;
				}
			],
			'duree_validite'=>[
				'label'=>'Duree',
				'value'=>function($data){
                                //echo $data['type_ticketId'];
					$data['duree_validite']?$duree_validite=$data['duree_validite']:$duree_validite="-";
					return $duree_validite;
				}
			],
			'nombre_validation'=>[
				'label'=>'Nombre validation',
				'value'=>function($data){
                                //echo $data['type_ticketId'];
					$data['nombre_validation']?$nombre_validation=$data['nombre_validation']:$nombre_validation="-";
					return $nombre_validation;
				}
			],

			[
				'class' => 'yii\grid\ActionColumn',
				'header' => 'Actions',
				'headerOptions' => ['style' => 'color:#337ab7'],
				'template' => '{view}{update}{delete}',
				'buttons' => [
					'view' => function ($url, $data) {
						$url = Url::to(['view','id'=>$data['id']]);
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
							'title' => Yii::t('app', 'Détails'),
						]);
					},

					'update' => function ($url, $data) {
						$url = Url::to(['view','id'=>$data['id']]);
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
							'title' => Yii::t('app', 'Mise à jour'),
						]);
					},
					'delete' => function ($url, $data) {
						$url = Url::to(['view','id'=>$data['id']]);
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
							'title' => Yii::t('app', 'Supprimer'),
						]);
					}

				],

			],
		],
	]); ?>
</div>
<?php else: ?>

	<div class="alert alert-info col-md-12"> Aucun ticket n'est en cours ...</div>

	<?php endif ?> -->