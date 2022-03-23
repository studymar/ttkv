<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;

class ContentController extends Controller
{

    /**
     */
    public function actionImpressum()
    {
        
        return $this->render('impressum');
    }

    /**
     */
    public function actionDatenschutz()
    {
        
        return $this->render('datenschutz');
    }
    
}
