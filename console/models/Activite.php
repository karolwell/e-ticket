<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "activite".
 *
 * @property integer $id
 * @property string $designation
 * @property string $description
 * @property integer $editeurId
 * @property integer $categorie_activiteId
 * @property string $lieu
 * @property string $datedebut
 * @property string $heuredebut
 * @property string $datefin
 * @property string $heurefin
 * @property string $reference
 * @property string $image
 * @property string $latitude
 * @property string $longitude
 * @property integer $etat
 * @property integer $created_by
 * @property string $date_create
 * @property integer $updated_by
 * @property string $date_update
 *
 * @property User $editeur
 * @property CategorieActivite $categorieActivite
 * @property User $createdBy
 * @property User $updatedBy
 * @property Ticket[] $tickets
 * @property TopEvenement[] $topEvenements
 */
class Activite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation', 'editeurId', 'categorie_activiteId', 'reference', 'image', 'etat', 'created_by', 'date_create'], 'required'],
            [['editeurId', 'categorie_activiteId', 'etat', 'created_by', 'updated_by'], 'integer'],
            [['datedebut', 'heuredebut', 'datefin', 'heurefin', 'date_create', 'date_update'], 'safe'],
            [['designation', 'description', 'lieu', 'reference', 'image', 'latitude', 'longitude'], 'string', 'max' => 255],
            [['editeurId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['editeurId' => 'id']],
            [['categorie_activiteId'], 'exist', 'skipOnError' => true, 'targetClass' => CategorieActivite::className(), 'targetAttribute' => ['categorie_activiteId' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'designation' => 'Designation',
            'description' => 'Description',
            'editeurId' => 'Editeur ID',
            'categorie_activiteId' => 'Categorie Activite ID',
            'lieu' => 'Lieu',
            'datedebut' => 'Datedebut',
            'heuredebut' => 'Heuredebut',
            'datefin' => 'Datefin',
            'heurefin' => 'Heurefin',
            'reference' => 'Reference',
            'image' => 'Image',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'etat' => 'Etat',
            'created_by' => 'Created By',
            'date_create' => 'Date Create',
            'updated_by' => 'Updated By',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditeur()
    {
        return $this->hasOne(User::className(), ['id' => 'editeurId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorieActivite()
    {
        return $this->hasOne(CategorieActivite::className(), ['id' => 'categorie_activiteId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['activiteId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopEvenements()
    {
        return $this->hasMany(TopEvenement::className(), ['activiteId' => 'id']);
    }
}
