<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @param User $user User, der die Mail erhält */

$text = "
        <p>Du hast das Passwort-vergessen-Formular auf ttkv-harburg.de das ausgefüllt.
        Auf dem folgenden Link kannst du ein neues Passwort für deinen Account setzen:
        <br/>".
        \yii\bootstrap4\Html::a("Passwort neu setzen", Url::to(['account/reset-password','p'=>$user->passwordforgottentoken],true))
        ."<br/><br/>
        Ihr TTKV Harburg-Land e.V.<br/>
        ttkv-harburg.de
        </p>
";

?>

        <?= $this->render('partials/_text-ohne-bild', [
            'text' => $text,
            'headline' => "Ihr Passwort auf ttkv-harburg.de",
        ]) ?>




