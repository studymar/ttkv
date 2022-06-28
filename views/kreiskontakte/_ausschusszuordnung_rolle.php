<?php
/**
 * Ausschusszuordnung Rolle Line
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
                    <li class="list-group-item list-group-item-action border border-1 border-secondary p-1 px-0 m-0 mx-0">
                        <div class="card-body p-1 mx-0">
                            <div>
                                <div class="person d-flex">
                                    <div class="name"><?= $item->name ?></div>
                                </div>
                                <a href="<?= Url::toRoute(['kreiskontakte/ausschusszuordnung-edit-role','p'=>$item->id]) ?>" class="stretched-link" id="item-new-link"></a>
                            </div>
                        </div>
                    </li>

<?php } 

if(count($items) == 0){ ?>
    <div id="no-vereinskontakte" class="fst-italic">
        Keine Personen angegeben
    </div>
<?php }
?>
                