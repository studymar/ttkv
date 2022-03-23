<?php
use yii\helpers\Url;

/* @var User $user User, der die Mail erhält */

?>
        Passwort vergessen auf ttkv-harburg.de

        Du hast das Passwort-vergessen-Formular auf ttkv-harburg.de das ausgefüllt.
        Auf dem folgenden Link kannst du ein neues Passwort für deinen Account setzen:
        
        <?= Url::to(['account/reset-password','p'=>$user->passwordforgottentoken],true) ?>

        Ihr TTKV Harburg-Land e.V.
        ttkv-harburg.de
        