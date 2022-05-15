<?php

/* 
 * MyData
 * @param MyDataForm $model
 * @param User $user
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article id="account-mydata">
        <!-- User Edit -->
        <h2>Meine Daten</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <div>
                    <div class="mb-3">
                        <label class="form-label">Verein</label>
                        <div id="user-verein-<?= $user->vereins_id ?>"><?= $user->verein->name ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="mydata-firstname" class="form-label">Vorname</label>
                        <?= $form->field($model, 'firstname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="mydata-lastname" class="form-label">Nachname</label>
                        <?= $form->field($model, 'lastname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="mydata-email" class="form-label">Email</label>
                        <?= $form->field($model, 'email')->label(false) ?>
                    </div>
                    <br/>

                    <div class="form-group">
                        <a href="<?= Url::toRoute(['account/home']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary','id'=>'mydata-submit-btn']) ?>
                    </div>
                </div>
                <br>
                <hr/>
                <br>
                <br>
                <div>
                    <h4>Passwort ändern</h4>
                    <div class="mb-3">
                        <label for="password" class="form-label">Passwort auswählen</label>
                        <?= $form->field($modelPW, 'password')->label(false)->passwordInput() ?>
                    </div>
                    <div class="mb-3">
                        <label for="password_repeat" class="form-label">Passwort wiederholen</label>
                        <?= $form->field($modelPW, 'password_repeat')->label(false)->passwordInput() ?>
                    </div>
                    
                    <div class="form-group">
                        <a href="<?= Url::toRoute(['account/home']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary','id'=>'changepassword-submit-btn']) ?>
                    </div>
                    
                </div>

                <br/>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

