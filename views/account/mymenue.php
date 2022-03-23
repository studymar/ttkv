<?php

use yii\helpers\Url;

/* 
 * Home im eingeloggten Bereich
 */
?>
    <div>
        <ul class="list">
            <li><a href="<?= Url::toRoute(['account/mydata']) ?>">Meine Daten</a></li>
            <li><a href="<?= Url::toRoute(['account/logout']) ?>">Logout</a></li>
        </ul>
    </div>

