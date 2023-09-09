<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Database\Factories\TodoListFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $singleList = $this->getJson('/api/todo-list/'.$this->list->id)
                        ->assertOk()
                        ->json();

        $this->assertEquals($this->list->name, $singleList['name']);
    }
}
