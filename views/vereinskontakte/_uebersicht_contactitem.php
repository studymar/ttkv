<?php
/**
 * Contact item Line
 * @param VereinsKontakt[] $items 
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

                <!--
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
                -->
<?php } 

if(count($items) == 0){ ?>
    <div id="no-vereinskontakte" class="fst-italic">
        Kein Kontakt angegeben
    </div>
<?php }
?>

                <!-- Demo --
                <ul class="list-group link-group first-item-without-border-bottom my-1">
                    <li class="list-group-item border border-1 border-secondary p-1 px-0 m-0 mx-0">
                        <div class="card-body p-1 mx-0">
                            <h5 class="card-title mb-0 fw-bold" id="item-0">
                                Fachwart
                            </h5>
                            <div>
                                <div class="person d-flex">
                                    <div class="name">Max Mustermann</div>
                                    <div class="address">Musterstraße 5a, 21641 Musterort</div>
                                </div>
                                <div class="contactdata d-flex">
                                    <div class="email"><a href="mailto:abc@gmail.com">abc@gmail.com</a></div>
                                    <div class="phone"><a href="tel:0178123456789">0178123456789</a></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item border border-1 border-secondary p-1 px-0 m-0 mx-0">
                        <div class="card-body p-1 mx-0">
                            <h5 class="card-title mb-0 fw-bold" id="item-0">
                                Stv.Fachwart
                            </h5>
                            <div>
                                <div class="person d-flex">
                                    <div class="name">Max Mustermann</div>
                                    <div class="address">Musterstraße 5a, 21641 Musterort</div>
                                </div>
                                <div class="contactdata d-flex">
                                    <div class="email"><a href="mailto:abc@gmail.com">abc@gmail.com</a></div>
                                    <div class="phone"><a href="tel:0178123456789" class="link-secondary fst-normal font-weight-normal">0178123456789</a></div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                -->
                