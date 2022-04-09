<?php

/* 
 * Vereinsmeldungadmin: vereinskontakte
 * @param $vereinsmeldung
 * @param $vereinsmeldungKontakte
 * @param $season
 * @param $user
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

use app\assets\IconsAsset;
IconsAsset::register($this);

?>

    <article id="vereinskontakte">
        <h2>Vereinskontakte pflegen</h2>
        <div>
            <div class="">
                <div>
                    Verein:
                    <div class="fw-bold"><?= $vereinsmeldung->verein->name ?></div>
                </div>
            </div>
            <hr/>
            <div class="fw-bold">Kontaktdaten deines Vereins</div>
            <ul class="list-group link-group" id="contactlist">
                <?= $this->render('_contact_items',['items'=> $vereinsmeldungKontakte->vereinskontakte]) ?>

            </ul>

            <hr/>
            <div class="fw-bold">Angelegte Personen</div>
            <ul class="list-group link-group" id="contactlist">
                <li class="list-group-item list-group-item-action list-group-item-secondary bg-opacity-10 border border-1 border-secondary p-1 m-1">
                    <div class="card-body p-2 contact">
                        <h5 class="card-title vereinsrolle mb-0 fw-bold fs-5" id="item-new">
                            Neue Person ergänzen
                        </h5>
                        <a href="<?= Url::toRoute(['vereinsmeldungadmin/add-person','p'=>$vereinsmeldung->id]) ?>" class="stretched-link" id="item-new-link"></a>
                    </div>
                </li>
                <?= $this->render('_contact_persons',['items'=> $vereinsmeldungKontakte->persons]) ?>

            </ul>

            
        </div>
        
        <br/>
        
        <div class="d-flex justify-content-between p-1">
            <div class="form-group">
                <a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung-verein','p'=>$vereinsmeldung->id]) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
            </div>
        </div>

        
    </article>


