<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $user = User::factory()->createOne();
    actingAs($user);
});

test('products screen can be rendered', function () {
    $response = $this->get(route('product.index'));

    $response->assertStatus(200);
});

test('can show list of products and tags', function () {
    Product::factory()->count(5)->state([
        'tags' => [['title' => 'apple']],
    ])->create();

    $response = $this->get(action([ProductController::class, 'index']));

    $response->assertInertia(function (AssertableInertia $page) {
        $page
            ->component('Products/Index')
            ->has('products', 5)
            ->has('tags', 1, function (AssertableInertia $page) {
                $page
                    ->where('title', 'apple')
                    ->where('count', 5);
            });
    });
});
