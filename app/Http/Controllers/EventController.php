<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Services\EventService;
use App\Http\DTO\CreateEventDTO;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
*  @OA\GET(
*      path="/events/findAll",
*      summary="Get all events",
*      description="Get all events",
*      tags={"Find All Events"},
*      @OA\Response(
*          response=200,
*          description="OK",
*          @OA\MediaType(
*              mediaType="application/json",
*          )
*      ),
*
*  ),
*  @OA\GET(
*      path="/events/findOne/{id}",
*      summary="Get One Event",
*      description="Get One Event",
*      tags={"Find One Event"},
*     @OA\Parameter(
*         name="id",
*         in="path",
*         description="event id",
*         required=true,
*         @OA\Schema(
*              type="integer",
*              example=3,
*          ),
*      ),
*      @OA\Response(
*          response=200,
*          description="OK",
*          @OA\MediaType(
*              mediaType="application/json",
*          )
*      ),
*
*  )
*  @OA\GET(
*      path="/events/findAlway/?searchTerm",
*      summary="Get Events By Search",
*      description="Get Events By Serach",
*      tags={"Find Events By Serach"},
*     @OA\Parameter(
*         name="searchTerm",
*         in="query",
*         description="query Term",
*         required=true,
*         @OA\Schema(
*              type="string",
*              example="gothan",
*          ),
*      ),
*      @OA\Response(
*          response=200,
*          description="OK",
*          @OA\MediaType(
*              mediaType="application/json",
*          )
*      ),
*
*  )
* @OA\Post(
*      path="/events/create",
*      summary="Create new Event",
*      description="Create new Event",
*      tags={"Create Event"},
*      @OA\RequestBody(
*          required=true,
*          description="Event data",
*          @OA\MediaType(
*              mediaType="application/json",
*              @OA\Schema(
*                  type="object",
*                  @OA\Property(property="title", type="string", example="Cine"),
*                  @OA\Property(property="city", type="string", example="Curitiba"),
*                  @OA\Property(property="private", type="integer", example=1),
*                  @OA\Property(property="description", type="string", example="View one movie"),
*                  @OA\Property(property="date", type="string", example="2024-07-11 15:30:00"),
*              ),
*          ),
*      ),
*      @OA\Response(
*          response=200,
*          description="Event created successfully",
*          @OA\MediaType(
*              mediaType="application/json",
*          ),
*      ),
* )
*/

class EventController extends Controller {

    protected EventService $eventService;

    public function __construct(EventService $eventService) {

        $this->eventService = $eventService;
    }

    public function findAll(): JsonResponse {

        return $this -> handleResponse (
            function () {

                $events = $this -> eventService -> findAll();

                return response()->json($events, 200, [
                    'Content-Type' => 'application/json',
                ]);
            }
        );
    }

    public function findOne($id): JsonResponse {

        try {

            Validator::make(['id' => $id], [
                'id' => 'required|integer|min:1',
            ])->validate();
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->getMessage(),
            ], 400);
        }
    
        return $this->handleResponse(function () use ($id) {

            try {
                $event = $this->eventService->findOne($id);
    
                return response()->json($event, 200, [
                    'Content-Type' => 'application/json',
                ]);
    
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Something went wrong.',
                    'message' => $e->getMessage(),
                ], 404);
            }
        });
    }

    public function findAlway(Request $request): JsonResponse {

        try {
            $searchTerm = $request->query('searchTerm');
    
            $events = $this->eventService->findAlway($searchTerm);
    
            return response()->json($events, 200, [
                'Content-Type' => 'application/json',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Event not found',
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function createEvent(Request $request): JsonResponse {

        $requestKeys = array_keys($request->all());
        $schemaKeys = array_keys(CreateEventDTO::schema());

        if ( count(array_diff($requestKeys, $schemaKeys)) > 0 || count(array_diff($schemaKeys, $requestKeys)) > 0) {

            $unexpectedFields = array_diff($requestKeys, $schemaKeys);
            $missingFields = array_diff($schemaKeys, $requestKeys);

            $errorMessage = 'Unexpected fields: ' . implode(', ', $unexpectedFields);

            if (!empty($missingFields)) {
                $errorMessage = 'Missing fields: ' . implode(', ', $missingFields);
            }

            return response()->json([
                'error' => 'Unexpected Parameter',
                'message' => $errorMessage,
            ], 400);
        }

        try {

            $validatedData = $request->validate(CreateEventDTO::schema());

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage(),
            ], 400);
        }

        $createEventDTO = new CreateEventDTO(
            $validatedData['title'],
            $validatedData['description'],
            $validatedData['city'],
            $validatedData['private'],
            $validatedData['date'],
        );

        return $this->handleResponse(function () use ($createEventDTO) : JsonResponse {

            $event = $this->eventService->createEvent($createEventDTO);

            return response()->json($event->original, 201);
        });
    }


    private function handleResponse(callable $callback): JsonResponse {

        try {

            return $callback();

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

?>