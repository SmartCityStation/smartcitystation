<?php namespace Tests\Repositories;

use App\Models\Backend\DataVariable;
use App\Repositories\Backend\DataVariableRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DataVariableRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DataVariableRepository
     */
    protected $dataVariableRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->dataVariableRepo = \App::make(DataVariableRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_data_variable()
    {
        $dataVariable = DataVariable::factory()->make()->toArray();

        $createdDataVariable = $this->dataVariableRepo->create($dataVariable);

        $createdDataVariable = $createdDataVariable->toArray();
        $this->assertArrayHasKey('id', $createdDataVariable);
        $this->assertNotNull($createdDataVariable['id'], 'Created DataVariable must have id specified');
        $this->assertNotNull(DataVariable::find($createdDataVariable['id']), 'DataVariable with given id must be in DB');
        $this->assertModelData($dataVariable, $createdDataVariable);
    }

    /**
     * @test read
     */
    public function test_read_data_variable()
    {
        $dataVariable = DataVariable::factory()->create();

        $dbDataVariable = $this->dataVariableRepo->find($dataVariable->id);

        $dbDataVariable = $dbDataVariable->toArray();
        $this->assertModelData($dataVariable->toArray(), $dbDataVariable);
    }

    /**
     * @test update
     */
    public function test_update_data_variable()
    {
        $dataVariable = DataVariable::factory()->create();
        $fakeDataVariable = DataVariable::factory()->make()->toArray();

        $updatedDataVariable = $this->dataVariableRepo->update($fakeDataVariable, $dataVariable->id);

        $this->assertModelData($fakeDataVariable, $updatedDataVariable->toArray());
        $dbDataVariable = $this->dataVariableRepo->find($dataVariable->id);
        $this->assertModelData($fakeDataVariable, $dbDataVariable->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_data_variable()
    {
        $dataVariable = DataVariable::factory()->create();

        $resp = $this->dataVariableRepo->delete($dataVariable->id);

        $this->assertTrue($resp);
        $this->assertNull(DataVariable::find($dataVariable->id), 'DataVariable should not exist in DB');
    }
}
