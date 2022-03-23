<?php

/* 
 * User Edit
 * @param UserEditForm $model
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article id="user-edit">
        <!-- User Edit -->
        <h2>User Editieren</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <?= $form->field($model, 'id')->label(false)->hiddenInput(['id'=>$model->id]) ?>
                    <div class="mb-3 form-check form-switch">
                        <?= $form->field($model, 'locked')->label(false)->checkbox(['class'=>'form-check-input','role'=>'switch','label'=>'User gesperrt?']) ?>
                        <span class="fst-italic"><?php if($user->lockeddate){ echo "(gesperrt am ". \app\models\helpers\DateConverter::convert($user->lockeddate).")";} ?></span>
                    </div>
                <br/>
                <div>
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <div><?= $user->id ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Verein</label>
                        <div id="user-verein-<?= $user->vereins_id ?>"><?= $user->verein->name ?> (<?= Html::a('ändern', ['usermanager/edit-verein','p'=>$user->id],['id'=>'editVerein-Link']) ?>)</div>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Vorname</label>
                        <?= $form->field($model, 'firstname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nachname</label>
                        <?= $form->field($model, 'lastname')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <?= $form->field($model, 'email')->label(false) ?>
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Rolle</label>
                        <?= $form->field($model, 'role_id')->label(false)->dropDownList($roles) ?>
                    </div>
                    <br/>

                    <div class="form-group">
                        <a href="<?= Url::toRoute(['usermanager/index']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <br/>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

