<?php

namespace app\controllers;

use Yii;
use app\models\Paciente;
use yii\filters\auth\HttpBearerAuth;

class PacienteController extends \app\components\controllers\ActiveRestrictController
{
   public $modelClass = 'app\models\Paciente';

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
