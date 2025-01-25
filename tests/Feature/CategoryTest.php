<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateCategory()
    {
        $categoria = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'name' => $categoria->name,
        ]);
    }
    public function testUpdateCategory()
    {
        $categoria = Category::factory()->create();
        $categoria->update(['name' => 'Prueba test']);
        $this->assertDatabaseHas('categories', [
            'name' => 'Prueba test',
        ]);
    }

    public function testDeleteCategory()
    {
        $categoria = Category::factory()->create();
        $categoria->delete();
        $this->assertDatabaseMissing('categories', [
            'name' => $categoria->name,
        ]);
    }
}
