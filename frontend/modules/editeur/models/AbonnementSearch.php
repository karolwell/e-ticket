<?php

namespace frontend\modules\editeur\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\editeur\models\Abonnement;

/**
 * AbonnementSearch represents the model behind the search form of `frontend\modules\editeur\models\Abonnement`.
 */
class AbonnementSearch extends Abonnement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'editeurId', 'type_abonnementId', 'etat'], 'integer'],
            [['date_detut_abonnement', 'date_fin_abonnement'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Abonnement::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'editeurId' => $this->editeurId,
            'type_abonnementId' => $this->type_abonnementId,
            'date_detut_abonnement' => $this->date_detut_abonnement,
            'date_fin_abonnement' => $this->date_fin_abonnement,
            'etat' => $this->etat,
        ]);

        return $dataProvider;
    }
}
