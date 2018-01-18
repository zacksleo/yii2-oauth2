<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\oauth2\common\models\OauthClients */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'App',
    ]) . $model->client_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_name, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="app-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
