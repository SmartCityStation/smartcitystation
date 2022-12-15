<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\VariableDevice;

class VariableDeviceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_variable_device()
    {
        $variableDevice = VariableDevice::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/variable_devices', $variableDevice
        );

        $this->assertApiResponse($variableDevice);
    }

    /**
     * @test
     */
    public function test_read_variable_device()
    {
        $variableDevice = VariableDevice::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/variable_devices/'.$variableDevice->id
        );

        $this->assertApiResponse($variableDevice->toArray());
    }

    /**
     * @test
     */
    public function test_update_variable_device()
    {
        $variableDevice = VariableDevice::factory()->create();
        $editedVariableDevice = VariableDevice::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/variable_devices/'.$variableDevice->id,
            $editedVariableDevice
        );

        $this->assertApiResponse($editedVariableDevice);
    }

    /**
     * @test
     */
    public function test_delete_variable_device()
    {
        $variableDevice = VariableDevice::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/variable_devices/'.$variableDevice->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/variable_devices/'.$variableDevice->id
        );

        $this->response->assertStatus(404);
    }
}
