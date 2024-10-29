<?php

declare(strict_types=1);

use App\Model\Account;
use Hyperf\Database\Seeders\Seeder;

class Accounts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Account::create([
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'balance' => rand(100, 99999) / 10,
            ]);
        }
    }
}
