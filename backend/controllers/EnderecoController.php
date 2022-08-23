<?php

namespace app\controllers;

use Yii;
use app\models\Endereco;
use yii\filters\auth\HttpBearerAuth;

class EnderecoController extends \app\components\controllers\ActiveRestrictController
{
   public $modelClass = 'app\models\Endereco';

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
