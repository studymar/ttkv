<?php
namespace app\models\filters;

use Yii;
use yii\web\ForbiddenHttpException;
use dpodium\yii2\geoip\components\CGeoIP;

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
class MyCountryFilter extends \yii\base\ActionFilter
{
    public $countryCode = null;
    public $countryName = null;

    /**
     * Initializes the [[rules]] array by instantiating rule objects from configurations.
     */
    public function init()
    {
        parent::init();
//        $location = Yii::$app->geoip->lookupLocation(Yii::$app->getRequest()->getUserIP());
//        $this->countryCode = Yii::$app->geoip->lookupCountryCode();
//        $this->countryCode = $location->countryCode;
//        $this->countryName = Yii::$app->geoip->lookupCountryName();
//        $this->countryName = $location->countryName;
    }

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     * @param Action $action the action to be executed.
     * @return bool whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {
        //Aufrufe aus dem Ausland ausschließen
        $req_continent 		= (isset($_SERVER['GEOIP_CONTINENT_CODE']))?$_SERVER['GEOIP_CONTINENT_CODE']:'';
        $req_country_code	= (isset($_SERVER['GEOIP_COUNTRY_CODE']))?$_SERVER['GEOIP_COUNTRY_CODE']:'';
        $req_country_name	= (isset($_SERVER['GEOIP_COUNTRY_NAME']))?$_SERVER['GEOIP_COUNTRY_NAME']:'';
        $req_region             = (isset($_SERVER['GEOIP_REGION_NAME']))?$_SERVER['GEOIP_REGION_NAME']:'';
        $req_city 		= (isset($_SERVER['GEOIP_CITY']))?$_SERVER['GEOIP_CITY']:'';
        
        if($req_country_code!="" && $req_country_code != "DE" && $req_country_code != "AT" && $req_country_code != "ES"){
            Yii::debug("IP:".Yii::$app->getRequest()->getUserIP() ." Country: ".$req_country_code. "Forbidden", __METHOD__);
            return $this->denyAccess();
        }
        
        return true;
    }
    
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User|false $user the current user or boolean `false` in case of detached User component
     * @throws ForbiddenHttpException if the user is already logged in or in case of detached User component.
     */
    protected function denyAccess()
    {
        throw new ForbiddenHttpException(Yii::t('yii', 'From your Position it is not allowed to perform this action.'));
    }

}
