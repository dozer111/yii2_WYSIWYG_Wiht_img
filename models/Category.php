<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $category_name
 * @property int $category_parent
 * @property string $category_image
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['category_parent'], 'integer'],
            [['category_name', 'category_image'], 'string', 'max' => 255],
            ['category_test','safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'category_parent' => 'Category Parent',
            'category_image' => 'Category Image',
        ];
    }
}
