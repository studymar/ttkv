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
                        <div>
                            <div class="person d-flex">
                                <div class="name"><?= $item->firstname ?> <?= $item->lastname ?></div>
                                <div class="address"><?= $item->getAddress() ?></div>
                            </div>
                            <div class="contactdata d-flex">
                                <div class="email"><?= $item->email ?></div>
                                <?php if($item->phone){?><div class="phone"><?= $item->phone ?></div><?php } ?>
                            </div>
                        </div>
                        <a href="<?= Url::toRoute(['vereinsmeldungadmin/edit-person','p'=>$item->id]) ?>" class="stretched-link" id="person-<?= $item->lastname ?>"></a>
                    </div>
                </li>

<?php } ?>
