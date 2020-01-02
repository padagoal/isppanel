<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userprofile".
 *
 * @property string $profile
 * @property bool $internal
 */
class Userprofile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userprofile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile'], 'required'],
            [['internal'], 'boolean'],
            [['profile'], 'string', 'max' => 255],
            [['profile'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile' => Yii::t('app', 'Profile'),
            'internal' => Yii::t('app', 'Internal'),
        ];
    }
}
