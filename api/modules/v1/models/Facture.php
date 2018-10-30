<?php

namespace api\modules\v1\models;


class Facture extends \yii\db\ActiveRecord
{
       /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config_facturier';
    }
}
