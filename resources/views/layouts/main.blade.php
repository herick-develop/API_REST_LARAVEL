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
        <header>
            <nav>
                <div>
                    <ul>

                        <li>
                            <a href="/">Home</a>
                        </li>

                        <li>
                            <a href="/events/create">Create Event</a>
                        </li>

                        <li>
                            <a href="/"></a>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>

        @section('footer')
        @endsection
    </div>

    </body>
</html>
