<?php

/* 
 * VereinsmeldungVerein
 * @param $vereinsmeldung
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

use app\assets\IconsAsset;
IconsAsset::register($this);

?>

    <article id="vereinsmeldung-teams">
        <h2>Mannschaften melden</h2>
        <div>
            <div class="">
                <div>
                    Verein:
                    <div class="fw-bold"><?= $vereinsmeldung->verein->name ?></div>
                </div>
            </div>
            <hr/>
            <div class="fw-bold">Mannschaften deines Vereins</div>
            <ul class="list-group link-group" id="contactlist">
                <li class="list-group-item list-group-item-secondary list-group-item-action border border-1 border-secondary p-1 my-1 mx-0">
                    <div class="card-body p-2">
                        <h5 class="card-title vereinsrolle mb-0 fw-bold fs-5" id="item-new">
                            Mannschaft hinzufügen
                        </h5>
                        <a href="<?= Url::toRoute(['vereinsmeldungadmin/add-team-altersbereich','p'=>$vereinsmeldung->id]) ?>" class="stretched-link" id="item-new-link"></a>
                    </div>
                </li>
                <?= $this->render('_teams_items',['items'=> $teams, 'vereinsmeldung'=>$vereinsmeldung]) ?>
            </ul>
            
        </div>
        
        <br/>
        
        <div class="d-flex justify-content-between p-1">
            <div class="d-flex justify-content-between p-1">
                <div class="form-group">
                    <a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung-verein','p'=>$vereinsmeldung->id]) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
                </div>
            </div>
            <?php if(count($teams)==0){ ?>
            <div>
                <a href="<?= Url::toRoute(['vereinsmeldungadmin/no-teams','p'=>$vereinsmeldung->id]) ?>" class="btn btn-danger" id="finish-with-empty-teams">Ohne Mannschaft abschließen</a>
            </div>
            <?php } ?>
        </div>

        
    </article>


