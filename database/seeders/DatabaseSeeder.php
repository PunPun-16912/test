<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Transaction::factory()->count(40)->create();
    }
}

