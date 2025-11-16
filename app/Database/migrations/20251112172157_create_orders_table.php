<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateOrdersTable extends AbstractMigration
{
    public function up(): void
    {
        if ($this->hasTable('orders')) {
            $this->table('orders')->drop()->save();
        }

        $t = $this->table('orders', ['id' => false, 'primary_key' => ['id']]);
        $t->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('user_id', 'integer', ['signed' => false])
            ->addColumn('order_number', 'string', ['limit' => 32])
            ->addColumn('status', 'enum', [
                'values'  => [array_keys(\App\Config\Application::STATUS)],
                'default' => 'folyamatban',
            ])
            ->addColumn('total_gross', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => true, 'default' => null])

            ->addIndex(['order_number'], ['unique' => true, 'name' => 'uniq_order_number'])

            ->create();

        $this->table('orders')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                ['delete' => 'SET_NULL', 'update' => 'CASCADE', 'constraint' => 'fk_orders_user']
            )
            ->update();
    }

    public function down(): void
    {
        if ($this->hasTable('orders')) {
            $this->table('orders')->drop()->save();
        }
    }
}
