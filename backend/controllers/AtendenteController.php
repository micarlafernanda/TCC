<?php

namespace app\controllers;

use Yii;
use app\models\Atendente;
use yii\filters\auth\HttpBearerAuth;

class AtendenteController extends \app\components\controllers\ActiveRestrictController
{
   public $modelClass = 'app\models\Atendente';

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
