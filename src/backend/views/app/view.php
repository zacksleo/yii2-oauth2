<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use zacksleo\yii2\oauth2\backend\Module;

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\oauth2\common\models\OauthClients */

$this->title = $model->client_name;
$this->params['breadcrumbs'][] = ['label' => Module::t('core', 'Apps'), 'url' => ['index']];
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
        <?= Html::a(Module::t('core', 'Update'), ['update', 'id' => $model->client_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Module::t('core', 'Delete'), ['delete', 'id' => $model->client_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('core', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
