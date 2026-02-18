<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%loan_request}}`.
 */
class m260218_112941_create_loan_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%loan_request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(12, 2)->notNull(),
            'term' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-loan_request-user_id', '{{%loan_request}}', 'user_id');
        $this->createIndex('idx-loan_request-status', '{{%loan_request}}', 'status');

        $tableName = $this->db->getSchema()->getRawTableName('{{%loan_request}}');
        $this->execute("CREATE UNIQUE INDEX uniq_loan_request_one_approved_per_user ON {$tableName} (user_id) WHERE status = 2");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('uniq_loan_request_one_approved_per_user', '{{%loan_request}}');
        $this->dropTable('{{%loan_request}}');
    }
}
