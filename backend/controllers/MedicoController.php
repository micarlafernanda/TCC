<?php

namespace app\controllers;

use Yii;
use app\models\Medico;
use yii\filters\auth\HttpBearerAuth;

class MedicoController extends \app\components\controllers\ActiveRestrictController
{
   public $modelClass = 'app\models\Medico';

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
