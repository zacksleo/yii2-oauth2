<?php

use yii\helpers\Html;
use zacksleo\yii2\oauth2\backend\Module;

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\oauth2\common\models\OauthClients */

$this->title = Module::t('core', 'Update') . $model->client_name;
$this->params['breadcrumbs'][] = ['label' => Module::t('core', 'Apps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_name, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = Module::t('core', 'Update');
?>
<div class="app-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
