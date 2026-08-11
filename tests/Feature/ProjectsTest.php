<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/projects/index');

        $response->assertStatus(200);
        $response->assertSee('Projects');
        $response->assertSee('No projects found.');
    }

    public function test_projects_list_is_displayed(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'name' => 'Test Project ABC',
            'created_by' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/projects/index');

        $response->assertStatus(200);
        $response->assertSee('Test Project ABC');
        $response->assertSee($user->name);
    }
}
