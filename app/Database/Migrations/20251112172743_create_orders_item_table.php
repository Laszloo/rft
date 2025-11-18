<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateOrdersItemTable extends AbstractMigration
{
    public function up(): void
    {
        if ($this->hasTable('order_items')) {
            $this->table('order_items')->drop()->save();
        }

        $this->table('order_items')
            ->addColumn('order_id', 'integer', ['signed' => false])
            ->addColumn('book_id', 'integer', ['signed' => false])
            ->addColumn('qty', 'integer', ['default' => 1])
            ->addColumn('unit_price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('line_total', 'decimal', ['precision' => 10, 'scale' => 2])

            ->addIndex(['order_id', 'book_id'], ['unique' => true, 'name' => 'uniq_order_item'])

            ->create();

        $this->table('order_items')
            ->addForeignKey(
                'order_id',
                'orders',
                'id',
                ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_oi_order']
            )
            ->addForeignKey(
                'book_id',
                'books',
                'id',
                ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_oi_book']
            )
            ->update();
    }

    public function down(): void
    {
        if ($this->hasTable('order_items')) {
            $this->table('order_items')->drop()->save();
        }
    }
}
