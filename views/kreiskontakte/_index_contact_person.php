<?php
/**
 * Contact Person Line
 * @param Person[] $items 
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
                                    <div class="name"><?= $item->firstname ?> <?= $item->lastname ?></div>
                                    <?php if($item->getAddress()){ ?>
                                    <div class="address"><?= $item->getAddress() ?></div>
                                    <?php } ?>
                                </div>
                                <div class="contactdata d-flex">
                                    <div class="email"><a href="mailto:<?= $item->email ?>"><?= $item->email ?></a></div>
                                    <?php if($item->phone){ ?>
                                    <div class="phone"><a href="tel:<?= ($item->phone)?', '.$item->phone:'' ?>"><?= ($item->phone)?', '.$item->phone:'' ?></a></div>
                                    <?php } ?>
                                </div>
                                <a href="<?= Url::toRoute(['kreiskontakte/edit-person','p'=>$item->id]) ?>" class="stretched-link" id="item-new-link"></a>
                            </div>
                        </div>
                    </li>

<?php } 

if(count($items) == 0){ ?>
    <div id="no-vereinskontakte" class="fst-italic">
        Kein Personen angegeben
    </div>
<?php }
?>
                