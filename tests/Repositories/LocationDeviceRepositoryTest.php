<?php namespace Tests\Repositories;

use App\Models\Backend\LocationDevice;
use App\Repositories\Backend\LocationDeviceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LocationDeviceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LocationDeviceRepository
     */
    protected $locationDeviceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->locationDeviceRepo = \App::make(LocationDeviceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_location_device()
    {
        $locationDevice = LocationDevice::factory()->make()->toArray();

        $createdLocationDevice = $this->locationDeviceRepo->create($locationDevice);

        $createdLocationDevice = $createdLocationDevice->toArray();
        $this->assertArrayHasKey('id', $createdLocationDevice);
        $this->assertNotNull($createdLocationDevice['id'], 'Created LocationDevice must have id specified');
        $this->assertNotNull(LocationDevice::find($createdLocationDevice['id']), 'LocationDevice with given id must be in DB');
        $this->assertModelData($locationDevice, $createdLocationDevice);
    }

    /**
     * @test read
     */
    public function test_read_location_device()
    {
        $locationDevice = LocationDevice::factory()->create();

        $dbLocationDevice = $this->locationDeviceRepo->find($locationDevice->id);

        $dbLocationDevice = $dbLocationDevice->toArray();
        $this->assertModelData($locationDevice->toArray(), $dbLocationDevice);
    }

    /**
     * @test update
     */
    public function test_update_location_device()
    {
        $locationDevice = LocationDevice::factory()->create();
        $fakeLocationDevice = LocationDevice::factory()->make()->toArray();

        $updatedLocationDevice = $this->locationDeviceRepo->update($fakeLocationDevice, $locationDevice->id);

        $this->assertModelData($fakeLocationDevice, $updatedLocationDevice->toArray());
        $dbLocationDevice = $this->locationDeviceRepo->find($locationDevice->id);
        $this->assertModelData($fakeLocationDevice, $dbLocationDevice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_location_device()
    {
        $locationDevice = LocationDevice::factory()->create();

        $resp = $this->locationDeviceRepo->delete($locationDevice->id);

        $this->assertTrue($resp);
        $this->assertNull(LocationDevice::find($locationDevice->id), 'LocationDevice should not exist in DB');
    }
}
