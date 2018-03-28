<?php

use yii\db\Migration;

/**
 * Class m180327_164820_category
 */
class m180327_164820_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category',[
            'id'=>$this->primaryKey()->unsigned(),
            'category_name'=>$this->string(255)->notNull(),
            'category_parent'=>$this->integer()->defaultValue(0),
            'category_image'=>$this->string(255)->defaultValue('default.jpg')
        ]);
        $this->alterColumn('category','id',
            $this->integer(11)."NOT NULL AUTO_INCREMENT");


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       # echo "m180327_164820_category cannot be reverted.\n";
        $this->dropTable('category');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180327_164820_category cannot be reverted.\n";

        return false;
    }
    */
}
