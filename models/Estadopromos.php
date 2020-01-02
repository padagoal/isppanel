<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadopromos".
 *
 * @property string $estado
 *
 * @property Promocion[] $promocions
 */
class Estadopromos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadopromos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'required'],
            [['estado'], 'string', 'max' => 20],
            [['estado'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estado' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromocions()
    {
        return $this->hasMany(Promocion::className(), ['estado' => 'estado']);
    }
}
