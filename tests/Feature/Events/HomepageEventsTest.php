<?php

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows events on the homepage in pages of twenty records', function () {
    Event::factory()
        ->count(25)
        ->sequence(fn (Sequence $sequence): array => [
            'title' => 'Event '.($sequence->index + 1),
            'slug' => 'event-'.($sequence->index + 1),
            'starts_at' => now()->addDays($sequence->index),
            'is_published' => $sequence->index % 2 === 0,
        ])
        ->create();

    $firstPage = $this->get('/');

    $firstPage
        ->assertSuccessful()
        ->assertSee('Event 25')
        ->assertDontSee('Event 5')
        ->assertSee('?page=2', false);

    $secondPage = $this->get('/?page=2');

    $secondPage
        ->assertSuccessful()
        ->assertSee('Event 5')
        ->assertSee('Event 1');
});
