<?php

namespace backend\modules\eskizsms\models;

use Yii;

/**
 * This is the model class for table "eskiz_sms".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $key
 */
class EskizSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eskiz_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['key'], 'string'],
            [['username', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'key' => Yii::t('app', 'Key'),
        ];
    }
}
