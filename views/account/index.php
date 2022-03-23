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
        <h2>Login</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
            
                <br/>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <?= $form->field($model, 'email')->label(false) ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Passwort</label>
                    <?= $form->field($model, 'password')->label(false)->passwordInput() ?>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">Login</button>
                </div>

                <br/>
                <div class="form-group">
                    <p class="text-muted">
                        <a href="<?= Url::toRoute(['account/forgotten-password']) ?>" class="grey" id="pw-forgotten-link">Passwort vergessen?</a>
                    </p>
                </div>
                <div class="form-group">
                        Erste Anmeldung für die diesjährige Vereinsmeldung?
                    <p class="text-muted">
                        <a href="<?= Url::toRoute(['account/anmelden']) ?>" class="grey" id="anmelde-link">Anmeldung für Vereinsmeldung</a>
                    </p>
                </div>
                
            </form>   
            <?php ActiveForm::end() ?>
        </div>

