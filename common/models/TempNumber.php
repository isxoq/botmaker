<?php

namespace common\models;

use cebe\markdown\block\TableTrait;
use Faker\Provider\Base;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "temp_number".
 *
 * @property int $id
 * @property string|null $phone
 * @property int|null $code
 * @property int|null $verify_code
 * @property string|null $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int|null $status
 * @property int|null $code_expire_at
 */
class TempNumber extends ActiveRecord
{

    public $verify_code;

    const SCENARIO_PHONE = 'scenario_phone';
    const SCENARIO_VERIFY_CODE = 'scenario_verify_code';

    public function scenarios(): array
    {
        return [
            self::SCENARIO_PHONE => ['phone'],
            self::SCENARIO_VERIFY_CODE => ['phone', 'verify_code'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'temp_number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phone', 'match', 'pattern' => "/\+998\(\d{2}\) \d{3}\-\d{2}\-\d{2}/"],
            ['phone', 'required'],
            ['verify_code', 'required'],
            [['code', 'verify_code', 'status', 'code_expire_at'], 'integer'],
            [['phone', 'password', 'first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', 'Phone'),
            'code' => Yii::t('app', 'Code'),
            'verify_code' => Yii::t('app', 'Verify Code'),
            'password' => Yii::t('app', 'Password'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'status' => Yii::t('app', 'Status'),
            'code_expire_at' => Yii::t('app', 'Code Expire At'),
        ];
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return ($this->code_expire_at <= time());
    }

    /**
     * Kod generatsiya qilish
     * @throws \Exception
     */
    public function generateCode()
    {
        $this->code = random_int(12345, 12345);
        $this->code_expire_at = time() + 120;
    }

    public function verifyCode(): bool
    {
        return $this->code == intval($this->verify_code);
    }

}
