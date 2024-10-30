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
        Account::create([
            'id' => '7557f6da-61f7-4e9c-8479-88aa52ed2050',
            'balance' => 99999,
        ]);
        Account::create([
            'id' => '68c2c56d-8310-4628-b886-a82fccc289f5',
            'balance' => 99999,
        ]);
        for ($i = 0; $i < 10; $i++) {
            Account::create([
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'balance' => rand(100, 99999) / 10,
            ]);
        }
    }
}
