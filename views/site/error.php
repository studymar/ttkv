<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<article>
<div class="site-error">

    <h2>Oops...es ist etwas schief gegangen!</h2>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>


</div>
</article>

    