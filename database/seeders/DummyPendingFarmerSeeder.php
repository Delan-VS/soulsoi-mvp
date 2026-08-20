<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Farmer;
use Illuminate\Support\Facades\Hash;

class DummyPendingFarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = ['Kottayam', 'Ernakulam', 'Alappuzha', 'Kollam', 'Idukki', 'Malappuram', 'Kozhikode', 'Kannur'];
        for ($i = 1; $i <= 5; $i++) {
            $userPending = User::create([
                'name' => 'Pending Farmer ' . time() . $i,
                'email' => 'pending.farmer' . time() . $i . '@example.com',
                'phone' => '+91 94470 ' . sprintf('%05d', rand(10000, 99999)),
                'password' => Hash::make('password'),
            ]);
            Farmer::create([
                'user_id' => $userPending->id,
                'full_name' => 'Pending Farmer ' . $i,
                'dob' => '1980-01-01',
                'aadhar_number' => '111122223333',
                'address' => 'Address ' . $i,
                'village' => 'Village ' . $i,
                'district' => $districts[array_rand($districts)],
                'state' => 'Kerala',
                'bank_name' => 'State Bank of India',
                'account_holder_name' => 'Pending Farmer ' . $i,
                'account_number' => '500123456' . $i,
                'ifsc_code' => 'SBIN0001234',
                'face_verification' => rand(0,1) ? 'completed' : 'pending',
                'mobile_verification' => 'completed',
                'bank_verification' => rand(0,1) ? 'completed' : 'pending',
                'document_verification' => 'pending',
                'overall_status' => 'pending',
            ]);
        }
    }
}
