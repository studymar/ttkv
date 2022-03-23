<?php

use yii\helpers\Url;
use app\models\helpers\DateConverter;

/* 
 * index
 */
?>
    <article>
        <h2>Rolemanager</h2>
        <div>
            <table class="table table-hover" id="rolemanager-list">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><a href="<?= Url::toRoute(['rolemanager/index','p'=>'lastname','p2'=>($p2)?'0':'1']) ?>">Name</a></th>
                    <th scope="col"><a href="<?= Url::toRoute(['rolemanager/index','p'=>'anzUsers','p2'=>($p2)?'0':'1']) ?>">AnzUsers</a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($role as $item){ ?>
                <tr class="">
                    <th scope="row"><?= $item->id ?></th>
                    <td><a href="<?= Url::toRoute(['rolemanager/edit','p'=>$item->id]) ?>" class=""><?= $item->name ?></a></td>
                    <td><?= $item->getCountUsers() ?></td>
                </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
    </article>

