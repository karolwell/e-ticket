<?php

namespace frontend\modules\impression\models;

use Yii;

/**
 * This is the model class for table "validation".
 *
 * @property integer $id
 * @property integer $achat_detailsId
 * @property integer $validated_by
 * @property string $date_validation
 *
 * @property AchatDetails $achatDetails
 * @property User $validatedBy
 */
class Validation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'validation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['achat_detailsId', 'validated_by', 'date_validation'], 'required'],
            [['achat_detailsId', 'validated_by'], 'integer'],
            [['date_validation'], 'safe'],
            [['achat_detailsId'], 'exist', 'skipOnError' => true, 'targetClass' => AchatDetails::className(), 'targetAttribute' => ['achat_detailsId' => 'id']],
            [['validated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['validated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'achat_detailsId' => 'Achat Details ID',
            'validated_by' => 'Validated By',
            'date_validation' => 'Date Validation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAchatDetails()
    {
        return $this->hasOne(AchatDetails::className(), ['id' => 'achat_detailsId'])->inverseOf('validations');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValidatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'validated_by'])->inverseOf('validations');
    }
}
