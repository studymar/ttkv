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

class RolemanagerController extends Controller
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
        $model = new Role();

        $role = Role::find();
        if($p && ($p2 == "1" || $p2 === "0") && $model->hasProperty($p)){ 
            $role->orderBy([$p=>($p2)?SORT_DESC:SORT_ASC]);
        }
        
        return $this->render('index',[
            'role' => $role->all(),
            'p2'   => $p2
        ]);
    }
    
    /**
     * Edit Role
     * @param Int $id ID der Role, der editiert werden soll
     */
    public function actionEdit($p)
    {
        $role = Role::find()->where(['id' => $p])->one();
        if($role){
            $model = new \app\models\forms\RoleEditForm();
            $model->mapFromRole($role);
            
            if($model->load(Yii::$app->request->post()) && $model->validate() ){
                $role = $model->mapToRole($role);
                if($role->save() && $model->saveRights($role)){
                    $this->redirect (['rolemanager/index']);
                }
            }
            //ausgewählt vorbereiten
            $right_ids = [];
            foreach($role->rights as $item){
                $right_ids[] = $item->id;
            }
            $model->rights = $right_ids;
            
            $rightgroups = \app\models\user\Rightgroup::find()->all();
            $allRights   = Right::find()->asArray()->all();
            $allRights   = \yii\helpers\ArrayHelper::map($allRights, 'id', 'name');
            return $this->render('edit',[
                'model'     => $model,
                'role'      => $role,
                'rights'    => $right_ids,
                'allRights' => $allRights,
                'rightgroups'=> $rightgroups,
            ]);

        }
        Yii::error("Role EDIT: Role not found (ID ".$p.")", __METHOD__);
        throw new NotFoundHttpException("Role not found");
        
    }

    
}
