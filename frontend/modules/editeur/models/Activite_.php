<?php

namespace frontend\modules\editeur\models;

use yii\web\UploadedFile;
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
 */ 
class Activite extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 4;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activite';
    }

    /**
     * @var UploadedFile
    */
    public $imageFile;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation', 'lieu', 'datedebut', 'heuredebut', 'datefin', 'heurefin', 'description', 'editeurId', 'categorie_activiteId', 'reference', 'image', 'etat', 'created_by', 'date_create'], 'required'],
            [['editeurId', 'categorie_activiteId', 'etat', 'created_by', 'updated_by'], 'integer'],
            [['date', 'heure', 'date_create', 'date_update'], 'safe'],
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
            'date' => 'Date',
            'heure' => 'Heure',
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

    public function upload()
    {
        if ($this->validate()) {
            //print_r( $this->imageFile);exit;
            $this->imageFile->saveAs('images/activites/'. $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->imageFile = null; 
           // $model->save(false);
            return true;
        } else {
            //print_r($this->getErrors());
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditeur()
    {
        return $this->hasOne(User::className(), ['id' => 'editeurId'])->inverseOf('activites');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorieActivite()
    {
        return $this->hasOne(CategorieActivite::className(), ['id' => 'categorie_activiteId'])->inverseOf('activites');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->inverseOf('activites0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->inverseOf('activites1');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['activiteId' => 'id'])->inverseOf('activite');
    }
}
