<?php
/* 
 * Vereinsmeldungadmin Ligeneinteilung
 * @param $season
 * @param $ligeneinteilung
 */

use yii\helpers\Url;

?>


    <article>
        <!-- Vereinsmeldung Übersicht -->
        <h2>Vereinsmeldung</h2>
        <div>
            <div class="" id="intro">
                <div>
                    Vereinsmeldung:
                    <div class="fw-bold"><?= $season->name ?> Altersbereich: <?= $altersbereich->name ?></div>
                </div>
            </div>
            <hr/>
        </div>
        
        <?php foreach($ligeneinteilung as $altersklasse=>$ligen){ ?>
        <div class="fs-4 mb-2">Altersklasse: <?= $altersklasse ?></div>
        <?php foreach($ligen as $liga=>$teams){ ?>
        <div class="<?= (!count($teams))?"text-muted":""?>">
            <h5 class="fs-4 "><?= $liga ?></h5>
            <?php if(!count($teams)){?>
            <div class="mb-4">Keine Meldung</div>
            <?php } else { ?>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <td>Nr</td>
                        <td>Verein</td>
                        <td>Heimtage</td>
                        <?php if($teams[0]->altersklasse->altersbereich->askweeks){ ?><td>Wunschwochen</td><?php } ?>
                        <?php if($teams[0]->liga->askregional){ ?><td>Regio Wunsch</td><?php } ?>
                        <td>Pokal</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($teams as $team){ $regional = app\models\vereinsmeldung\teams\Liga::$regional; ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $team->vereinsmeldungTeams->vereinsmeldung->verein->name ?> <?= $team->number ?></td>
                        <td><?= $team->heimspieltage ?></td>
                        <?php if($team->altersklasse->altersbereich->askweeks){ ?><td><?= $team->getWeeksName() ?></td><?php } ?>
                        <?php if($team->liga->askregional){ ?><td><?= ($team->regional)? $regional[$team->regional] : '' ?></td><?php } ?>
                        <td><?= ($team->pokalteilnahme)?'Ja':'Nein' ?></td>
                    </tr>
                    <?php } ?>
                    <?php if(!count($teams)){ ?>
                    <tr>
                        <td colspan="6">Keine Meldung</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
        <?php } ?>
        <hr/>
        <?php } ?>
        
        
        <br/><br/>
        <div class="d-flex justify-content-between p-1">
            <div class="form-group">
                <a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung']) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
            </div>
            <div>
                <a href="<?= Url::toRoute(['vereinsmeldungadmin/ligeneinteilung-excel-export','p'=>$altersbereich->id]) ?>" class="btn btn-light">Export Excel</a>
            </div>
        </div>
        
    </article>

