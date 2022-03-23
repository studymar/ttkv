<?php
/**
 * @param VereinsKontakte $items 
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
                    <div class="card-body p-2 contact">
                        <h5 class="card-title vereinsrolle mb-0 fw-bold" id="item-<?= $item->id ?>">
                            <?= $item->vereinsrolle->name ?>
                        </h5>
                        <div>
                            <div class="person d-flex">
                                <div class="name"><?= $item->person->firstname ?> <?= $item->person->lastname ?></div>
                                <div class="address"><?= $item->person->getAddress() ?></div>
                            </div>
                            <div class="contactdata d-flex">
                                <div class="email"><?= $item->person->email ?></div>
                                <div class="phone"><?= ($item->person->phone)?', '.$item->person->phone:'' ?></div>
                            </div>
                        </div>
                        <a href="<?= Url::toRoute(['vereinsmeldung/edit-person','p'=>$item->person->id]) ?>" class="stretched-link"></a>
                    </div>
                </li>

<?php } 

if(count($items) == 0){ ?>
    <div id="no-vereinskontakte">
        Bitte gib die Ansprechpartner deines Vereins ein <br/>
        (mind. den Abteilungsleiter als Hauptkontakt für den TTKV).
    </div>
<?php }
?>
