<?php

use yii\helpers\Url;
use app\models\user\Right;

/* 
 * Home im eingeloggten Bereich
 * @param User $user
 * @param Rightgroup[] $rightgroups
 */
?>
    
    <?php foreach($rightgroups as $rightgroup){ $rights = $user->role->getRightsOfRightsgroup($rightgroup->id);if(!count($rights))continue; ?>
    <div class="my-4" id="rightgroup<?= $rightgroup->id ?>">
        <div class="my-0">
            <div class="my-0 py-3 px-4 fw-bold listheadline"><?= $rightgroup->name ?>:</div>
        </div>
        <ul class="list my-0 py-0" id="account-home-list">
            <?php foreach($rights as $right){ if($user->role->hasRight($right->id)){ ?>
            <?php //foreach($rightgroup->rights as $right){ if($user->role->hasRight($right->id)){ ?>
            <li><a href="<?= Url::to([$right->route]) ?>"><?= $right->name ?></a></li>
            <?php }} ?>
        </ul>
    </div>
    <?php } ?>

