<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function up(): void
    {
        if ($this->hasTable('users')) {
            $this->table('users')->drop()->save();
        }

        $t = $this->table('users', ['id' => false, 'primary_key' => ['id']]);
        $t->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('password_hash', 'string', ['limit' => 255])
            ->addColumn('is_admin', 'boolean', ['default' => false])
            ->addIndex(['email'], ['unique' => true, 'name' => 'uniq_email'])
            ->create();
    }

    public function down(): void
    {
        if ($this->hasTable('users')) {
            $this->table('users')->drop()->save();
        }
    }
}
