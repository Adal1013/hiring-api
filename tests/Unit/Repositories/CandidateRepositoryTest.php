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
        $this->seed(RoleTableSeeder::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_all()
    {
        Candidate::factory(10)->create();
        $candidates = $this->candidateRepository->getAll();
        $this->assertCount(10, $candidates);
        $this->assertContainsOnlyInstancesOf(Candidate::class, $candidates);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_by_id()
    {
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
