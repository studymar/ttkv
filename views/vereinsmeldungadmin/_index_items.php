<?php
/**
 * @param Vereinsmeldundadmin Season[] $items 
 * @param Season $season
 */

use yii\helpers\Url;

/* 
 * Item
 */
$i = 0;
foreach($items as $item){
    $i++;
?>

                <li class="list-group-item list-group-item-action border border-1 border-secondary p-1 m-1">
                    <div class="card-body">
                        <h5 class="card-title" id="item-<?= $item->id ?>">
                            <?= $item->name ?>
                            <?php if($item->active){?>
                            <span class="badge bg-warning text-dark">Aktiv</span>
                            <?php } ?>
                        </h5>
                            <small class="fst-italic">
                                <div class="">
                                    <i class="bi bi-check"></i>
                                    Daten vom Vorjahr übernommen
                                </div>
                            </small>
                            <a href="<?= Url::toRoute(['vereinsmeldungadmin/edit-season','p'=>$item->id]) ?>" class="stretched-link"></a>
                    </div>
                </li>

<?php } ?>
