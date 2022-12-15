<?php namespace Tests\Repositories;

use App\Models\Backend\EventLog;
use App\Repositories\Backend\EventLogRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EventLogRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EventLogRepository
     */
    protected $eventLogRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->eventLogRepo = \App::make(EventLogRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_event_log()
    {
        $eventLog = EventLog::factory()->make()->toArray();

        $createdEventLog = $this->eventLogRepo->create($eventLog);

        $createdEventLog = $createdEventLog->toArray();
        $this->assertArrayHasKey('id', $createdEventLog);
        $this->assertNotNull($createdEventLog['id'], 'Created EventLog must have id specified');
        $this->assertNotNull(EventLog::find($createdEventLog['id']), 'EventLog with given id must be in DB');
        $this->assertModelData($eventLog, $createdEventLog);
    }

    /**
     * @test read
     */
    public function test_read_event_log()
    {
        $eventLog = EventLog::factory()->create();

        $dbEventLog = $this->eventLogRepo->find($eventLog->id);

        $dbEventLog = $dbEventLog->toArray();
        $this->assertModelData($eventLog->toArray(), $dbEventLog);
    }

    /**
     * @test update
     */
    public function test_update_event_log()
    {
        $eventLog = EventLog::factory()->create();
        $fakeEventLog = EventLog::factory()->make()->toArray();

        $updatedEventLog = $this->eventLogRepo->update($fakeEventLog, $eventLog->id);

        $this->assertModelData($fakeEventLog, $updatedEventLog->toArray());
        $dbEventLog = $this->eventLogRepo->find($eventLog->id);
        $this->assertModelData($fakeEventLog, $dbEventLog->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_event_log()
    {
        $eventLog = EventLog::factory()->create();

        $resp = $this->eventLogRepo->delete($eventLog->id);

        $this->assertTrue($resp);
        $this->assertNull(EventLog::find($eventLog->id), 'EventLog should not exist in DB');
    }
}
