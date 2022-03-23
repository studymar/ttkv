<?php

/* 
 * Anmelden / Registrieren 1
 * @param RegistrationForm $model
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article>
        <!-- Login -->
        <h2>Anmeldung zur Vereinsmeldung</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <?= $form->field($model, 'step')->label(false)->hiddenInput(['value'=>'step2']) ?>
                <br/>
                <!-- Anmelden Schritt 1 -->
                <div>
                    <div class="mb-3">
                        <ul class="list-group list-group-horizontal list-group-numbered">
                            <li class="list-group-item flex-fill list-group-item-secondary">Zugangsdaten</li>
                            <li class="list-group-item flex-fill">Verein auswählen</li>
                            <li class="list-group-item flex-fill">Bestätigen</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Vorname</label>
                        <?= $form->field($model, 'firstname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nachname</label>
                        <?= $form->field($model, 'lastname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Deine Email</label>
                        <?= $form->field($model, 'email')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Passwort auswählen</label>
                        <?= $form->field($model, 'password')->label(false)->passwordInput() ?>
                    </div>
                    <div class="mb-3">
                        <label for="password_repeat" class="form-label">Passwort wiederholen</label>
                        <?= $form->field($model, 'password_repeat')->label(false)->passwordInput() ?>
                    </div>

                    <div class="form-group">
                        <a href="<?= Url::toRoute(['account/index']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Weiter', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <br/>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

