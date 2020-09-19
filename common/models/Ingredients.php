<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ingredients".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property IngredientsToFood[] $ingredientsToFoods
 */
class Ingredients extends \yii\db\ActiveRecord
{
    const ACTIVE = 10;
    const INACTIVE = 9;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    public static function map()
    {
        return ArrayHelper::map(self::find()
            ->andWhere(['status' => self::ACTIVE])
            ->select(['id', 'name'])
            ->asArray()
            ->all(), 'id', 'name');
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[IngredientsToFoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIngredientsToFoods()
    {
        return $this->hasMany(IngredientsToFood::className(), ['ingredient_id' => 'id']);
    }

    public function getFood()
    {
        return $this->hasMany(Food::className(), ['id' => 'food_id'])->via('ingredientsToFoods');
    }

    public function afterSave($insert, $changedAttributes)
    {
        Food::updateAll(
            [
                'status' => $this->status
            ],
            [
                'id' => $this->getIngredientsToFoods()->select('food_id')->column()
            ]);

        parent::afterSave($insert, $changedAttributes);
    }
}
