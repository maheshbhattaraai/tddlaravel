<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Database\Factories\TodoListFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    protected $list;

    protected function setUp(): void
    {
        parent::setUp();
        $this->list = TodoList::factory()->create(['name'=>"My First Test"]);
    }
    
    /**
     *@test
     */
    public function get_all_todo_list(): void
    {
        $response = $this->getJson('/api/todo-list');

        $this->assertEquals(1, count($response->json()));
        $this->assertEquals("My First Test", $response->json()[0]['name']);
    }

    /**
     * @test
     */
    public function get_single_todo_list(){
        $singleList = $this->getJson('/api/todo-list/'.$this->list->id);

        $singleList->assertStatus(200);
        $this->assertEquals($this->list->name, $singleList['name']);
    }

    /**
     * @test
     */
    public function store_todo_list(){
        $list = TodoList::factory()->make();

        $response = $this->postJson('/api/todo-list',['name'=>$list->name]);

        $response->assertStatus(201);
        $this->assertDatabaseHas(TodoList::class,['name'=>$list->name]);
    }

    /**
     * @test
     */
    public function empty_validate_name_in_request_for_creating_todo_list(){
        $this->withExceptionHandling();

        $response = $this->postJson('/api/todo-list',[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrorFor('name');
    }

    /**
     *@test
     */
    public function max_length_validate_name_in_request_for_creating_todo_list(){
        $this->withExceptionHandling();
        $name = \Str::random(256);
        
        $response = $this->postJson('/api/todo-list',['name' => $name]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrorFor('name');
    }
}
