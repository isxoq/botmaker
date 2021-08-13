<?php

namespace frontend\modules\ecommerce\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property int|null $old_price
 * @property int $price
 * @property int $product_type
 * @property string|null $description
 * @property string|null $image
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{

    const TYPE_DIGITAL = 1;
    const TYPE_COUNTABLE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'price', 'product_type'], 'required'],
            [['category_id', 'old_price', 'price', 'product_type'], 'integer'],
            [['description'], 'string'],
            [['name', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'category_id' => Yii::t('app', 'Category ID'),
            'product_type' => Yii::t('app', 'Product Type'),
            'old_price' => Yii::t('app', 'Old Price'),
            'price' => Yii::t('app', 'Price'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function find()
    {
        return parent::find()->joinWith('category')->andWhere(['telegram_bot.id' => Yii::$app->controller->module->bot->id]);
    }
}
