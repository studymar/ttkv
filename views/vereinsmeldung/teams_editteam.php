<?php

/* 
 * VereinsmeldungTeams
 * @param TeamEditForm $model
 * @param VereinsmeldungTeams $vereinsmeldungTeams
 * @param Altersbereich[] $altersbereich
 * @param Alterklasse[] $altersklassen
 * 
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article id="team-edit">
        <!-- Team Edit -->
        <h2>Mannschaft editieren</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <br/>
                <div id="persondata">
                    <div class="form-group required">
                        <label for="teameditform-altersklasse_id" class="form-label">Altersbereich</label>
                        <div class="alert alert-light border b-1">
                            <div class="">
                                <?= $altersbereich->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="teameditform-altersklasse_id" class="form-label">Altersklasse*</label>
                        <?= $form->field($model, 'altersklasse_id')->label(false)->dropDownList($altersklassen,['prompt'=>'Bitte auswählen']) ?>
                    </div>
                    <div class="mb-3">
                        <label for="teameditform-liga_id" class="form-label">Liga*</label>
                        <?= $form->field($model, 'liga_id')->label(false)->dropDownList($ligen,['prompt'=>'Bitte auswählen']) ?>
                    </div>
                    <div class="mb-3">
                        <label for="teameditform-regional" class="form-label">Regionaler Wunsch</label>
                        <?= $form->field($model, 'regional')->label(false)->dropDownList($regional) ?>
                    </div>
                    <div class="mb-3">
                        <label for="teameditform-heimspieltage" class="form-label">Heimspieltage, Beispiel: Mo(20:00), Fr(20:15)</label>
                        <?= $form->field($model, 'heimspieltage')->label(false) ?>
                    </div>
                    <?php if($altersbereich->askweeks){ ?>
                    <div class="mb-3">
                        <label for="teameditform-weeks" class="form-label">Heimspielwunschwochen</label>
                        <?= $form->field($model, 'weeks')->label(false)->dropDownList(app\models\vereinsmeldung\teams\Team::getWeeksOptions()) ?>
                    </div>
                    <?php } ?>
                    <?php if($altersbereich->askpokal){ ?>
                    <div class="mb-3">
                        <label for="teameditform-pokalteilnahme" class="form-label">Pokalteilnahme</label>
                        <?= $form->field($model, 'pokalteilnahme')->label(false)->dropDownList([1=>'Ja',0=>'Nein']) ?>
                    </div>
                    <?php } ?>
                    <br/>

                </div>
                <br/>
                <div class="mb-3">
                    <div class="alert-info">
                        Jede Mannschaft muss ergänzend auch in Click-tt gemeldet werden. Die Meldung auf der Kreisseite
                        ist verpflichtend und schafft für die Verantwortlichen benötigte, ergänzende Informationen.
                    </div>
                </div>
                
                <div class="d-flex justify-content-between p-1">
                    <div class="form-group">
                        <a href="<?= Url::toRoute(['vereinsmeldung/teams','p'=>$vereinsmeldungTeams->vereinsmeldung_id]) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div>
                        <a href="<?= Url::toRoute(['vereinsmeldung/delete-team','p'=>$team->id]) ?>" class="btn btn-danger">Löschen</a>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

