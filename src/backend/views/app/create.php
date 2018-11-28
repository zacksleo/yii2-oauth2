<?php

use zacksleo\yii2\oauth2\backend\Module;

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\oauth2\common\models\OauthClients */

$this->title = Module::t('core', 'Create App');
$this->params['breadcrumbs'][] = ['label' => Module::t('core', 'Apps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>