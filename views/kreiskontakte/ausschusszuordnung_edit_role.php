<?php

/* 
 * Kreiskontakte ausschusszuordnung_edit_role
 * @param AusschussRoleEditForm $model
 * @param Vereinsrolle[] $vereinsrollen
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article id="person-edit">
        <h2>Ausschüsse zur Rolle zuordnen</h2>
        <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
            <?= $form->field($model, 'id')->label(false)->hiddenInput(['id'=>$model->id]) ?>
            <div id="persondata">
                    <div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Rolle:</label>
                            <?= $vereinsrolle->name ?>
                        </div>
                    </div>
                    <br/>
            </div>
            <br/>
            <div id="vereinsrolle">
                <h3>Ausschüsse auswählen:</h3>
                <br/>
                <div class="list-group" id="form-select">
                    <?= $form->field($model, 'funktionsgruppen_ids')
                        ->label(false)
                        ->checkboxList($funktionsgruppen, FormHelper::getCheckboxListAsSelectableLine('Speichern'))
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

            <div class="d-flex justify-content-between p-1">
                <div class="form-group">
                    <a href="<?= Url::toRoute(['kreiskontakte/ausschusszuordnung']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                </div>
                <div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
                
    </article>

