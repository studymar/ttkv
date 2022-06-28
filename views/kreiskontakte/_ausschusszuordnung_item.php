<?php
/**
 * Ausschusszuordnung item Line
 * @param Vereinsrolle[] $items 
 */

use yii\helpers\Url;

/* 
 * Item
 */
$i = 0;
foreach($items as $item){
    $i++;
?>
                    <li class="list-group-item border border-1 border-secondary p-1 px-0 m-0 mx-0">
                        <div class="card-body p-1 mx-0">
                            <h5 class="card-title mb-0 fw-bold" id="item-<?= $item->id ?>">
                                <?= $item->name ?>
                            </h5>
                        </div>
                    </li>

<?php } 

if(count($items) == 0){ ?>
    <div id="no-vereinskontakte" class="fst-italic">
        Kein Rolle zugeordnet
    </div>
<?php }
?>
                