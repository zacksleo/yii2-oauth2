<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\oauth2\common\models\OauthClients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'grant_types')->dropDownList([
        'client_credentials' => 'client_credentials',
        'authorization_code' => 'authorization_code',
        'password' => 'password',
        'implicit' => 'implicit',
        "refresh_token" => 'refresh_token'
    ], [
        'multiple' => 'true'
    ]); ?>
    <?= $form->field($model, 'one_token_per_user')->checkbox(); ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
