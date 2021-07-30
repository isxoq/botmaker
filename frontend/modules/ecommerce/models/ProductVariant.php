<?php

namespace frontend\modules\ecommerce\models;

use Yii;

/**
 * This is the model class for table "product_variant".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $name
 * @property int|null $old_price
 * @property int $price
 *
 * @property Product $product
 */
class ProductVariant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_variant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'old_price', 'price'], 'integer'],
            [['price'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'name' => Yii::t('app', 'Name'),
            'old_price' => Yii::t('app', 'Old Price'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function find()
    {
        return parent::find()->joinWith('product')->andWhere(['telegram_bot.id' => Yii::$app->controller->module->bot->id])->andWhere(['product.id' => Yii::$app->request->get('product_id')]);
    }
}
