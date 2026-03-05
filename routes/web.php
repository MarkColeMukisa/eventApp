<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $events = Event::query()
        ->latest('starts_at')
        ->paginate(20);

    return view('events.index', [
        'events' => $events,
    ]);
});
