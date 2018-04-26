<?php

use yii\helpers\{ Html, Url };
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin([
    'id' => 'user-create',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'formSelector' => 'user-create'
]); ?> 

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id' => 'user-create',
        'action' => Url::toRoute([ 'user/create' ]),
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
        <?= Html::submitButton(Yii::t('app', 'Save'), [ 
                                    'class' => 'btn btn-success', 
                                    'data-method' => 'post', 
                                    'data-pjax' => 'true' 
                                ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end() ?>
<?php $this->registerJs("
$(document).on('submit', 'form[data-pjax]', function(event) {
    $.pjax.submit(event, '#user-create')
})"); ?>