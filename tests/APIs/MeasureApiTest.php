<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Frontend\Measure;

class MeasureApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_measure()
    {
        $measure = Measure::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/frontend/measures', $measure
        );

        $this->assertApiResponse($measure);
    }

    /**
     * @test
     */
    public function test_read_measure()
    {
        $measure = Measure::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/frontend/measures/'.$measure->id
        );

        $this->assertApiResponse($measure->toArray());
    }

    /**
     * @test
     */
    public function test_update_measure()
    {
        $measure = Measure::factory()->create();
        $editedMeasure = Measure::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/frontend/measures/'.$measure->id,
            $editedMeasure
        );

        $this->assertApiResponse($editedMeasure);
    }

    /**
     * @test
     */
    public function test_delete_measure()
    {
        $measure = Measure::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/frontend/measures/'.$measure->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/frontend/measures/'.$measure->id
        );

        $this->response->assertStatus(404);
    }
}
