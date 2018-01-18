<?php

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\oauth2\common\models\OauthClients */

$this->title = Yii::t('app', 'Create App');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>