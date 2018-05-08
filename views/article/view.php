<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <p>
    <?php if (\Yii::$app->user->can('editor') || \Yii::$app->user->can('articleManager')): ?> 
        <?= Html::a(Yii::t('app', 'Set active'), ['status', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    <?php endif ?>
    </p>

    <h2><?php echo Html::encode($model->title) ?></h2>
    <p>
        <?php if (\Yii::$app->user->isGuest): ?>
            <?php echo $model->full_data ?>
        <?php else:  ?>
            <?php echo $model->preview_data ?>
        <?php endif ?>
    </p>
    <hr />
    <p>
        <dl>
            <dt><?php echo Yii::t('app', 'Created at') ?></dt>
            <dd><?php echo \Yii::$app->formatter->asDatetime($model->created_at, 'long'); ?></dd>
        </dl>
    </p>
</div>
