<?php

namespace App\Http\DTO;

use App\Models\Event;

class EventDTO
{
    public int $id;
    public string $title;
    public string $description;
    public string $city;
    public int $private;
    public ?string $date;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $city,
        int $private,
        ?string $date
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->city = $city;
        $this->private = $private;
        $this->date = $date;
    }

    public function __toString(): string {
        return json_encode($this);
    }

    public static function eventDTO(Event $event): self {
        return new self(
            $event->id,
            $event->title,
            $event->description,
            $event->city,
            $event->private,
            $event->date
        );
    }
}
