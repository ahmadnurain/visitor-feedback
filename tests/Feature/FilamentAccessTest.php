<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_blocks_non_admin_to_filament_panel(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $this->get('/admin')->assertStatus(403);
    }

    public function test_allows_admin_to_filament_panel(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $this->get('/admin')->assertStatus(200);
    }
}

