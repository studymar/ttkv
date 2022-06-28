<?php

/* 
 * kreiskontakte: index
 * @param Funktionsgruppe[] $funktionsgruppen Funktionsgruppe 
 * @param Person[] $persons[] Personen
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

use app\assets\IconsAsset;
IconsAsset::register($this);

?>

    <article id="kreiskontakte">
        <h2>Kreiskontakte pflegen</h2>
        <div>
            <ul class="list-group link-group" id="contactlist">
                <?php foreach($funktionsgruppen as $item){ ?>
                <li class="list-group-item p-1 px-0 m-1 mx-0 border-0">
                    <h5 class="card-title mb-0 fw-bold" id="item-<?= $item->id ?>">
                        <?= $item->name ?>
                    </h5>
                    <ul class="list-group link-group" id="contactlist">
                        <?= $this->render('_index_contact_item',['items'=> $item->vereinsrollenImAusschuss]) ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>

            <hr/>
            <div class="fw-bold">Angelegte Personen</div>
            <ul class="list-group link-group" id="contactlist">
                <li class="list-group-item list-group-item-action list-group-item-secondary bg-opacity-10 border border-1 border-secondary p-1 px-0 m-1 mx-0">
                    <div class="card-body p-2 contact">
                        <h5 class="card-title vereinsrolle mb-0 fw-bold fs-5" id="item-new">
                            Neue Person ergänzen
                        </h5>
                        <a href="<?= Url::toRoute(['kreiskontakte/add-person','p'=>$item->id]) ?>" class="stretched-link" id="item-new-link"></a>
                    </div>
                </li>
                <?= $this->render('_index_contact_person',['items'=> $persons]) ?>

            </ul>

            
        </div>
        
        <br/>
        
        <div class="d-flex justify-content-between p-1">
            <div class="form-group">
                <a href="<?= Url::toRoute(['account/home']) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
            </div>
        </div>

        
    </article>


