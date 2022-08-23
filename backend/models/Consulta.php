<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consulta".
 *
 * @property int $id
 * @property string $data
 * @property string|null $diagnostico
 * @property string|null $conduta
 * @property float|null $peso
 * @property float|null $temperatura
 * @property string|null $pressaoArterial
 * @property int $medico_id
 * @property int $paciente_id
 * @property string|null $medico_nome
 * @property string|null $paciente_nome
 * @property Medico $medico
 * @property Paciente $paciente
 */
class Consulta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consulta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peso', 'temperatura'], 'number'],
            [['data', 'medico_id', 'paciente_id'], 'required'],
            [['medico_id', 'paciente_id'], 'integer'],
            [['data'], 'string', 'max' => 10],
            [['medico_nome', 'paciente_nome'], 'string', 'max' => 100],
            [['diagnostico', 'conduta'], 'string', 'max' => 256],
            [['pressaoArterial'], 'string', 'max' => 7],
            [['medico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['medico_id' => 'id']],
            [['paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['paciente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'diagnostico' => 'Diagnostico',
            'conduta' => 'Conduta',
            'peso' => 'Peso',
            'temperatura' => 'Temperatura',
            'pressaoArterial' => 'Pressao Arterial',
            'medico_id' => 'Medico ID',
            'paciente_id' => 'Paciente ID',
            'medico_nome' => 'Medico Nome',
            'paciente_nome' => 'Paciente Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedico()
    {
        return $this->hasOne(Medico::className(), ['id' => 'medico_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'paciente_id']);
    }

    public function extraFields()
    {
        return ['medico', 'paciente'];
    }
}
