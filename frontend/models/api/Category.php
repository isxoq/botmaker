<?php

namespace frontend\models\api;

use frontend\models\TelegramBot;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $order_id
 * @property string|null $image
 * @property int|null $status
 *
 * @property TelegramBot $bot
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_id', 'parent_id', 'order_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
            [['bot_id'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramBot::className(), 'targetAttribute' => ['bot_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bot_id' => Yii::t('app', 'Bot ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'order_id' => Yii::t('app', 'Order ID'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
        ];
    }


    public function getParent()
    {
        return self::findOne(['id' => $this->parent_id]);
    }


    /**
     * Gets query for [[Bot]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBot()
    {
        return $this->hasOne(TelegramBot::className(), ['id' => 'bot_id']);
    }

    public function getSCategories()
    {
        return self::find()
            ->andWhere(['parent_id' => $this->id])
            ->andWhere(['bot_id' => $this->bot_id])
            ->all();
    }

    public static function getSubCategories($categoryName)
    {
        $category = self::findOne(['name' => $categoryName]);
        return Category::find()
            ->andWhere(['parent_id' => $category->id])
            ->andWhere(['bot_id' => $category->bot_id])
            ->all();
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }


}
