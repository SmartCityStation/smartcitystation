<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Backend\EventLog;

class EventLogApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_event_log()
    {
        $eventLog = EventLog::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/backend/event_logs', $eventLog
        );

        $this->assertApiResponse($eventLog);
    }

    /**
     * @test
     */
    public function test_read_event_log()
    {
        $eventLog = EventLog::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/backend/event_logs/'.$eventLog->id
        );

        $this->assertApiResponse($eventLog->toArray());
    }

    /**
     * @test
     */
    public function test_update_event_log()
    {
        $eventLog = EventLog::factory()->create();
        $editedEventLog = EventLog::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/backend/event_logs/'.$eventLog->id,
            $editedEventLog
        );

        $this->assertApiResponse($editedEventLog);
    }

    /**
     * @test
     */
    public function test_delete_event_log()
    {
        $eventLog = EventLog::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/backend/event_logs/'.$eventLog->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/backend/event_logs/'.$eventLog->id
        );

        $this->response->assertStatus(404);
    }
}
