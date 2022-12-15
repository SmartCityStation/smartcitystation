<?php namespace Tests\Repositories;

use App\Models\Frontend\Measure;
use App\Repositories\Frontend\MeasureRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class MeasureRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var MeasureRepository
     */
    protected $measureRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->measureRepo = \App::make(MeasureRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_measure()
    {
        $measure = Measure::factory()->make()->toArray();

        $createdMeasure = $this->measureRepo->create($measure);

        $createdMeasure = $createdMeasure->toArray();
        $this->assertArrayHasKey('id', $createdMeasure);
        $this->assertNotNull($createdMeasure['id'], 'Created Measure must have id specified');
        $this->assertNotNull(Measure::find($createdMeasure['id']), 'Measure with given id must be in DB');
        $this->assertModelData($measure, $createdMeasure);
    }

    /**
     * @test read
     */
    public function test_read_measure()
    {
        $measure = Measure::factory()->create();

        $dbMeasure = $this->measureRepo->find($measure->id);

        $dbMeasure = $dbMeasure->toArray();
        $this->assertModelData($measure->toArray(), $dbMeasure);
    }

    /**
     * @test update
     */
    public function test_update_measure()
    {
        $measure = Measure::factory()->create();
        $fakeMeasure = Measure::factory()->make()->toArray();

        $updatedMeasure = $this->measureRepo->update($fakeMeasure, $measure->id);

        $this->assertModelData($fakeMeasure, $updatedMeasure->toArray());
        $dbMeasure = $this->measureRepo->find($measure->id);
        $this->assertModelData($fakeMeasure, $dbMeasure->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_measure()
    {
        $measure = Measure::factory()->create();

        $resp = $this->measureRepo->delete($measure->id);

        $this->assertTrue($resp);
        $this->assertNull(Measure::find($measure->id), 'Measure should not exist in DB');
    }
}
