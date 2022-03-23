<?php

/* 
 * Vereinsmeldungadmin: index
 * @param $seasons
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
        <h2>Vereinsmeldung Einrichten für Saison:</h2>
        <div>
            <ul class="list-group link-group" id="vereinsmeldungadmin-uebersicht">
                <li class="list-group-item list-group-item-action border border-1 border-secondary p-1 m-1">
                    <div class="card-body">
                        <h5 class="card-title" id="item-new">
                            Neue Saison anlegen
                        </h5>
                            <a href="<?= Url::toRoute(['vereinsmeldungadmin/create-season']) ?>" class="stretched-link"></a>
                    </div>
                </li>

                <?= $this->render('_index_items',['items'=>$seasons]) ?>
            </ul>
        </div>
    </article>



