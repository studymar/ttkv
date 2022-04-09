<?php

/* 
 * VereinsmeldungTeams
 * @param Altersbereich[] $altersbereich
 * 
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article id="team-new-altersbereich">
        <!-- Team Edit -->
        <h2>Mannschaft anlegen</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <br/>
                <div id="persondata">
                    <div class="mb-3">
                        <label for="teameditform-altersbereich_id" class="form-label">Altersbereich*</label>
                        <?= $form->field($model, 'altersbereich_id')
                            ->label(false)
                            ->radioList($altersbereiche, FormHelper::getRadioListAsSelectableLine('Weiter')) ?>
                    </div>

                </div>
                <br/>
                
                <div class="form-group">
                    <a href="<?= Url::toRoute(['vereinsmeldungadmin/teams','p'=>$vereinsmeldungTeams->vereinsmeldung_id]) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                    <?= Html::submitButton('Weiter', ['class' => 'btn btn-primary']) ?>
                </div>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

