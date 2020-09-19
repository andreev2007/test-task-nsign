<?php

use yii\db\Migration;

class m130524_201445_ingredients_to_food extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ingredients_to_food}}', [
            'id' => $this->primaryKey(),
            'food_id' => $this->integer()->notNull(),
            'ingredient_id' => $this->integer()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            'idx-ingredients_to_food-food_id',
            'ingredients_to_food',
            'food_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-ingredients_to_food-food_id',
            'ingredients_to_food',
            'food_id',
            'food',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-ingredients_to_food-ingredient_id',
            'ingredients_to_food',
            'ingredient_id'
        );

        $this->addForeignKey(
            'fk-ingredients_to_food-ingredient_id',
            'ingredients_to_food',
            'ingredient_id',
            'ingredients',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-ingredients_to_food-food_id',
            'ingredients_to_food'
        );
        $this->dropForeignKey(
            'fk-ingredients_to_food-ingredient_id',
            'ingredients_to_food'
        );
        $this->dropTable('{{%ingredients_to_food}}');
    }
}
