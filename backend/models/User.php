<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string $senha
 * @property string $authKey
 * @property string $accessToken
 * @property string $tipo
 *
 * @property Atendente[] $atendentes
 * @property Medico[] $medicos
 * @property Paciente[] $pacientes
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->authKey = \Yii::$app->security->generateRandomString(100);
                $this->accessToken = \Yii::$app->security->generateRandomString(100);
            }

            if (($this->isNewRecord) || $this->isAttributeChanged('senha')) {
                $this->senha = Yii::$app->getSecurity()->generatePasswordHash($this->senha);
            }
            return true;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['nome', 'cpf', 'senha', 'authKey', 'accessToken'], 'required'],
            [['nome', 'cpf', 'senha', 'tipo'], 'required'],
            [['nome', 'senha', 'authKey', 'accessToken'], 'string', 'max' => 100],
            [['cpf'], 'string', 'max' => 14],
            [['tipo'], 'string', 'max' => 10],
            [['cpf'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'cpf' => 'Cpf',
            'senha' => 'Senha',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtendentes()
    {
        return $this->hasMany(Atendente::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasMany(Medico::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['user_id' => 'id']);
    }

    /**
     * Gera um novo AuthKey
     */
    public function newAuthKey()
    {
        $this->authKey = \Yii::$app->security->generateRandomString(100);
        if ($this->save()) {
            return $this->authKey;
        } else return null;
    }

    /**
     * Gera um novo AccessToken
     */
    public function newAccessToken()
    {
        $this->accessToken = \Yii::$app->security->generateRandomString(100);
        if ($this->save()) {
            return $this->accessToken;
        } else return null;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($senha)
    {
        return Yii::$app->getSecurity()->validatePassword($senha, $this->senha);
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['senha'], $fields['authKey'], $fields['accessToken']);

        return $fields;
    }
}
