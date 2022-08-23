<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "endereco".
 *
 * @property int $id
 * @property string $logradouro
 * @property string $numero
 * @property string|null $bairro
 * @property int $familia_id
 *
 * @property Familia $familia
 */
class Endereco extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'endereco';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logradouro', 'numero', 'familia_id'], 'required'],
            [['familia_id'], 'integer'],
            [['logradouro'], 'string', 'max' => 100],
            [['numero'], 'string', 'max' => 5],
            [['bairro'], 'string', 'max' => 45],
            [['familia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Familia::className(), 'targetAttribute' => ['familia_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logradouro' => 'Logradouro',
            'numero' => 'Numero',
            'bairro' => 'Bairro',
            'familia_id' => 'Familia ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFamilia()
    {
        return $this->hasOne(Familia::className(), ['id' => 'familia_id']);
    }

    public function extraFields()
    {
        return ['familia'];
    }
}
