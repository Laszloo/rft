<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class UserSeed extends AbstractSeed
{
    public function run(): void
    {
        $users = [
            [
                'name'          => 'Admin',
                'email'         => 'admin@example.com',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'is_admin'      => true,
            ],
            [
                'name'          => 'Teszt Felhasználó',
                'email'         => 'user@example.com',
                'password_hash' => password_hash('user123', PASSWORD_BCRYPT),
                'is_admin'      => false,
            ],
        ];

        $this->table('users')->insert($users)->saveData();
    }
}
