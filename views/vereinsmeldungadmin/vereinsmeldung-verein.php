<?php

/* 
 * VereinsmeldungVerein
 * @param $modules 
 * @param $season
 * @param $verein 
 * @param Vereinsmeldung $vereinsmeldung
 */

use yii\helpers\Url;
use app\models\helpers\FormHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Html;

use app\assets\IconsAsset;
IconsAsset::register($this);

?>

    <article>
        <!-- Vereinsmeldung Übersicht -->
        <h2>Vereinsmeldung 2022</h2>
        <div>
            <div class="" id="intro">
                <div>
                    Verein:
                    <div class="fw-bold"><?= $verein->name ?></div>
                </div>
            </div>
            <hr/>
            <ul class="list-group link-group" id="vereinsmeldung-uebersicht">

                <?= $this->render('_vereinsmeldung_verein_items',['items'=>$modules, 'season'=>$season, 'verein'=>$verein, 'vereinsmeldung'=> $vereinsmeldung]) ?>

            </ul>
        </div>
        
        <div class="d-flex justify-content-between p-1">
            <div class="d-flex justify-content-between p-1">
                <div class="form-group">
                    <a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung']) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
                </div>
            </div>
        </div>
        
    </article>



