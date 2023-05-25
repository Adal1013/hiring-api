<?php

namespace Tests\Unit\Services;

use App\Http\DataTransferObjects\Candidates\CandidateData;
use App\Http\Services\Candidates\CandidateService;
use App\Models\Candidate;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CandidateService $candidateService;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->candidateService = app(CandidateService::class);
        $this->seed(RoleTableSeeder::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_by_id()
    {
        $candidate = Candidate::factory()->create();
        $foundCandidate = $this->candidateService->getById($candidate->id);
        $this->assertEquals($candidate->id, $foundCandidate->id);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create()
    {
        $creator = User::factory()->create();
        $owner = User::factory()->create();
        $cadidateData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => $owner->id,
            'createdBy' => $creator->id
        ];
        $newCandidate = $this->candidateService->create(CandidateData::from($cadidateData));
        $this->assertInstanceOf(Candidate::class, $newCandidate);
    }
}
