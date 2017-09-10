<?php

namespace mipotech\affiliates\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\course\Course;

/**
 *
 */
class AffiliateStatisticDataSearch extends AffiliateStatisticData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'created_at', 'price'], 'integer'],
            [['aff_id', 'camp_id', 'url', 'ip'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find()->orderBy('created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->start_date,
            'created_at' => $this->end_date,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'aff_id', $this->aff_id])
			->andFilterWhere(['like', 'camp_id', $this->camp_id])
            ->andFilterWhere(['like', 'url', $this->url])
			->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
