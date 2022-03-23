<?php

/* 
 * Zeigt die Hauptnavigation an
 * - Unterscheidet nach eingeloggt/nicht eingeloggt (Meine Daten)
 * - Unterscheidet zwischen Web- und Mobile(Responsive)-Ansicht
 */

use yii\helpers\Url;

?>

    <div>
        <!-- Menu -->
        <nav id="menu-box" class="cleaning-box">
            <ul id="menu">
                <li>
                    <a href="<?= Url::toRoute([(!Yii::$app->getUser()->isGuest)?'account/home':'site/index']) ?>" target="" class="">Home</a>
                </li>
                <li class="divider"></li>
                <li class="right-aligned user-menu submenu-parent">
                    <?php if(!Yii::$app->getUser()->isGuest) { ?>
                    <div>
                        <a href="<?= Url::toRoute(['account/mymenue']) ?>" role="button" id="myMenuButton">Mein Menü</a>
                    </div>
                    <?php } ?>
                </li>
            </ul>
        </nav> 
        <!-- Menu end -->
        
        <!-- Hauptmenu Responsive Start -->
        <nav id="menu-box-responsive" class="cleaning-box">
            <ul id="menuResponsive">
                <li class="submenu-parent">
                    <a href="<?= Url::toRoute([(!Yii::$app->getUser()->isGuest)?'account/home':'site/index']) ?>" class="first hamburger submenu-parent">Menü</a>
                </li>
                <li class="divider"></li>
                <li class="right-aligned user-menu">
                    <?php if(!Yii::$app->getUser()->isGuest) { ?>
                    <div>
                        <a href="<?= Url::toRoute(['account/mymenue']) ?>" role="button" class="hamburger account submenu-parent">Mein Menü</a>
                    </div>
                    <?php } ?>
                </li>
            </ul>
        </nav>
    </div>
