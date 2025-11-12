<?php
declare(strict_types=1);


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateBooksTable extends AbstractMigration
{
    public function up(): void
    {
        if ($this->hasTable('books')) {
            $this->table('books')->drop()->save();
        }

        $t = $this->table('books', ['id' => false, 'primary_key' => ['id']]);
        $t->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('author', 'string', ['limit' => 255])
            ->addColumn('published_year', 'integer', [
                'null'  => true,
                'limit' => MysqlAdapter::INT_SMALL
            ])
            ->addColumn('isbn', 'string', ['null' => true, 'limit' => 32])
            ->addColumn('image_url', 'string', ['null' => true, 'limit' => 512])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('stock', 'integer', ['default' => 0])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('deleted_at', 'datetime', ['null' => true, 'default' => null])
            ->create();
    }

    public function down(): void
    {
        if ($this->hasTable('books')) {
            $this->table('books')->drop()->save();
        }
    }
}
