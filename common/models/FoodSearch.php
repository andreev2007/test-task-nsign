<?php

namespace common\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FoodSearch represents the model behind the search form of `common\models\Food`.
 * @property mixed|null ingredients
 */
class FoodSearch extends Model
{

    public $ingredients;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['ingredients', 'required'],
            [['ingredients'], 'validateIngredients'],
        ];
    }

    public function validateIngredients($attribute, $params, $validator)
    {
        if (is_array($this->$attribute)) {
            if (count($this->$attribute) < 2) {
                $this->addError($attribute, 'Минимальное количество ингредиентов - 2');
            }
            if (count($this->$attribute) > 5) {
                $this->addError($attribute, 'Максимальное количество ингредиентов - 5');
            }
            return true;
        }
    }

    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    private function getQuery()
    {
        return Food::find()
            ->from('food as f')
            ->select('f.*, COUNT(i.id) as count')
            ->groupBy('f.id')
            ->where(['f.status' => 10])
            ->joinWith('ingredients as i');
    }

    public function attributeLabels()
    {
        return [
            'ingredients' => 'Ингредиенты'
        ];
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
        $query = $this->getQuery();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            \Yii::error($this->errors);
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->ingredients) {
            $query->andWhere(['i.id' => $this->ingredients]);
            $query->having('COUNT(i.id) = :c', ['c' => count($this->ingredients)]);
            if ($query->count() > 0) {

                return $dataProvider;
            } else {
               $query = $this->getQuery();
                $query->joinWith('ingredients as i');
                $query->andWhere(['i.id' => $this->ingredients]);
                $query->andWhere(['i.status' => Ingredients::ACTIVE]);
                $query->having('COUNT(i.id) > 1');
                $query->orderBy('count DESC');

                return $dataProvider;
            }
        }

        return $dataProvider;
    }
}
