@extends('components.welcome')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HDC Events</title>

    </head>
    <body class="antialiased">

    <div>
        <h1>Event Page</h1>
        @foreach($events as $event)
            <p>{{ $event->title }} -- {{ $event->description }}</p>
        @endforeach

        @section('footer')
        @endsection
    </div>

    </body>
</html>
