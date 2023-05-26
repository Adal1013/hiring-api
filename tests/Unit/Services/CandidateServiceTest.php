<?php

namespace Tests\Unit\Services;

use App\Exceptions\GeneralException;
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
    public function test_get_all()
    {
        Candidate::factory(10)->create();
        $candidates = $this->candidateService->getAll();
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
        $user = User::factory()->create();
        $this->actingAs($user);
        $candidate = Candidate::factory()->create();
        $candidate->owner = $user->id;
        $candidate->save();
        $foundCandidate = $this->candidateService->getById($candidate->id);
        $this->assertEquals($candidate->id, $foundCandidate->id);
    }

    /**
     * A basic unit test example.
     *
     * @return voidhp
     */
    public function test_get_by_id_failed()
    {
        $this->expectException(GeneralException::class);
        $user = User::factory()->create();
        $user->removeRole('manager');
        $user->assignRole('agent');
        $this->actingAs($user);
        $user2 = User::factory()->create();
        $candidate = Candidate::factory()->create();
        $candidate->owner = $user2->id;
        $candidate->save();
        $this->candidateService->getById($candidate->id);
        //$this->assertEquals($candidate->id, $foundCandidate->id);
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
        $candidateData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => $owner->id,
            'createdBy' => $creator->id
        ];
        $newCandidate = $this->candidateService->create(CandidateData::from($candidateData));
        $this->assertInstanceOf(Candidate::class, $newCandidate);
    }
}
