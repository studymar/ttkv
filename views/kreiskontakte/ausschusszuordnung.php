<?php

/* 
 * kreiskontakte: ausschusszuordnung
 * @param Funktionsgruppe[] $funktionsgruppen Funktionsgruppe 
 * @param Vereinsrolle[] $vereinsrollen
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

use app\assets\IconsAsset;
IconsAsset::register($this);

?>

    <article id="kreiskontakte">
        <h2>Kreisausschüsse</h2>
        <div>
            <ul class="list-group link-group" id="contactlist">
                <?php foreach($funktionsgruppen as $item){ ?>
                <li class="list-group-item p-1 px-0 m-1 mx-0 border-0">
                    <h5 class="card-title mb-0 fw-bold" id="item-<?= $item->id ?>">
                        <?= $item->name ?>
                    </h5>
                    <ul class="list-group link-group" id="contactlist">
                        <?= $this->render('_ausschusszuordnung_item',['items'=> $item->vereinsrollenImAusschuss]) ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>

            <hr/>
            <div class="fw-bold">Rollen zuordnen</div>
            <ul class="list-group link-group" id="contactlist">
                <?= $this->render('_ausschusszuordnung_rolle',['items'=> $vereinsrollen]) ?>

            </ul>

            
        </div>
        
        <br/>
        
        <div class="d-flex justify-content-between p-1">
            <div class="form-group">
                <a href="<?= Url::toRoute(['account/home']) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
            </div>
        </div>

        
    </article>


