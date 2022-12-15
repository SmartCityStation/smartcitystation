<?php namespace Tests\Repositories;

use App\Models\Backend\VariableDevice;
use App\Repositories\Backend\VariableDeviceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VariableDeviceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VariableDeviceRepository
     */
    protected $variableDeviceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->variableDeviceRepo = \App::make(VariableDeviceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_variable_device()
    {
        $variableDevice = VariableDevice::factory()->make()->toArray();

        $createdVariableDevice = $this->variableDeviceRepo->create($variableDevice);

        $createdVariableDevice = $createdVariableDevice->toArray();
        $this->assertArrayHasKey('id', $createdVariableDevice);
        $this->assertNotNull($createdVariableDevice['id'], 'Created VariableDevice must have id specified');
        $this->assertNotNull(VariableDevice::find($createdVariableDevice['id']), 'VariableDevice with given id must be in DB');
        $this->assertModelData($variableDevice, $createdVariableDevice);
    }

    /**
     * @test read
     */
    public function test_read_variable_device()
    {
        $variableDevice = VariableDevice::factory()->create();

        $dbVariableDevice = $this->variableDeviceRepo->find($variableDevice->id);

        $dbVariableDevice = $dbVariableDevice->toArray();
        $this->assertModelData($variableDevice->toArray(), $dbVariableDevice);
    }

    /**
     * @test update
     */
    public function test_update_variable_device()
    {
        $variableDevice = VariableDevice::factory()->create();
        $fakeVariableDevice = VariableDevice::factory()->make()->toArray();

        $updatedVariableDevice = $this->variableDeviceRepo->update($fakeVariableDevice, $variableDevice->id);

        $this->assertModelData($fakeVariableDevice, $updatedVariableDevice->toArray());
        $dbVariableDevice = $this->variableDeviceRepo->find($variableDevice->id);
        $this->assertModelData($fakeVariableDevice, $dbVariableDevice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_variable_device()
    {
        $variableDevice = VariableDevice::factory()->create();

        $resp = $this->variableDeviceRepo->delete($variableDevice->id);

        $this->assertTrue($resp);
        $this->assertNull(VariableDevice::find($variableDevice->id), 'VariableDevice should not exist in DB');
    }
}
