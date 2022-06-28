<?php

/* 
 * VereinsmeldungKontakte addPerson
 * @param Verein $verein
 * @param PersonEditForm $model
 * @param Vereinsrolle[] $vereinsrollen
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article id="user-new">
        <!-- User Edit -->
        <h2>Person anlegen</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <?= $form->field($model, 'id')->label(false)->hiddenInput(['id'=>$model->id]) ?>
                <br/>
                <div id="persondata">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Vorname*</label>
                        <?= $form->field($model, 'firstname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nachname*</label>
                        <?= $form->field($model, 'lastname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="street" class="form-label">Straße + Hnr.</label>
                        <?= $form->field($model, 'street')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="zip" class="form-label">PLZ</label>
                        <?= $form->field($model, 'zip')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Ort</label>
                        <?= $form->field($model, 'city')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <?= $form->field($model, 'email')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefon</label>
                        <?= $form->field($model, 'phone')->label(false) ?>
                    </div>
                    <br/>

                </div>
                <br/>
                <div id="vereinsrolle">
                    <h3>Rollen der Person auswählen:</h3>
                    <br/>
                    <div class="list-group" id="form-select">
                        <?= $form->field($model, 'vereinsrollen_ids')
                            ->label(false)
                            ->checkboxList($vereinsrollen, FormHelper::getCheckboxListAsSelectableLine('Speichern'))
                        ?>
                    </div>
                </div>
                <br/>
                <div class="mb-3">
                    <div class="alert-info">
                        Mit Eintragen der Daten erkläre ich mich einverstanden, dass diese im 
                        Anschriftenverzeichnis des Tischtennis Kreisverbandes für alle Verantwortlichen der
                        Vereine und des Kreisvorstands als Kontaktmöglichkeit angezeigt werden dürfen.
                        Die Daten werden nicht im öffentlichen Bereich der Seite (ohne Login) angezeigt.
                    </div>
                </div>
                
                <div class="form-group">
                    <a href="<?= Url::toRoute(['kreiskontakte/index']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                </div>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

