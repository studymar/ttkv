<?php

use yii\helpers\Url;

/* 
 * Vereinsmeldung
 * @param $season
 * @param $statistics
 */

use app\assets\TooltipsAsset;
TooltipsAsset::register($this);
use app\assets\IconsAsset;
IconsAsset::register($this);

?>
    <article>
        <!-- Vereinsmeldung Übersicht -->
        <h2>Vereinsmeldung 2022</h2>
        <div>
            <div class="" id="intro">
                <div>
                    Vereinsmeldung:
                    <div class="fw-bold"><?= $season->name ?></div>
                </div>
            </div>
            <hr/>
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">Nr</th>
                    <th>Verein</th>
                    <?php foreach($season->getVereinsmeldemodulHeadlines() as $modKuerzel => $modName){ ?>
                    <th class="col-lg-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $modName ?>"><?= $modKuerzel ?></th>
                    <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php $count = 1; foreach($statistic as $vereinsmeldung){ 
                    $module = $vereinsmeldung->getVereinsmeldemodulInstances();
                    ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung','p'=>$vereinsmeldung->id]); ?>"><?= $vereinsmeldung->verein->name ?></a></td>
                    <?php foreach($module as $modKey => $mod){ 
                        $abgegebenString = ($mod)? "Abgegeben am ". app\models\helpers\DateConverter::convert($mod->donedate)." Uhr" : "Noch nicht abgegeben";
                        ?>
                        <td data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $modKey ?> - <?= $abgegebenString ?>">
                            <?php
                            if($mod && $mod->status()){ ?>
                            <span class="material-icons text-success">done_outline</span>
                            <?php } else { ?>
                            <span class="material-icons text-danger">highlight_off</span>
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                    <th scope="col">42</th>
                    <th>Verein</th>
                    <?php foreach($season->getVereinsmeldemodulHeadlines() as $modKuerzel => $modName){ ?>
                    <th class="col-lg-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $modName ?>"><?= $modKuerzel ?></th>
                    <?php } ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </article>


