<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;


    public function test_login_redirects_to_products()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/authenticate', [
            'email' => 'user@user.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('products');
    }

    public function test_unathenticated_user_cannot_access_product(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
}
