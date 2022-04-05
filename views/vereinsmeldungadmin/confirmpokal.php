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

    <article id="click-tt">
        <!-- click-tt Edit -->
        <h2>Click-TT Pokalmeldung</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <br/>
                <div id="">
                    <div class="mb-3">
                        <label for="vereinsmeldungpokal-done" class="form-label">Click-tt Pokalmeldung abgegeben?</label>
                        <?= $form->field($model, 'done')->label(false)->dropDownList([1=>'Ja',0=>'Nein']) ?>
                    </div>
                    <br/>

                </div>
                <br/>
                <div class="mb-3">
                    <div class="alert-info">
                        Wenn in deinem Verein keine Mannschaft im Pokal spielen soll, bitte auch bestätigen.
                    </div>
                </div>
                
                <div class="form-group">
                    <a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung-verein','p'=>$model->vereinsmeldung_id]) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                </div>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

