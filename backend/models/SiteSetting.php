<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "site_setting".
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $image
 * @property string|null $value_uz
 * @property string|null $value_ru
 */
class SiteSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value_uz', 'value_ru'], 'string'],
            [['key'], 'string', 'max' => 255],
            ['image','file']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'key' => Yii::t('app', 'Key'),
            'image' => Yii::t('app', 'Image'),
            'value_uz' => Yii::t('app', 'Value Uz'),
            'value_ru' => Yii::t('app', 'Value Ru'),
        ];
    }

    public static function get($key)
    {
        $setting = self::findOne(['key' => $key]);
        if ($setting) {
            if ($setting->image) {
                return $setting->image;
            } else {
                switch (Yii::$app->language) {
                    case 'uz':
                        return $setting->value_uz;
                    case "ru":
                        return $setting->value_ru;
                    default:
                        return $key;
                }
            }
        } else {
            return $key;
        }
    }
}
