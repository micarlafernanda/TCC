<?php

namespace app\controllers;

use Yii;
use app\models\Consulta;
use yii\filters\auth\HttpBearerAuth;

class ConsultaController extends \app\components\controllers\ActiveRestrictController
{
   public $modelClass = 'app\models\Consulta';

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
