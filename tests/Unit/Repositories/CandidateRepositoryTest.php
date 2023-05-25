<?php

namespace Tests\Unit\Repositories;

use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Http\Repositories\Candidates\CandidateRepository;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RoleTableSeeder;

class CandidateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected CandidateRepository $candidateRepository;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->candidateRepository = app(CandidateRepository::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_by_id()
    {
        $this->seed(RoleTableSeeder::class);
        $candidate = Candidate::factory()->create();
        $foundCandidate = $this->candidateRepository->getById($candidate->id);
        $this->assertEquals($candidate->id, $foundCandidate->id);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_save()
    {
        $this->seed(RoleTableSeeder::class);
        $creator = User::factory()->create();
        $owner = User::factory()->create();
        $cadidateData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => $owner->id,
            'createdBy' => $creator->id
        ];
        $newCandidate = $this->candidateRepository->save(CandidateData::from($cadidateData));
        $this->assertInstanceOf(Candidate::class, $newCandidate);
    }
}
