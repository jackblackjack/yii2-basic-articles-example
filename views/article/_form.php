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
    'id' => 'article-edit-container',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'formSelector' => 'article-edit-form',
    'timeout' => \Yii::$app->params['pjax.timeout.default']
]); ?>

<div class="article-form">

    <?php $form = ActiveForm::begin([
        'id' => 'article-edit-form',
        'action' => ($model->isNewRecord ? Url::toRoute([ 'article/create' ]) : Url::toRoute([ 'article/update', 'id' => $model->id ])),
        'enableClientValidation' => true,
        'options' => [ 'data-pjax' => true ]
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <?php Pjax::begin(['id' => 'active-toggle', 'timeout' => \Yii::$app->params['pjax.timeout.default']]) ?>
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
                'data-method' => 'post'
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end() ?>