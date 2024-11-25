<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $authorId
 * @property string $title
 * @property string $prewie
 * @property string $description
 * @property int $categoryId
 * @property int $statusId
 *
 * @property User $author
 * @property Category $category
 * @property Status $status
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authorId', 'title', 'prewie', 'description', 'categoryId', 'statusId'], 'required'],
            [['authorId', 'categoryId', 'statusId'], 'integer'],
            [['title', 'prewie', 'description'], 'string', 'max' => 255],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['authorId' => 'id']],
            [['statusId'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['statusId' => 'id']],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['categoryId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'authorId' => 'Author ID',
            'title' => 'Title',
            'prewie' => 'Prewie',
            'description' => 'Description',
            'categoryId' => 'Category ID',
            'statusId' => 'Status ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'authorId']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'categoryId']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'statusId']);
    }
}
