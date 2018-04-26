<?php

use yii\helpers\{ Html, Url };
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<?php Pjax::begin([
    'id' => 'article-create',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'formSelector' => 'article-create'
]); ?>

<div class="article-form">

    <?php $form = ActiveForm::begin([
        'id' => 'article-create',
        'action' => Url::toRoute([ 'article/create' ]),
        'enableClientValidation' => true,
        'options' => [ 'data-pjax' => true ]
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <?php Pjax::begin(['id' => 'active-toggle']) ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
    <?php Pjax::end(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview_data')->widget(Redactor::className()) ?>

    <?= $form->field($model, 'full_data')->widget(Redactor::className()) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Save' : 'Update', 
            [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'data-method' => 'post', 
                'data-pjax' => 'true' 
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end() ?>
<?php $this->registerJs("
$(document).on('submit', 'form[data-pjax]', function(event) {
    $.pjax.submit(event, '#article-create')
})"); ?>