<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\oauth2\common\models\OauthClients */

$this->title = $model->client_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'client_name',
            'client_id',
            'client_secret',
            'grant_types',
            'user_id',
            'one_token_per_user:boolean'
        ],
    ]) ?>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->client_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->client_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
