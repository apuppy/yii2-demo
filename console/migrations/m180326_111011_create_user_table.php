<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180326_111011_create_user_table extends Migration
{
    // changed table name to users

    /**
     * @inheritdoc
     */
    public function up()
    {
        $table_options = "ENGINE = InnoDB DEFAULT CHARSET = utf8 COMMENT '用户表'";
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string(16)->notNull()->defaultValue('')->comment('姓名'),
            'sex' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(0)->comment('性别 0:未知 1：男 2：女'),
            'age' => $this->smallInteger(3)->unsigned()->notNull()->defaultValue(0)->comment('年龄'),
            'birthday' => $this->date()->notNull()->defaultValue('0000-00-00')->comment('生日'),
            'tel' => $this->char(15)->notNull()->defaultValue('')->comment('电话号码'),
            'created_at' => 'DATETIME NOT NULL DEFAULT current_timestamp()',
            'updated_at' => 'DATETIME NOT NULL DEFAULT current_timestamp()'
        ],$table_options);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
