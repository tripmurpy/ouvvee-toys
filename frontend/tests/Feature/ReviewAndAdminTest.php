<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewAndAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_is_blocked_without_purchase(): void
    {
        $this->seed();

        $user = User::where('email', 'buyer@ouvvee.test')->firstOrFail();
        $product = Product::active()->firstOrFail();

        $this->actingAs($user)->get(route('reviews.create', $product))->assertForbidden();
    }

    public function test_admin_dashboard_requires_admin_role(): void
    {
        $this->seed();

        $buyer = User::where('email', 'buyer@ouvvee.test')->firstOrFail();
        $admin = User::where('email', 'admin@ouvvee.test')->firstOrFail();

        $this->actingAs($buyer)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }
}
