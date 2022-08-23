<?php

namespace app\controllers;

use Yii;
use app\models\Familia;
use yii\filters\auth\HttpBearerAuth;

class FamiliaController extends \app\components\controllers\ActiveRestrictController
{
   public $modelClass = 'app\models\Familia';

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className()
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }
}
