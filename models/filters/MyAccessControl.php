<?php
namespace app\models\filters;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\User;

/**
 * To add MyAccessControl add this in behaviour of your Controller
 *
 * public function behaviors()
 * {
 *     return [
 *         'access' => [
 *             'class' => \yii\models\filters\MyAccessControl::class,
 *             'rules' => [
 *                 'index' => [ // if action is not set, access will be forbidden
 *                     'neededRight'    => 'read',
 *                     'allowedMethods' => ['POST'] // or [] for all
 *                 ],
 *                 'home' => [ // if neededright is +, access will only be allowed after login
 *                     'neededRight'    => '+', //all requests ok
 *                     'allowedMethods' => [] // for all
 *                 ],
 *                 'save' => [ // if method is set, only this method is allowed
 *                     'neededRight'    => '', //all requests ok
 *                     'allowedMethods' => ['post'] // for only with method post
 *                 ],
 *                 'add' => [ // if action is not set, access will be allowed, as well empty right
 *                     'neededRight'    => '', //all requests ok
 *                     'allowedMethods' => [] // for all
 *                 ],
 *                 // all other actions are allowes
 *             ],
 *         ],
 *     ];
 * }
 */

/*
 * @author Mark Worthmann
 */
class MyAccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User|array|string|false|null the user object
     */
    public $user        = null;
    public $userrights  = []; // right of the user
    
    /**
     * @var array Rights needed for this Action
     */
    public $rules = [];


    /**
     * Initializes the [[rules]] array by instantiating rule objects from configurations.
     */
    public function init()
    {
        parent::init();
        if ($this->user !== null) {
            //be sure, cookie ist renewed with every visit
            Yii::$app->user->autoRenewCookie = true;
            
            //load user, if logged in
            if(!Yii::$app->user->isGuest){
                $this->user = Yii::$app->user->identity;
                if($this->user){
                    $this->userrights = $this->user->getRightsAsArray();
                }
            }
            
        }
    }

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     * @param Action $action the action to be executed.
     * @return bool whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {
        //get neededRights for this action
        $rulesOfAction = \yii\helpers\ArrayHelper::getValue($this->rules,[$action->id]);
        
        //wenn aktuelle action nicht eingeschraenkt wurde, ok
        if( $rulesOfAction == null )
            return true;
        
        $neededRight    = $rulesOfAction['neededRight'];
        $allowedMethods = $rulesOfAction['allowedMethods'];

        //alle erlaubt?
        if( $this->checkRights($neededRight) 
            && $this->checkMethods($allowedMethods, Yii::$app->getRequest()->method) ){
            if(!Yii::$app->user->isGuest) 
                Yii::$app->getUser()->identity->updateLastlogin();
            return true;
        }
        
        //Fehler ausloggen
        if(!Yii::$app->user->isGuest)Yii::error("Action Forbidden: ".$action->id."/User:".Yii::$app->getUser()->identity->email."/ NeededRight:".$neededRight. "/ HasRights:".json_encode($this->userrights)."/AllowedMethods:".json_encode($allowedMethods)."/HasMethod:".Yii::$app->getRequest()->method, __METHOD__);
        else Yii::error("Action Forbidden: ".$action->id."/User:guest"."/ NeededRight:".$neededRight. "/ HasRights:[]"."/AllowedMethods:".json_encode($allowedMethods)."/HasMethod:".Yii::$app->getRequest()->method, __METHOD__);
        return $this->errorResponseForbidden();
    }
    
    /**
     * 
     * @param string $neededRight
     * @param array $rightsOfUser
     */
    public function checkRights($neededRight)
    {
        //nur eingeloggt nötig
        if( $neededRight == "+" && !Yii::$app->getUser()->isGuest) {
            return true;
        }
        //spezielles recht nötig?
        else if( $neededRight == "" ||
            ( !Yii::$app->getUser()->isGuest && Yii::$app->getUser()->identity->hasRight($neededRight))
            ){
                return true;
            }
        //sonst nicht erlaubt
        return false;
        
    }    

    /**
     * 
     * @param array $allowedMethods
     * @param string $method
     */
    public function checkMethods($allowedMethods, $method)
    {
        if(empty($allowedMethods))
            return true;
        return \yii\helpers\ArrayHelper::isIn($method, $allowedMethods);
    }    
    
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User|false $user the current user or boolean `false` in case of detached User component
     * @throws ForbiddenHttpException if the user is already logged in or in case of detached User component.
     */
    protected function denyAccess($user)
    {
        if ($user !== null || $user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
    
    
    private function errorResponseForbidden() {

        // set response code to 400
        Yii::$app->response->statusCode = 401;
        $message = "Forbidden";

        if(Yii::$app->request->isAjax)
            echo \yii\helpers\Json::encode ($message);
        else 
            throw new ForbiddenHttpException($message);
        
    }

}
