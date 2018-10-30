<?php

namespace frontend\modules\editeur\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\editeur\models\Ticket;

/**
 * TicketSearch represents the model behind the search form of `frontend\modules\editeur\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prix', 'type_ticketId', 'activiteId', 'validiteId', 'duree_validite', 'nombre_validation'], 'integer'],
            [['designation', 'nombre_ticket', 'periode'], 'safe'],
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
        $query = Ticket::find();

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
            'prix' => $this->prix,
            'type_ticketId' => $this->type_ticketId,
            'activiteId' => $this->activiteId,
            'validiteId' => $this->validiteId,
            'duree_validite' => $this->duree_validite,
            'nombre_validation' => $this->nombre_validation,
        ]);

        $query->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'nombre_ticket', $this->nombre_ticket])
            ->andFilterWhere(['like', 'periode', $this->periode]);

        return $dataProvider;
    }
}
