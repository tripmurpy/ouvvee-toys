<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_pages_require_login(): void
    {
        $this->get('/cart')->assertRedirect('/login');
        $this->get('/checkout')->assertRedirect('/login');
        $this->get('/wishlist')->assertRedirect('/login');
        $this->get('/orders')->assertRedirect('/login');
    }
}
