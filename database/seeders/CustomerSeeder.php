<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Customer::factory()
            ->count(25)
            ->hasInvoices(10, ['user_id' => 1])
            ->create();

        Customer::factory()
            ->count(100)
            ->hasInvoices(5, ['user_id' => 2])
            ->create();

        Customer::factory()
            ->count(100)
            ->hasInvoices(3, ['user_id' => 2])
            ->create();

        Customer::factory()
            ->count(5)
            ->create();
    }
}
