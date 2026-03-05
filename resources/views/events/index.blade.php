<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} | Events</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-amber-50/40 text-zinc-900 antialiased">
        <div class="mx-auto flex w-full max-w-7xl flex-col gap-10 px-4 py-10 sm:px-6 lg:px-8">
            <header class="mx-auto flex max-w-2xl flex-col items-center gap-4 text-center">
                <span class="inline-flex items-center rounded-full border border-amber-300 bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-amber-800">
                    Events
                </span>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">
                    Upcoming and Recent Events
                </h1>
                <p class="text-sm text-zinc-600 sm:text-base">
                    Browse all event records from the admin panel in a responsive, card-based layout.
                </p>
            </header>

            @if ($events->isEmpty())
                <section class="mx-auto flex w-full max-w-2xl flex-col items-center rounded-2xl border border-amber-200 bg-white p-10 text-center shadow-sm">
                    <p class="text-lg font-semibold text-zinc-800">No events available yet.</p>
                    <p class="mt-2 text-sm text-zinc-600">Create your first event from the admin panel.</p>
                </section>
            @else
                <section class="grid grid-cols-1 justify-items-center gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($events as $event)
                        <article class="flex h-full w-full max-w-xl flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">
                            @if ($event->cover_image_url)
                                <img
                                    src="{{ $event->cover_image_url }}"
                                    alt="{{ $event->title }}"
                                    class="h-56 w-full object-cover"
                                />
                            @else
                                <div class="flex h-56 w-full items-center justify-center bg-gradient-to-br from-amber-100 via-amber-50 to-white">
                                    <span class="rounded-full border border-amber-300 bg-amber-200/70 px-4 py-1 text-sm font-semibold text-amber-800">
                                        No Cover Image
                                    </span>
                                </div>
                            @endif

                            <div class="flex flex-1 flex-col gap-4 p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <h2 class="text-xl font-semibold text-zinc-900">{{ $event->title }}</h2>
                                    <span @class([
                                        'inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-xs font-semibold',
                                        'bg-emerald-100 text-emerald-700' => $event->is_published,
                                        'bg-zinc-100 text-zinc-700' => ! $event->is_published,
                                    ])>
                                        {{ $event->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>

                                @if ($event->description)
                                    <p class="max-h-[4.5rem] overflow-hidden text-sm leading-6 text-zinc-700">
                                        {{ $event->description }}
                                    </p>
                                @endif

                                <div class="mt-auto grid grid-cols-1 gap-2 text-sm text-zinc-600 sm:grid-cols-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c-3.5 0-6.75 2.8-6.75 6.34 0 4.42 5.5 11.16 6.1 11.88a.84.84 0 0 0 1.3 0c.6-.72 6.1-7.46 6.1-11.88C18.75 5.05 15.5 2.25 12 2.25Z" />
                                            <circle cx="12" cy="8.59" r="2.4" />
                                        </svg>
                                        <span>{{ $event->location ?: 'Location not set' }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 2v3M16 2v3M4 9h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                                        </svg>
                                        <span>Starts {{ $event->starts_at?->format('M d, Y H:i') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 2v3M16 2v3M4 9h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14h6" />
                                        </svg>
                                        <span>Ends {{ $event->ends_at?->format('M d, Y H:i') ?? 'Not set' }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                            <circle cx="12" cy="12" r="9" />
                                        </svg>
                                        <span>Created {{ $event->created_at?->format('M d, Y H:i') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 sm:col-span-2">
                                        <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 2.64-6.36" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4v4h4" />
                                        </svg>
                                        <span>Updated {{ $event->updated_at?->format('M d, Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </section>
            @endif

            <div class="mx-auto w-full max-w-4xl">
                {{ $events->onEachSide(1)->links() }}
            </div>
        </div>
    </body>
</html>
