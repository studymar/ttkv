<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $user User User, der die Mail erhält */

$text = "
        <p>Du hast erfolgreich einen Account auf ttkv-harburg.de angemeldet.
        Um die Anmeldung abzuschließen, bestätige bitte hier deine Emailadresse:<br/>
        <br/>
        <a href=\"".Yii::$app->params['domain']."/account/anmeldung-abschliessen/".$user->validationtoken."\">Jetzt bestätigen</a>
        <br/><br/>
        Dein TTKV Harburg-Land e.V.<br/>
        ttkv-harburg.de
        </p>
";

?>

        <?= $this->render('partials/_text-ohne-bild', [
            'text' => $text,
            'headline' => "Deine Anmeldung auf ttkv-harburg.de",
        ]) ?>




