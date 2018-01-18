<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Apps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-puzzle font-grey-gallery"></i>
            <span class="caption-subject bold font-grey-gallery uppercase"> <?= $this->title; ?> </span>
        </div>
        <div class="actions">

            <div class="btn-group btn-group-devided">
                <?= Html::a('创建应用', ['create'], ['class' => 'btn grey-salsa btn-sm active']) ?>
            </div>
        </div>
    </div>
    <div class="portlet-body">

        <?php Pjax::begin(); ?>
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
        <?php Pjax::end(); ?>
    </div>
</div>
