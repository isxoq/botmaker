<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "site_app_clips".
 *
 * @property int $id
 * @property string|null $image
 */
class SiteAppClips extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_app_clips';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Image'),
        ];
    }
}
