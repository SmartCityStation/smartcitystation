<?php namespace Tests\Repositories;

use App\Models\Backend\Village;
use App\Repositories\Backend\VillageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VillageRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VillageRepository
     */
    protected $villageRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->villageRepo = \App::make(VillageRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_village()
    {
        $village = Village::factory()->make()->toArray();

        $createdVillage = $this->villageRepo->create($village);

        $createdVillage = $createdVillage->toArray();
        $this->assertArrayHasKey('id', $createdVillage);
        $this->assertNotNull($createdVillage['id'], 'Created Village must have id specified');
        $this->assertNotNull(Village::find($createdVillage['id']), 'Village with given id must be in DB');
        $this->assertModelData($village, $createdVillage);
    }

    /**
     * @test read
     */
    public function test_read_village()
    {
        $village = Village::factory()->create();

        $dbVillage = $this->villageRepo->find($village->id);

        $dbVillage = $dbVillage->toArray();
        $this->assertModelData($village->toArray(), $dbVillage);
    }

    /**
     * @test update
     */
    public function test_update_village()
    {
        $village = Village::factory()->create();
        $fakeVillage = Village::factory()->make()->toArray();

        $updatedVillage = $this->villageRepo->update($fakeVillage, $village->id);

        $this->assertModelData($fakeVillage, $updatedVillage->toArray());
        $dbVillage = $this->villageRepo->find($village->id);
        $this->assertModelData($fakeVillage, $dbVillage->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_village()
    {
        $village = Village::factory()->create();

        $resp = $this->villageRepo->delete($village->id);

        $this->assertTrue($resp);
        $this->assertNull(Village::find($village->id), 'Village should not exist in DB');
    }
}
