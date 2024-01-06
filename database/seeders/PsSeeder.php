<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     User::create([
    //         'name' => 'ps',
    //         'email' => 'pembimbing_siswa@gmail.com',
    //         'password' => Hash::make('pembimbing'),
    //         'role' => 'ps',
    //     ]);
    // }
    public function run()
    {
        $user = User::where('email', 'pembimbing_siswa@gmail.com')->first();
    
        if (!$user) {
            User::create([
                'name' => 'ps',
                'email' => 'pembimbing_siswa@gmail.com',
                'password' => Hash::make('pembimbing'),
                'role' => 'ps',
            ]);
        } else {
            // Jika user dengan email tersebut sudah ada, pastikan rolenya 'ps'
            if ($user->role !== 'ps') {
                $user->role = 'ps';
                $user->save();
            }
        }
    }
    

}
