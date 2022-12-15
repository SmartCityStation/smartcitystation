<?php namespace Tests\Repositories;

use App\Models\Backend\Type_variable;
use App\Repositories\Backend\Type_variableRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class Type_variableRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var Type_variableRepository
     */
    protected $typeVariableRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->typeVariableRepo = \App::make(Type_variableRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_type_variable()
    {
        $typeVariable = Type_variable::factory()->make()->toArray();

        $createdType_variable = $this->typeVariableRepo->create($typeVariable);

        $createdType_variable = $createdType_variable->toArray();
        $this->assertArrayHasKey('id', $createdType_variable);
        $this->assertNotNull($createdType_variable['id'], 'Created Type_variable must have id specified');
        $this->assertNotNull(Type_variable::find($createdType_variable['id']), 'Type_variable with given id must be in DB');
        $this->assertModelData($typeVariable, $createdType_variable);
    }

    /**
     * @test read
     */
    public function test_read_type_variable()
    {
        $typeVariable = Type_variable::factory()->create();

        $dbType_variable = $this->typeVariableRepo->find($typeVariable->id);

        $dbType_variable = $dbType_variable->toArray();
        $this->assertModelData($typeVariable->toArray(), $dbType_variable);
    }

    /**
     * @test update
     */
    public function test_update_type_variable()
    {
        $typeVariable = Type_variable::factory()->create();
        $fakeType_variable = Type_variable::factory()->make()->toArray();

        $updatedType_variable = $this->typeVariableRepo->update($fakeType_variable, $typeVariable->id);

        $this->assertModelData($fakeType_variable, $updatedType_variable->toArray());
        $dbType_variable = $this->typeVariableRepo->find($typeVariable->id);
        $this->assertModelData($fakeType_variable, $dbType_variable->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_type_variable()
    {
        $typeVariable = Type_variable::factory()->create();

        $resp = $this->typeVariableRepo->delete($typeVariable->id);

        $this->assertTrue($resp);
        $this->assertNull(Type_variable::find($typeVariable->id), 'Type_variable should not exist in DB');
    }
}
