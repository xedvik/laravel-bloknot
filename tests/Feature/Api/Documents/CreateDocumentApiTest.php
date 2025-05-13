<?php

namespace Tests\Feature\Api\Documents;
use App\Infrastructure\Eloquent\Models\User;
use App\Infrastructure\Eloquent\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDocumentApiTest extends TestCase
{
    use RefreshDatabase;

    protected array $payload;
    protected object $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->payload = [
            'title' => 'title test',
            'content' => 'content via le sa',
        ];
    }

    /** @test */
    public function test_document_create_success()
    {
        $response = $this->actingAs($this->user)->postJson('/api/document/create', $this->payload);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
            ]);
    }

    public function test_document_creation_fails_if_title_exists_for_same_user()
    {
        Document::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'title test',
            'content' => 'content via 2le sa',
        ]);

        $response = $this->actingAs($this->user)->postJson('/api/document/create', $this->payload);
        $response->assertStatus(400)
        ->assertJsonFragment([
            'status' => 'error',
            'message' => 'Document with this title already exists.',
            'data' => ['available' => false],
        ]);

    }
}
