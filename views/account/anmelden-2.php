<?php

/* 
 * Anmelden / Registrieren 2
 * @param RegistrationForm $model
 * @param Organisations $organisations
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article>
        <!-- Login -->
        <h2>Anmeldung zur Vereinsmeldung</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <?= $form->field($model, 'step')->label(false)->hiddenInput(['value'=>'step3']) ?>
                <?= $form->field($model, 'email')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'firstname')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'lastname')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'password')->label(false)->hiddenInput() ?>
                <?= $form->field($model, 'password_repeat')->label(false)->hiddenInput() ?>
                <br/>
                <!-- Anmelden Schritt 2 -->
                <?= $form->errorSummary($model,['header'=>false]); ?>
                <div>
                    <div class="mb-3">
                        <ul class="list-group list-group-horizontal list-group-numbered">
                            <li class="list-group-item flex-fill">Zugangsdaten</li>
                            <li class="list-group-item flex-fill list-group-item-secondary">Verein auswählen</li>
                            <li class="list-group-item flex-fill">Bestätigen</li>
                        </ul>
                    </div>
                    
                    <div class="list-group" id="form-select">
                        <?= $form->field($model, 'vereins_id')
                                ->label(false)
                                ->radioList($vereine, FormHelper::getRadioListAsSelectableLine())
                        ?>
                        <!--
                        <div class="card list-group-item flex-fill p-0">
                          <div class="card-body">
                            <h5 class="card-title">Vereinsname</h5>
                            <a href="" class="stretched-link"></a>
                          </div>
                        </div>
                        -->
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

