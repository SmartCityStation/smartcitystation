<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\Area;

class AreaApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_area()
    {
        $area = Area::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/areas', $area
        );

        $this->assertApiResponse($area);
    }

    /**
     * @test
     */
    public function test_read_area()
    {
        $area = Area::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/areas/'.$area->id
        );

        $this->assertApiResponse($area->toArray());
    }

    /**
     * @test
     */
    public function test_update_area()
    {
        $area = Area::factory()->create();
        $editedArea = Area::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/areas/'.$area->id,
            $editedArea
        );

        $this->assertApiResponse($editedArea);
    }

    /**
     * @test
     */
    public function test_delete_area()
    {
        $area = Area::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/areas/'.$area->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/areas/'.$area->id
        );

        $this->response->assertStatus(404);
    }
}
