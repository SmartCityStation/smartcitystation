<?php namespace Tests\Repositories;

use App\Models\Backend\Device;
use App\Repositories\Backend\DeviceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DeviceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DeviceRepository
     */
    protected $deviceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->deviceRepo = \App::make(DeviceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_device()
    {
        $device = Device::factory()->make()->toArray();

        $createdDevice = $this->deviceRepo->create($device);

        $createdDevice = $createdDevice->toArray();
        $this->assertArrayHasKey('id', $createdDevice);
        $this->assertNotNull($createdDevice['id'], 'Created Device must have id specified');
        $this->assertNotNull(Device::find($createdDevice['id']), 'Device with given id must be in DB');
        $this->assertModelData($device, $createdDevice);
    }

    /**
     * @test read
     */
    public function test_read_device()
    {
        $device = Device::factory()->create();

        $dbDevice = $this->deviceRepo->find($device->id);

        $dbDevice = $dbDevice->toArray();
        $this->assertModelData($device->toArray(), $dbDevice);
    }

    /**
     * @test update
     */
    public function test_update_device()
    {
        $device = Device::factory()->create();
        $fakeDevice = Device::factory()->make()->toArray();

        $updatedDevice = $this->deviceRepo->update($fakeDevice, $device->id);

        $this->assertModelData($fakeDevice, $updatedDevice->toArray());
        $dbDevice = $this->deviceRepo->find($device->id);
        $this->assertModelData($fakeDevice, $dbDevice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_device()
    {
        $device = Device::factory()->create();

        $resp = $this->deviceRepo->delete($device->id);

        $this->assertTrue($resp);
        $this->assertNull(Device::find($device->id), 'Device should not exist in DB');
    }
}
