<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;

class NavmenuController extends Controller
{
    public $layout = 'contentOnly';

    /**
     * Displays Menu
     *
     * @return string
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }

}
