<?php

namespace App\Http\DTO;

use App\Models\Event;

class CreateEventDTO {

    public string $title;
    public string $description;
    public string $city;
    public int $private;
    public string $date;

    public function __construct(
        string $title,
        string $description,
        string $city,
        int $private,
        string $date
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->city = $city;
        $this->private = $private;
        $this->date = $date;
    }

    public function __toString(): string {
        return json_encode([
            'title' => $this->title,
            'description' => $this->description,
            'city' => $this->city,
            'private' => $this->private,
            'date' => $this->date,
        ]);
    }

    public static function createEventDTO(Event $event): self {
        return new self(
            $event->title,
            $event->description,
            $event->city,
            $event->private,
            $event->date,
        );
    }

    public static function schema(): array {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'city' => 'required|string',
            'private' => 'required|int',
            'date' => 'required|string',
        ];
    }
}
?>
