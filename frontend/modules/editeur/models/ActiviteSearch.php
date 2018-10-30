<?php

namespace frontend\modules\editeur\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\editeur\models\Activite;

/**
 * ActiviteSearch represents the model behind the search form of `frontend\modules\editeur\models\Activite`.
 */
class ActiviteSearch extends Activite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'editeurId', 'categorie_activiteId', 'etat', 'created_by', 'updated_by'], 'integer'],
            [['designation', 'description', 'lieu', 'datedebut', 'heuredebut', 'datefin', 'heurefin', 'reference', 'image', 'latitude', 'longitude', 'date_create', 'date_update'], 'safe'],
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
        $query = Activite::find();

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
            'categorie_activiteId' => $this->categorie_activiteId,
            'datedebut' => $this->datedebut,
            'heuredebut' => $this->heuredebut,
            'datefin' => $this->datefin,
            'heurefin' => $this->heurefin,
            'etat' => $this->etat,
            'created_by' => $this->created_by,
            'date_create' => $this->date_create,
            'updated_by' => $this->updated_by,
            'date_update' => $this->date_update,
        ]);

        $query->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'lieu', $this->lieu])
            ->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'latitude', $this->latitude])
            ->andFilterWhere(['like', 'longitude', $this->longitude]);

        return $dataProvider;
    }
}
