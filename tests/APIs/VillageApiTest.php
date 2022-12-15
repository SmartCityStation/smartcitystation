<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\Village;

class VillageApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_village()
    {
        $village = Village::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/villages', $village
        );

        $this->assertApiResponse($village);
    }

    /**
     * @test
     */
    public function test_read_village()
    {
        $village = Village::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/villages/'.$village->id
        );

        $this->assertApiResponse($village->toArray());
    }

    /**
     * @test
     */
    public function test_update_village()
    {
        $village = Village::factory()->create();
        $editedVillage = Village::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/villages/'.$village->id,
            $editedVillage
        );

        $this->assertApiResponse($editedVillage);
    }

    /**
     * @test
     */
    public function test_delete_village()
    {
        $village = Village::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/villages/'.$village->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/villages/'.$village->id
        );

        $this->response->assertStatus(404);
    }
}
