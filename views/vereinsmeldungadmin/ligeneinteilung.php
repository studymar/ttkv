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
                    <div class="fw-bold"><?= $season->name ?> <?= $altersbereich->name ?></div>
                </div>
            </div>
            <hr/>
        </div>
        
        <?php foreach($ligeneinteilung as $liga=>$teams){ ?>
        <div class="<?= (!count($teams))?"text-muted":""?>">
            <h5 class="fs-4 "><?= $liga ?></h5>
            <?php if(!count($teams)){?>
            <div>Keine Meldung</div>
            <?php } else { ?>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <td>Nr</td>
                        <td>Verein</td>
                        <td>Heimtage</td>
                        <td>Wunschwochen</td>
                        <td>Pokal</td>
                        <td>Regio Wunsch</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach($teams as $team){ ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $team->vereinsmeldungTeams->vereinsmeldung->verein->name ?> <?= $team->number ?></td>
                        <td><?= $team->heimspieltage ?></td>
                        <td><?= $team->weeks ?></td>
                        <td><?= ($team->pokalteilnahme)?'Ja':'Nein' ?></td>
                        <td><?= $team->regional ?></td>
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
        
        
        <br/><br/>
        <div class="d-flex justify-content-between p-1">
            <div class="form-group">
                <a href="<?= Url::toRoute(['vereinsmeldungadmin/vereinsmeldung']) ?>" class="btn btn-primary">Zurück zur Übersicht</a>
            </div>
            <div>
                <a href="<?= Url::toRoute(['vereinsmeldungadmin/ligeneinteilung-export','p'=>$team->altersklasse->altersbereich_id]) ?>" class="btn btn-light">Export Excel</a>
            </div>
        </div>
        
    </article>

