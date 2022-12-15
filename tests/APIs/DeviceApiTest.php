<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\Device;

class DeviceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_device()
    {
        $device = Device::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/devices', $device
        );

        $this->assertApiResponse($device);
    }

    /**
     * @test
     */
    public function test_read_device()
    {
        $device = Device::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/devices/'.$device->id
        );

        $this->assertApiResponse($device->toArray());
    }

    /**
     * @test
     */
    public function test_update_device()
    {
        $device = Device::factory()->create();
        $editedDevice = Device::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/devices/'.$device->id,
            $editedDevice
        );

        $this->assertApiResponse($editedDevice);
    }

    /**
     * @test
     */
    public function test_delete_device()
    {
        $device = Device::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/devices/'.$device->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/devices/'.$device->id
        );

        $this->response->assertStatus(404);
    }
}
