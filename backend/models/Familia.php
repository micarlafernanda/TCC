<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "familia".
 *
 * @property int $id
 * @property string $numeroProntuario
 * @property string $ubs
 * @property string $nomeResponsavel
 * @property string $posicaoFamiliar
 *
 * @property Endereco[] $enderecos
 * @property Paciente[] $pacientes
 */
class Familia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'familia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numeroProntuario', 'ubs', 'nomeResponsavel', 'posicaoFamiliar'], 'required'],
            [['numeroProntuario'], 'string', 'max' => 45],
            [['ubs', 'nomeResponsavel', 'posicaoFamiliar'], 'string', 'max' => 100],
            [['numeroProntuario'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numeroProntuario' => 'Numero Prontuario',
            'ubs' => 'Ubs',
            'nomeResponsavel' => 'Responsável pela família',
            'posicaoFamiliar' => 'Posição na família'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnderecos()
    {
        return $this->hasMany(Endereco::className(), ['familia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['familia_id' => 'id']);
    }
}
