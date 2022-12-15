<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\LocationDevice;

class LocationDeviceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_location_device()
    {
        $locationDevice = LocationDevice::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/location_devices', $locationDevice
        );

        $this->assertApiResponse($locationDevice);
    }

    /**
     * @test
     */
    public function test_read_location_device()
    {
        $locationDevice = LocationDevice::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/location_devices/'.$locationDevice->id
        );

        $this->assertApiResponse($locationDevice->toArray());
    }

    /**
     * @test
     */
    public function test_update_location_device()
    {
        $locationDevice = LocationDevice::factory()->create();
        $editedLocationDevice = LocationDevice::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/location_devices/'.$locationDevice->id,
            $editedLocationDevice
        );

        $this->assertApiResponse($editedLocationDevice);
    }

    /**
     * @test
     */
    public function test_delete_location_device()
    {
        $locationDevice = LocationDevice::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/location_devices/'.$locationDevice->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/location_devices/'.$locationDevice->id
        );

        $this->response->assertStatus(404);
    }
}
