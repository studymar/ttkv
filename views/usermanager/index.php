<?php

use yii\helpers\Url;
use app\models\helpers\DateConverter;

/* 
 * index
 */
?>
    <article>
        <h2>Usermanager</h2>
        <div>
            <table class="table table-hover" id="usermanager-list">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><a href="<?= Url::toRoute(['usermanager/index','p'=>'lastname','p2'=>($p2)?'0':'1']) ?>">Name</a></th>
                    <th scope="col"><a href="<?= Url::toRoute(['usermanager/index','p'=>'vereins_id','p2'=>($p2)?'0':'1']) ?>">Verein</a></th>
                    <th scope="col"><a href="<?= Url::toRoute(['usermanager/index','p'=>'lastlogindate','p2'=>($p2)?'0':'1']) ?>">Lastlogin</a></th>
                    <th scope="col">Rolle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($user as $item){ ?>
                <tr class="<?= ($item->locked)?"locked-user":"" ?>">
                    <th scope="row"><?= $item->id ?></th>
                    <td><a href="<?= Url::toRoute(['usermanager/edit','p'=>$item->id]) ?>" class="" id="editlink-user-<?= $item->id ?>"><?= $item->lastname ?>, <?= $item->firstname ?></a></td>
                    <td><?= $item->verein->name ?></td>
                    <td><?= DateConverter::convert($item->lastlogindate) ?></td>
                    <td><?= $item->role->name ?></td>
                </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
    </article>

