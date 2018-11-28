<?php

use yii\helpers\Html;
use yii\grid\GridView;
use zacksleo\yii2\oauth2\backend\Module;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('core', 'Apps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-index">
    <p><?= Html::a('创建应用', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'client_name',
            'client_id',
            'client_secret',
            'grant_types',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
