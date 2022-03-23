<?php
/**
 * @param VereinsmeldeModul[] $items 
 * @param Season $season
 * @param Vereinsmeldung $vereinsmeldung
 */

use yii\helpers\Url;

/* 
 * Item
 */
$i = 0;
foreach($items as $item){
    $i++;
?>

                <li class="list-group-item list-group-item-action border border-1 border-secondary p-1 m-1 <?= ($item->isDone($vereinsmeldung))?'bg-light opacity-50':'' ?>">
                    <div class="card-body" id="vereinsmeldemodul-<?= $item->id ?>">
                        <h5 class="card-title" id="item-<?= $item->id ?>">
                            <?= $i.'.' . $item->name ?>
                        </h5>
                        <i class="bi bi-check text-<?= ($item->isDone($vereinsmeldung))?'success':'danger'?>"></i>
                        <small class="fst-italic text-<?= ($item->isDone($vereinsmeldung))?'success':'danger'?>">
                            <?= ($item->isDone($vereinsmeldung))?'Bereits erledigt':'Noch nicht erledigt' ?>
                            <?php if($doneDetails = $item->doneError($vereinsmeldung)){?>
                            <div class=""><?= $doneDetails ?></div>
                            <?php } ?>
                        </small>
                        <a href="<?= Url::toRoute([$item->url, 'p'=>$vereinsmeldung->id]) ?>" class="stretched-link"></a>
                    </div>
                </li>

<?php } ?>
