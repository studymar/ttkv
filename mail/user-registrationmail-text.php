<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $user User User, der die Mail erhält */
$validationlink = Yii::$app->params['domain']."/account/anmeldung-abschliessen/".$user->validationtoken;
?>
        Deine Anmeldung auf ttkv-harburg.de

        Du hast erfolgreich einen Account auf ttkv-harburg.de angemeldet.
        Um die Anmeldung abzuschließen, bestätige bitte hier deine Emailadresse:
        
        <?= $validationlink ?>

        Dein TTKV Harburg-Land e.V.<br/>
        ttkv-harburg.de
