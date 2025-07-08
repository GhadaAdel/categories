<?php

use Livewire\Livewire;
use App\Filament\Resources\ReviewResource\Pages\CreateReview;
use App\Models\Product;
use App\Models\User;

it('can create a review', function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();

    Livewire::test(CreateReview::class)
        ->fillForm([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'review' => 'good one!',
            'is_approved' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('reviews', [
        'product_id' => $product->id,
        'user_id' => $user->id,
        'review' => 'good one!',
        'is_approved' => true,
    ]);
});
