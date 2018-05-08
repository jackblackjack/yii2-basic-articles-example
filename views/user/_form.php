<?php

use yii\helpers\{ Html, Url };
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin([
    'id' => 'user-edit-container',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'formSelector' => 'user-edit-form',
    'timeout' => \Yii::$app->params['pjax.timeout.default']
]); ?> 

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id' => 'user-edit-form',
        'action' => ($model->isNewRecord ? Url::toRoute([ 'user/create' ]) : Url::toRoute([ 'user/update', 'id' => $model->id ])),
        'enableClientValidation' => true,
        'options' => [ 'data-pjax' => true ]
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'username')->textInput([ 
                                            'maxlength' => true, 
                                            'autocomplete' => 'off',
                                            'placeholder' => 'username'
                                            ]) ?>

    <?= $form->field($model, 'email')->textInput([ 
                                            'maxlength' => true, 
                                            'autocomplete' => 'off',
                                            'placeholder' => 'email@email.com'
                                            ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', ($model->isNewRecord ? 'Save' : 'Update')), [ 
                                    'class' => 'btn btn-success', 
                                    'data-method' => 'post'
                                ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php Pjax::end() ?>
