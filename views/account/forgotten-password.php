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
            
                <br/>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <?= $form->field($model, 'email')->label(false) ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary" id="pw-forgotten-submit">Passwort vergessen</button>
                </div>

                <br/>
                <div class="form-group">
                    <p class="text-muted">
                        <a href="<?= Url::toRoute(['account/index']) ?>" class="grey">Zurück zum Login</a>
                    </p>
                </div>
                
            </form>   
            <?php ActiveForm::end() ?>
        </div>

