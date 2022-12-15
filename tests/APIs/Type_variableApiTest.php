<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\Type_variable;

class Type_variableApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_type_variable()
    {
        $typeVariable = Type_variable::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/type_variables', $typeVariable
        );

        $this->assertApiResponse($typeVariable);
    }

    /**
     * @test
     */
    public function test_read_type_variable()
    {
        $typeVariable = Type_variable::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/type_variables/'.$typeVariable->id
        );

        $this->assertApiResponse($typeVariable->toArray());
    }

    /**
     * @test
     */
    public function test_update_type_variable()
    {
        $typeVariable = Type_variable::factory()->create();
        $editedType_variable = Type_variable::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/type_variables/'.$typeVariable->id,
            $editedType_variable
        );

        $this->assertApiResponse($editedType_variable);
    }

    /**
     * @test
     */
    public function test_delete_type_variable()
    {
        $typeVariable = Type_variable::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/type_variables/'.$typeVariable->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/type_variables/'.$typeVariable->id
        );

        $this->response->assertStatus(404);
    }
}
