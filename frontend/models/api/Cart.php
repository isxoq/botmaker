<?php

namespace frontend\models\api;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int|null $bot_id
 * @property int|null $bot_user_id
 * @property int|null $product_id
 * @property int|null $product_variant_id
 * @property int|null $price
 * @property int|null $quantity
 *
 * @property TelegramBot $bot
 * @property Product $product
 * @property ProductVariant $productVariant
 * @property BotUser $botUser
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_id', 'bot_user_id', 'product_id', 'product_variant_id', 'price', 'quantity'], 'integer'],
            [['bot_id'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramBot::className(), 'targetAttribute' => ['bot_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['product_variant_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductVariant::className(), 'targetAttribute' => ['product_variant_id' => 'id']],
            [['bot_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => BotUser::className(), 'targetAttribute' => ['bot_user_id' => 'id']],
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
            'bot_user_id' => Yii::t('app', 'Bot User ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'product_variant_id' => Yii::t('app', 'Product Variant ID'),
            'price' => Yii::t('app', 'Price'),
            'quantity' => Yii::t('app', 'Quantity'),
        ];
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

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Gets query for [[ProductVariant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariant()
    {
        return $this->hasOne(ProductVariant::className(), ['id' => 'product_variant_id']);
    }

    /**
     * Gets query for [[BotUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBotUser()
    {
        return $this->hasOne(BotUser::className(), ['id' => 'bot_user_id']);
    }
}
