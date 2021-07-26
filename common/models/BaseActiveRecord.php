<?php

namespace common\models;
/*
Project Name: botmaker.loc
File Name: BaseModel.php
Full Name: Isxoqjon Axmedov
Phone:     +998936448111
Site:      ninja.uz
Date Time: 7/26/2021 11:19 AM
*/

use yii\web\NotFoundHttpException;

class BaseActiveRecord extends \yii\db\ActiveRecord
{

    /**
     * @param $condition
     * @throws NotFoundHttpException
     */
    public static function findOrFail($condition)
    {
        $model = self::findOne($condition);
        if ($model) {
            return $model;
        } else {
            notFound();
        }

    }
}