<?php

use app\models\vereinsmeldung\vereinskontakte\VereinsmeldungKontakte;
/* 
 * Vereinskontakte: uebersicht
 * @param Season $season
 * @param Vereinsmeldung[] $vereinsmeldungen
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;


?>

    <article id="vereinskontakte">
        <h2>Vereinskontakte Saison <?= $season->name ?></h2>
        <div>
            <div class="fw-bold">Kreisvorstand</div>
            <hr>

            <div class="fw-bold">Kreisjugendausschuss</div>
            <hr>

            <div class="fw-bold">Vereine</div>
            <ul class="list-group link-group" id="contactlist">
                <?php $x=1; foreach($vereinsmeldungen as $vm){ $vereinsmeldungKontakte = VereinsmeldungKontakte::findByVereinsmeldung($vm);  ?>
                <li class="list-group-item p-1 px-0 m-1 mx-0 border-0">
                    <div class="fw-bold text-decoration-underline"><?= $x++ ?>. <?= $vm->verein->name ?></div>
                    <ul class="list-group link-group my-1 <?= ($vereinsmeldungKontakte && count($vereinsmeldungKontakte->vereinskontakte)>1)?"first-item-without-border-bottom":"" ?> ">
                    <?= $this->render('_uebersicht_contactitem',['items'=> ($vereinsmeldungKontakte)?$vereinsmeldungKontakte->vereinskontakte :[] ]) ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>

            
        </div>
        
        <br/>
        
        <div class="d-flex justify-content-between p-1">
            <div class="form-group">
                <a href="<?= Url::toRoute(['account/home']) ?>" class="btn btn-primary">Zurück</a>
            </div>
        </div>

        
    </article>


