<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\DataVariable;

class DataVariableApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_data_variable()
    {
        $dataVariable = DataVariable::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/data_variables', $dataVariable
        );

        $this->assertApiResponse($dataVariable);
    }

    /**
     * @test
     */
    public function test_read_data_variable()
    {
        $dataVariable = DataVariable::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/data_variables/'.$dataVariable->id
        );

        $this->assertApiResponse($dataVariable->toArray());
    }

    /**
     * @test
     */
    public function test_update_data_variable()
    {
        $dataVariable = DataVariable::factory()->create();
        $editedDataVariable = DataVariable::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/data_variables/'.$dataVariable->id,
            $editedDataVariable
        );

        $this->assertApiResponse($editedDataVariable);
    }

    /**
     * @test
     */
    public function test_delete_data_variable()
    {
        $dataVariable = DataVariable::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/data_variables/'.$dataVariable->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/data_variables/'.$dataVariable->id
        );

        $this->response->assertStatus(404);
    }
}
