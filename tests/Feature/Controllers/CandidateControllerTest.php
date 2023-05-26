<?php

namespace Tests\Feature\Controllers;

use App\Models\Candidate;
use App\Models\User;
use Database\Seeders\RoleTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleTableSeeder::class);
        $this->user = User::factory()->create();
        $credentials = [
            'username' => $this->user->username,
            'password' => 'hiring'
        ];
        $responseToken = $this->post('api/v1/auth', $credentials);
        $this->token = $responseToken->json()['data']['token'];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        Candidate::factory(10)->create();
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                     ->get('api/v1/auth/leads');
        $this->generalAsserts($response, 200);
        $this->successAsserts($response);
        $this->assertCount(10, $response->json()['data']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_failed()
    {
        Candidate::factory(10)->create();
        $response = $this->withHeader('Authorization', 'Bearer withoutToken')
                     ->get('api/v1/auth/leads');
        $this->generalAsserts($response, 401);
        $this->failedAsserts($response);
        $this->assertEquals('Token invalid.', $response->json()['meta']['errors'][0]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store()
    {
        $this->user->removeRole('agent');
        $this->user->assignRole('manager');
        $owner = User::factory()->create();
        $candidateData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => $owner->id
        ];
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                     ->post('api/v1/auth/lead', $candidateData);
        $this->generalAsserts($response, 201);
        $this->successAsserts($response);
        $this->assertEquals($candidateData['name'], $response->json()['data']['name']);
        $this->assertEquals($candidateData['source'], $response->json()['data']['source']);
        $this->assertEquals($candidateData['owner'], $response->json()['data']['owner']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_failed()
    {
        $owner = User::factory()->create();
        $candidateData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => $owner->id
        ];
        $response = $this->withHeader('Authorization', 'Bearer withoutToken')
                     ->post('api/v1/auth/lead', $candidateData);
        $this->generalAsserts($response, 401);
        $this->failedAsserts($response);
        $this->assertEquals('Token invalid.', $response->json()['meta']['errors'][0]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_failed_role()
    {
        $this->user->removeRole('manager');
        $this->user->assignRole('agent');
        $owner = User::factory()->create();
        $candidateData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => $owner->id
        ];
        $response = $this->withHeader('Authorization', 'Bearer '. $this->token)
                     ->post('api/v1/auth/lead', $candidateData);
        $this->generalAsserts($response, 401);
        $this->failedAsserts($response);
        $this->assertEquals('Unauthorized.', $response->json()['meta']['errors'][0]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show()
    {
        $candidate = Candidate::factory()->create();
        $candidate->owner = $this->user->id;
        $candidate->save();
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                     ->get("api/v1/auth/lead/{$candidate->id}");
        $this->generalAsserts($response, 200);
        $this->successAsserts($response);
        $this->assertEquals($candidate->name, $response->json()['data']['name']);
        $this->assertEquals($candidate->source, $response->json()['data']['source']);
        $this->assertEquals($candidate->owner, $response->json()['data']['owner']);
        $this->assertEquals($candidate->created_by, $response->json()['data']['created_by']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_failed()
    {
        $candidate = Candidate::factory()->create();
        $response = $this->withHeader('Authorization', 'Bearer withoutToken')
                     ->get("api/v1/auth/lead/{$candidate->id}");
        $this->generalAsserts($response, 401);
        $this->failedAsserts($response);
        $this->assertEquals('Token invalid.', $response->json()['meta']['errors'][0]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_failed_role()
    {
        $this->user->removeRole('manager');
        $this->user->assignRole('agent');
        $user = User::factory()->create();
        $candidate = Candidate::factory()->create();
        $candidate->owner = $user->id;
        $candidate->save();
        $response = $this->withHeader('Authorization', 'Bearer withoutToken')
                     ->get("api/v1/auth/lead/{$candidate->id}");
        $this->generalAsserts($response, 401);
        $this->failedAsserts($response);
        $this->assertEquals('Token invalid.', $response->json()['meta']['errors'][0]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_not_exist()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
                     ->get("api/v1/auth/lead/50");
        $this->generalAsserts($response, 404);
        $this->failedAsserts($response);
        $this->assertEquals('No lead found.', $response->json()['meta']['errors'][0]);
    }

    /**
     * @param $response
     * @param int $codeToValidate
     * @return void
     */
    private function generalAsserts($response, int $codeToValidate): void
    {
        $response->assertStatus($codeToValidate);
        $this->assertArrayHasKey('meta', $response->json());
        $this->assertIsBool($response->json()['meta']['success']);
    }

    /**
     * @param $response
     * @return void
     */
    private function successAsserts($response): void
    {
        $this->assertArrayHasKey('data', $response->json());
        $this->assertIsArray($response->json()['data']);
    }

    /**
     * @param $response
     * @return void
     */
    private function failedAsserts($response): void
    {
        $this->assertArrayNotHasKey('data', $response->json());
        $this->assertFalse($response->json()['meta']['success']);
        $this->assertIsArray($response->json()['meta']['errors']);
    }
}
