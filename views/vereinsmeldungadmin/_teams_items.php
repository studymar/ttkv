<?php
/**
 * @param Vereinsmeldung TeamsItems $items 
 */

use yii\helpers\Url;

/* 
 * Item
 */
$i = 0;
$altersbereich = "";
foreach($items as $item){
    $i++;
    if($altersbereich != $item->altersklasse->altersbereich){
        $altersbereich = $item->altersklasse->altersbereich;
        $i = 1;
    }
?>

                <li class="list-group-item list-group-item-action border border-1 border-secondary my-1 mx-0 p-0">
                    <div class="card-body p-2 contact" id="item-<?= $i ?>">
                        <h5 class="card-title mb-0 fw-bold">
                            <?= $i ?>.<?= $item->altersklasse->altersbereich->name ?>(<?= $item->altersklasse->name ?>), <?= $item->liga->name ?>
                        </h5>
                        <div>
                            <div class="team">
                                <div class="heimspiele">Heimspiele: <?= $item->heimspieltage ?></div>
                                <?php if($item->altersklasse->altersbereich->askweeks){ ?>
                                <div class="Wochen">Heimspielwochen: <?= $item->getWeeksName() ?></div>
                                <?php } ?>
                                <?php if($item->altersklasse->altersbereich->askpokal){ ?>
                                <div class="Pokal">Pokalteilnahme: <?= ($item->pokalteilnahme)?'Ja':'Nein' ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <a href="<?= Url::toRoute(['vereinsmeldungadmin/edit-team','p'=>$vereinsmeldung->id, 'p2'=>$item->id]) ?>" class="stretched-link"></a>
                    </div>
                </li>

<?php } 

if(count($items) == 0){ ?>
    <div id="no-teams">
        Noch keine Mannschaften eingetragen <br/>
    </div>
<?php }
?>
