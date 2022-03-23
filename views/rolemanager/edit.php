<?php

/* 
 * Rolemanager Edit
 * @param UserEditForm $model
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

?>

    <article>
        <!-- User Edit -->
        <h2>Rolle Editieren</h2>
        <div>
            <?php $form = ActiveForm::begin(FormHelper::getConfigArray());?>
                <?= $form->field($model, 'id')->label(false)->hiddenInput(['id'=>$model->id]) ?>
                <div>
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <div><?= $role->id ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="roleeditform-name" class="form-label">Name</label>
                        <?= $form->field($model, 'name')->label(false) ?>
                    </div>
                    
                    <?php /* foreach($rightgroups as $group){ ?>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold"><?= $group->name ?></label>
                        <?php foreach($group->rights as $right){ ?>
                        <div class="form-check form-switch">
                            <label>
                            <?= Html::checkbox('RoleEditForm[rights]', \yii\helpers\ArrayHelper::isIn($right->id, $rights), ['class'=>'form-check-input','role'=>'switch']); ?>
                            <?= $right->name ?>    
                            </label>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } */ ?>
                    <?= FormHelper::renderListOfSwitchesWithGroupNames($rightgroups, 'name', 'rights', 'name', $rights, 'RoleEditForm[rights][]') ?>
                    <br/>

                    <div class="form-group">
                        <a href="<?= Url::toRoute(['rolemanager/index']) ?>" class="btn btn-outline-secondary">Abbrechen</a>
                        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>

                <br/>
                
            <?php ActiveForm::end(); ?>
        </div>
                
    </article>

