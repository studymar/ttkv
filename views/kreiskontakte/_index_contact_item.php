<?php
/**
 * Contact item Line
 * @param KreisKontakt[] $items 
 */

use yii\helpers\Url;

/* 
 * Item
 */
$i = 0;
foreach($items as $rolle){
    $kontakte = $rolle->kreiskontakte;
    foreach ($kontakte as $item){
    $i++;
?>
                    <li class="list-group-item border border-1 border-secondary p-1 px-0 m-0 mx-0">
                        <div class="card-body p-1 mx-0">
                            <h5 class="card-title mb-0 fw-bold" id="item-<?= $item->id ?>">
                                <?= $item->vereinsrolle->name ?>
                            </h5>
                            <div>
                                <div class="person d-flex">
                                    <div class="name"><?= $item->person->firstname ?> <?= $item->person->lastname ?></div>
                                    <?php if($item->person->getAddress()){ ?>
                                    <div class="address"><?= $item->person->getAddress() ?></div>
                                    <?php } ?>
                                </div>
                                <div class="contactdata d-flex">
                                    <div class="email"><a href="mailto:<?= $item->person->email ?>"><?= $item->person->email ?></a></div>
                                    <?php if($item->person->phone){ ?>
                                    <div class="phone"><a href="tel:<?= ($item->person->phone)?', '.$item->person->phone:'' ?>"><?= ($item->person->phone)?', '.$item->person->phone:'' ?></a></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </li>

<?php } 
}
if(count($items) == 0){ ?>
    <div id="no-vereinskontakte" class="fst-italic">
        Kein Personen angegeben
    </div>
<?php }
?>
                