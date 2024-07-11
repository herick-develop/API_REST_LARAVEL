<?php

namespace App\Http\Services;

use App\Http\DTO\CreateEventDTO;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

use App\Http\DTO\EventDTO;

class EventService {

    public function findAll(): Collection {

        $eventDTOs = new Collection();

        try {

            $events = Event::all();

            if ($events->isEmpty()) {
                throw new \Exception("Events not found");
            }

            foreach ($events as $event) {
                $eventDTOs->push(EventDTO::eventDTO($event));
            }

            return $eventDTOs;

        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Events not found");
        }
    }

    public function findOne(int $id): EventDTO {

        try {

            $event = Event::findOrFail($id);
            return EventDTO::eventDTO($event);

        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Event not found with ID $id");
        }
    }

    public function findAlway(string $searchTerm = null): Collection {

        try {

            $query = Event::query();

            if ($searchTerm !== null) {

                $query->where(function ($query) use ($searchTerm) {

                    $query->where('title', 'like', '%' . $searchTerm . '%')
                          ->orWhere('city', 'like', '%' . $searchTerm . '%')
                          ->orWhere('description', 'like', '%' . $searchTerm . '%');
                });
            }

            $events = $query->get();
            return $events;

        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Event not found with specified criteria");
        }
    }

    public function createEvent(CreateEventDTO $createEventDTO): JsonResponse {

        try {

            $event = new Event();

            $event -> title       = $createEventDTO -> title;
            $event -> city        = $createEventDTO -> city;
            $event -> private     = $createEventDTO -> private;
            $event -> description = $createEventDTO -> description;
            $event -> date        = $createEventDTO -> date;

            $event->save();

            
            return response()->json(['message' => 'Event created successfully'], 201);

        } catch (\Exception $e) {
            //Log::error('Failed to create event: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create event'], 500);
        }
    }
}

?>