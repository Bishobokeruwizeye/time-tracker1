<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;

use App\Models\Client;
use Carbon\Factory;


class ProjectTest extends TestCase
{
  use RefreshDatabase;
  Public function setUp(): void
  {
     parent::setUp();
     $this->user = Project::factory()->create();
  }
  public function test_user_can_create_a_project()
  {
    // $this->withoutExceptionHandling();


    $response = $this->actingAs($this->user)->post('/projects',[
      'client_id' => 1,
      'name' => 'ABC Project',
      'description' => 'This is a description',
      'budget' => 10000.14,
    ]);

    $response->assertStatus(200);

    $this->assertTrue(Project::all()->count() == 1);
  }

  public function test_user_can_update_a_project()
  {
    //$this->withoutExceptionHandling();

    $project = Project::factory()->forClient()->create([
      'name' => 'ABC Project'
    ]);

    $this->assertDatabaseHas('projects',['name' => 'ABC Project']);

    $response = $this->actingAs($this->user)->put('/projects/'.$project->id, [
      'client_id' => $project->client_id,
      'name' => 'ABC Project Updated',
    ]);

    $this->assertDatabaseHas('projects',['name' => 'ABC Project Updated']);
    
  }

  public function test_user_can_see_a_project()
  {
    $this->withoutExceptionHandling();

    $project = Project::factory()->forClient()->create();
    $this->assertTrue(Project::all()->count() == 1);

    $response = $this->actingAs($this->user)->get('/projects/'.$project->id);
    $response->assertStatus(200);
    $response->assertSee($project->name);
  }

  public function test_user_can_delete_a_project()
  {
    $project = Project::factory()->forClient()->create();
    $this->assertTrue(Project::all()->count() == 1);

    $response = $this->actingAs($this->user)->delete('/projects/'.$project->id);
    $this->assertTrue(Project::all()->count() == 0);

  }
}
