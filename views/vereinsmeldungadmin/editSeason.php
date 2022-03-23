<?php

/* 
 * Vereinsmeldungadmin: editSeason
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
        <!-- Vereinsmeldung Übersicht -->
        <h2>Vereinsmeldung Saison:</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <?= $form->field($model, 'id')->label(false)->hiddenInput(['id'=>$model->id]) ?>
                <div id="seasonedit-form">
                    <div class="mb-3">
                        <label for="seasoneditform-name" class="form-label">Name</label>
                        <?= $form->field($model, 'name')->label(false) ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="seasoneditform-active" class="form-label">Aktive Saison (kann nur eine sein)</label>
                        <?= $form->field($model, 'active')->label(false)->checkbox() ?>
                    </div>

                    <?= FormHelper::renderListOfSwitches($allModules, 'name', $model->checked_ids, 'SeasonEditForm[checked_ids][]') ?>
                    <br/>

                    <div class="d-flex justify-content-between">
                        <div class="form-group">
                            <a href="<?= Url::toRoute(['vereinsmeldungadmin/index']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                            <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <div>
                            <?php if($season->isDeletable()){ ?>
                            <a href="<?= Url::toRoute(['vereinsmeldungadmin/delete-season','p'=>$model->id]) ?>" class="btn btn-danger">Löschen</a>
                            <?php } else { ?>
                            <a class="btn btn-danger" disabled>Löschen</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </article>



