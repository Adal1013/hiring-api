<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\User;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creator = User::where('username', 'adal123')->first();
        $owner = User::where('username', 'jose123')->first();
        $candidates = [
            [
                'name' => 'David Fernandez',
                'source' => 'Linkedin',
                'owner' => $owner->id,
                'created_by' => $creator->id,
            ],
            [
                'name' => 'Maria Gonzales',
                'source' => 'Indeed',
                'owner' => $owner->id,
                'created_by' => $creator->id,
            ],
            [
                'name' => 'Juan Ariza',
                'source' => 'Computrabajo',
                'owner' => $creator->id,
                'created_by' => $creator->id,
            ],
        ];
        foreach ($candidates as $candidate) {
            Candidate::create($candidate);
        }
    }
}
