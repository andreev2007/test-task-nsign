<?php

use common\models\Ingredients;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<?php /** @var \common\models\Food $model */

echo $form->field($model, 'ingredients')->widget(Select2::classname(), [
    'data' => Ingredients::map(),
    'options' => ['placeholder' => 'Выберите ингредиенты ...', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'tokenSeparators' => [',', ' '],
        'maximumSelectionLength' => 5,
        'minimumSelectionLength' => 2,
    ],
]); ?>


<div class="form-group">
    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
