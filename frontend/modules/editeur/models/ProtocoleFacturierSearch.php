<?php

namespace frontend\modules\editeur\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\editeur\models\ProtocoleFacturier;

/**
 * ProtocoleFacturierSearch represents the model behind the search form of `frontend\modules\editeur\models\ProtocoleFacturier`.
 */
class ProtocoleFacturierSearch extends ProtocoleFacturier
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId'], 'integer'],
            [['url', 'ftp_ip', 'ftp_username', 'ftp_password'], 'safe'],
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
        $query = ProtocoleFacturier::find();

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
            'userId' => $this->userId,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'ftp_ip', $this->ftp_ip])
            ->andFilterWhere(['like', 'ftp_username', $this->ftp_username])
            ->andFilterWhere(['like', 'ftp_password', $this->ftp_password]);

        return $dataProvider;
    }
}
