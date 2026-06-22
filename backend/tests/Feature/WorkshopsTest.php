<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkshopsTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): static
    {
        return $this->actingAs(User::factory()->create(), 'sanctum');
    }

    private function createSede(): int
    {
        return $this->actingAsAdmin()
                    ->postJson('/api/v1/locations', [
                        'name'    => 'Sede Principal',
                        'address' => 'Calle 100 #15-20',
                    ])
                    ->json('id');
    }

    public function test_unauthenticated_request_is_rejected(): void
    {
        $this->getJson('/api/v1/workshops')->assertStatus(401);
    }

    public function test_lists_all_workshops(): void
    {
        $sedeId = $this->createSede();

        $this->actingAsAdmin()
             ->postJson('/api/v1/workshops', [
                 'location_id' => $sedeId,
                 'name'        => 'Taller Norte',
                 'address'     => 'Calle 100',
                 'cost_center' => '001',
             ]);

        $response = $this->actingAsAdmin()
                         ->getJson('/api/v1/workshops');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [['id', 'location_id', 'name', 'address', 'cost_center']],
                     'meta' => ['total', 'per_page', 'current_page', 'last_page'],
                 ]);
    }

    public function test_creates_workshop_successfully(): void
    {
        $sedeId = $this->createSede();

        $response = $this->actingAsAdmin()
                         ->postJson('/api/v1/workshops', [
                             'location_id' => $sedeId,
                             'name'        => 'Taller Centro',
                             'address'     => 'Calle 50 #10-20',
                             'cost_center' => '003',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'id'])
                 ->assertJsonPath('message', 'Taller creado exitosamente.');
    }

    public function test_create_workshop_returns_integer_id(): void
    {
        $sedeId = $this->createSede();

        $response = $this->actingAsAdmin()
                         ->postJson('/api/v1/workshops', [
                             'location_id' => $sedeId,
                             'name'        => 'Taller Centro',
                             'address'     => 'Calle 50 #10-20',
                             'cost_center' => '003',
                         ]);

        $response->assertStatus(201);
        $this->assertIsInt($response->json('id'));
    }

    public function test_create_workshop_fails_with_invalid_cost_center(): void
    {
        $sedeId = $this->createSede();

        $response = $this->actingAsAdmin()
                         ->postJson('/api/v1/workshops', [
                             'location_id' => $sedeId,
                             'name'        => 'Taller X',
                             'address'     => 'Calle 1',
                             'cost_center' => 'ABC',
                         ]);

        $response->assertStatus(422);
    }

    public function test_create_workshop_fails_without_required_fields(): void
    {
        $response = $this->actingAsAdmin()
                         ->postJson('/api/v1/workshops', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['location_id', 'name', 'address', 'cost_center']);
    }

    public function test_create_workshop_fails_with_non_existent_location(): void
    {
        $response = $this->actingAsAdmin()
                         ->postJson('/api/v1/workshops', [
                             'location_id' => 9999,
                             'name'        => 'Taller X',
                             'address'     => 'Calle 1',
                             'cost_center' => '001',
                         ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['location_id']);
    }

    public function test_shows_workshop_by_id(): void
    {
        $sedeId = $this->createSede();

        $createResponse = $this->actingAsAdmin()
                               ->postJson('/api/v1/workshops', [
                                   'location_id' => $sedeId,
                                   'name'        => 'Taller Norte',
                                   'address'     => 'Calle 100',
                                   'cost_center' => '001',
                               ]);

        $id = $createResponse->json('id');

        $response = $this->actingAsAdmin()
                         ->getJson("/api/v1/workshops/{$id}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Taller Norte')
                 ->assertJsonPath('data.location_id', $sedeId);
    }

    public function test_returns_404_for_non_existent_workshop(): void
    {
        $this->actingAsAdmin()
             ->getJson('/api/v1/workshops/9999')
             ->assertStatus(404);
    }
}
