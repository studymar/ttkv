<?php

/* 
 * Vereinsmeldungadmin: createSeason
 * @param $season
 * @param $modules
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

use app\assets\IconsAsset;
IconsAsset::register($this);

?>

    <article>
        <h2>Neue Saison</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <div id="seasonedit-form">
                    <div class="mb-3">
                        <label for="seasoneditform-name" class="form-label">Saison</label>
                        <?= $form->field($model, 'name')->label(false) ?>
                    </div>

                    <?= FormHelper::renderListOfSwitches($allModules, 'name', $model->checked_ids, 'SeasonEditForm[checked_ids][]') ?>
                    <br/>

                    <div class="form-group">
                        <a href="<?= Url::toRoute(['vereinsmeldungadmin/index']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </article>



