<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_a_paginated_list_of_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
        $response->assertViewHas('products');
        $this->assertEquals(3, $response->viewData('products')->count());
    }

    /** @test */
    public function it_displays_the_edit_form_for_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product->id));

        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
        $response->assertViewHas('product', $product);
    }

    /** @test */
    public function it_updates_an_existing_product()
    {
        $product = Product::factory()->create();

        $data = [
            'code' => "ABC",
            'name' => 'Updated Product',
            'quantity' => 1,
            'price' => 200,
        ];

        $response = $this->put(route('products.update', $product->id), $data);

        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product']);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Product is updated successfully.');
    }

    /** @test */
    public function it_deletes_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product->id));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Product is deleted successfully.');
    }
}
