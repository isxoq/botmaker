<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "answer_tiket".
 *
 * @property int $id
 * @property int|null $tiket_id
 * @property int|null $user_id
 * @property string|null $message
 * @property string|null $file
 */
class AnswerTiket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer_tiket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tiket_id', 'user_id'], 'integer'],
            [['message'], 'string'],
            [['file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tiket_id' => Yii::t('app', 'Tiket ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'message' => Yii::t('app', 'Message'),
            'file' => Yii::t('app', 'File'),
        ];
    }
}
