<?php

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* 
 * Anmelden / Registrieren 3
 */

?>

    <article>
        <!-- Login -->
        <h2>Anmeldung zur Vereinsmeldung</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <?= $form->field($model, 'step')->label(false)->hiddenInput(['value'=>'step4']) ?>
                <?= $form->field($model, 'email')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'firstname')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'lastname')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'password')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'password_repeat')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'vereins_id')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'confirm')->label(false)->hiddenInput(['value'=>'1']) ?>
                <br/>

                <!-- Anmelden Schritt 3 -->
                <div>
                    <div class="mb-3">
                        <ul class="list-group list-group-horizontal list-group-numbered">
                            <li class="list-group-item flex-fill">Zugangsdaten</li>
                            <li class="list-group-item flex-fill">Verein auswählen</li>
                            <li class="list-group-item flex-fill list-group-item-secondary">Bestätigen</li>
                        </ul>
                    </div>
                    
                    <div class="d-flex flex-row">
                        <div class="p-2 w-25">Email:</div>
                        <div class="p-2"><?= $model->email ?></div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="p-2 w-25">Vorname:</div>
                        <div class="p-2"><?= $model->firstname ?></div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="p-2 w-25">Nachname:</div>
                        <div class="p-2"><?= $model->lastname ?></div>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="p-2 w-25">Verein:</div>
                        <div class="p-2"><?= $verein->name ?></div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <a href="<?= Url::toRoute(['account/index']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Weiter', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                                
                <br/>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

