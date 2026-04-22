<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProjectHealthTest extends TestCase
{
    /**
     * Test if Homepage is accessible.
     */
    public function test_homepage_is_working()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test if Shop page is working.
     */
    public function test_shop_page_is_working()
    {
        $response = $this->get('/shop'); // Adjust route if different
        $response->assertStatus(200);
    }

    /**
     * Test if Product details can be loaded.
     */
    public function test_product_details_load()
    {
        $product = Product::first();
        if ($product) {
            $response = $this->get('/product/details/' . $product->id);
            $response->assertStatus(200);
            $response->assertSee($product->name);
        }
    }

    /**
     * Test if Admin login page is up.
     */
    public function test_admin_login_accessible()
    {
        $response = $this->get('/admin/login'); // Adjust route if different
        $response->assertStatus(200);
    }
}
