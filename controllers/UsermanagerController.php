<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\filters\MyAccessControl;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use app\models\forms\RegistrationForm;
use app\models\Verein;
use yii\web\ForbiddenHttpException;
use app\models\user\User;
use app\models\user\Role;
use app\models\user\Right;

class UsermanagerController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => MyAccessControl::class,
                'rules' => [
                    'index' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_USERMANAGER,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'edit' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_USERMANAGER,
                        'allowedMethods' => [] // or [] for all
                    ],
                    'editVerein' => [ // if action is not set, access will be forbidden
                        'neededRight'    => Right::ID_RIGHT_USERMANAGER,
                        'allowedMethods' => [] // or [] for all
                    ],
                    // all other actions are allowed
                ],
            ],
        ];
    }
    

    /**
     * Liste
     * @param String $sort Columnname 
     * @param Boolean $desc Sorting desc? 
     */
    public function actionIndex($p = 'id', $p2 = null)
    {
        $model = new User();

        $user = User::find();
        if($p && ($p2 == "1" || $p2 === "0") && $model->hasProperty($p)){ 
            $user->orderBy([$p=>($p2)?SORT_DESC:SORT_ASC]);
        }
        
        return $this->render('index',[
            'user' => $user->all(),
            'p2'   => $p2
        ]);
    }
    
    /**
     * Edit User
     * @param Int $id ID des Users, der editiert werden soll
     */
    public function actionEdit($p)
    {
        $user = User::findIdentity($p);
        if($user){
            $model = new \app\models\forms\UserEditForm();
            $model->mapFromUser($user);
            
            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $user = $model->mapToUser($user);
                if($user->save())
                    $this->redirect (['usermanager/index']);
            }
            $roles = Role::find()
                ->select(['name'])
                ->indexBy('id')
                ->column();
            return $this->render('edit',[
                'model'     => $model,
                'user'      => $user,
                'roles'     => $roles,
            ]);

        }
        Yii::error("USER EDIT: User not found (ID ".$p.")", __METHOD__);
        throw new NotFoundHttpException("User not found");
        
    }

    /**
     * Edit User EditVerein
     * @param Int $id ID des Users, der editiert werden soll
     */
    public function actionEditVerein($p)
    {
        $user = User::findIdentity($p);
        if($user){
            $model = new \app\models\forms\UserEditVereinForm();
            $model->mapFromUser($user);
            
            $vereine = Verein::find()->orderBy('ort')
                ->select(['name'])
                ->indexBy('id')
                ->column();
            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $user = $model->mapToUser($user);
                if($user->save())
                    $this->redirect (['usermanager/edit','p'=>$p]);
            }
            return $this->render('edit-verein',[
                'model'     => $model,
                'vereine'   => $vereine,
                'user'      => $user,
            ]);

        }
        Yii::error("USER EDIT Verein: User not found (ID ".$p.")", __METHOD__);
        throw new NotFoundHttpException("User not found");
        
    }

    
}
