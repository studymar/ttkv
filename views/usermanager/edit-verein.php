<?php

/* 
 * User Edit Verein
 * @param UserVereinEditForm $model
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article id="editVerein">
        <!-- User Edit -->
        <h2>User Editieren - Verein anpassen</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <div class="list-group" id="form-select">
                    <?= $form->field($model, 'vereins_id')
                        ->label(false)
                        ->radioList($vereine, FormHelper::getRadioListAsSelectableLine())
                    ?>
                </div>

                <div class="form-group">
                    <a href="<?= Url::toRoute(['usermanager/edit',['p'=>$user->id]]) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                </div>

                <br/>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

