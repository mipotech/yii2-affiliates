<?php

use yii\db\Migration;

class m170820_080535_create_affiliate_statistic_data extends Migration
{
        /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('affiliate_statistic_data', [
        	'id' => $this->bigPrimaryKey(),
            'aff_id' => $this->string(200)->notNull(),
            'camp_id' => $this->string(200),
            'url' => $this->string(1000)->notNull(),
            'ip' => $this->string(200)->notNull(),
            'type' => $this->integer(),
            'created_at' => $this->integer(),
            'price' => $this->integer(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            'idx-affiliate_statistic_data-aff_id',
            'affiliate_statistic_data',
            'aff_id'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops index for column `post_id`
        $this->dropIndex(
            'idx-affiliate_statistic_data-aff_id',
            'affiliate_statistic_data'
        );

        $this->dropTable('affiliate_statistic_data');
    }
}
