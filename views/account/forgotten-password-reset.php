<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\helpers\FormHelper;

/* 
 * Login/Anmelden
 */
?>
    <article>
        <!-- Login -->
        <h2>Passwort vergessen</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
            
                <br>
                <div class="headline">Neues Passwort setzen:</div>
                <br/>
                <div class="mb-3">
                    <label for="password" class="form-label">Passwort auswählen</label>
                    <?= $form->field($model, 'password')->label(false)->passwordInput() ?>
                </div>
                <div class="mb-3">
                    <label for="password_repeat" class="form-label">Passwort wiederholen</label>
                    <?= $form->field($model, 'password_repeat')->label(false)->passwordInput() ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">Passwort vergessen</button>
                </div>

                <br/>
                
            </form>   
            <?php ActiveForm::end() ?>
        </div>

