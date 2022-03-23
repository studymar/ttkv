<?php

/**
 * Wird in Main geladen
 * @param string $content beinhaltet nur den Namen der zu ladenen Vue-Component
 */

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;

//use app\assets\LayoutAsset;
//LayoutAsset::register($this);

/*
if(YII_ENV_TEST)
    $env_vuecomponent_dir = __DIR__.'/../../web/vue-components/';
else $env_vuecomponent_dir = "vue-components/";

include_once($env_vuecomponent_dir.'structure/'.'header.php');
include_once($env_vuecomponent_dir.'structure/'.'navmenu.php');
include_once($env_vuecomponent_dir.'structure/'.'footer.php');
include_once($env_vuecomponent_dir.'pages/'.'impressum.php');
include_once($env_vuecomponent_dir.'pages/'.'datenschutz.php');

include_once($env_vuecomponent_dir.'pages/'.'home.php');
include_once($env_vuecomponent_dir.'pages/'.'login.php');
include_once($env_vuecomponent_dir.'pages/'.'prelogin.php');
include_once($env_vuecomponent_dir.'pages/'.'anmelden.php');
include_once($env_vuecomponent_dir.'pages/loggedin/'.'homeloggedin.php');
include_once($env_vuecomponent_dir.'pages/loggedin/'.'mymenue.php');
*/

?>
    <div id="app">
        <div id="bar"></div>
        <div id="wrapper">

            <?php // Yii::$app->runAction('/_header', []); ?>
            <?= $this->render('_header', []); ?>
            
            <?= Yii::$app->runAction('navmenu/index'); ?>

            <hr class="noscreen" />
            <div id="skip-menu"></div>

            <div id="content"> 

                <div id="column-1">
                    <?= $content ?>
                </div>

                <?php /*
                <div id="column-2">
                    <?= $this->render('_relatedMenu'); ?>
                </div> <!-- Column 2 end -->
                 * 
                 */
                ?>
                <div class="cleaner">&nbsp;</div>
            </div>
            <!-- Content of the site end -->


            <?= $this->render('_footer', []); ?>

        </div> <!-- Wrapper end -->
    </div>

 