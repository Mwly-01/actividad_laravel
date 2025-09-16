<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Traits\ApiResponse;
use App\Models\Room;
use App\Models\Amenity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $spaceId = $request->query('space_id');
    
        $query = Room::with('spaces');
    
        if ($spaceId) {
            $query->where('space_id', $spaceId);
        }
    
        $rooms = $query->get();
    
        if ($spaceId && $rooms->isEmpty()) {
            return $this->error("No rooms found for the given space_id", 404, ['space_id' => 'No rooms found']);
        }
    
        return $this->success(RoomResource::collection($rooms), "Rooms retrieved successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request) {
        $room = Room::create($request->validated());
        return response()->json($room, 201);
      }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $room = Room::with('spaces')->find($id);
        if ($room) {
            return $this->success(new RoomResource($room), "Room found successfully");
        }
        
        return $this->error("Room not found", 404, ['id' => 'No resource found with the given id']);
    }

    public function attachAmenity(Room $room, Amenity $amenity)
    {
        // Evita duplicados usando syncWithoutDetaching
        $room->amenities()->syncWithoutDetaching([$amenity->id]);

        return $this->success(
            message: 'Amenity attached successfully.',
            data: ['room_id' => $room->id, 'amenity_id' => $amenity->id]
        );
    }

    public function detachAmenity(Room $room, Amenity $amenity)
    {
        // Elimina la relación si existe
        $room->amenities()->detach($amenity->id);

        return $this->success(
            message: 'Amenity detached successfully.',
            data: ['room_id' => $room->id, 'amenity_id' => $amenity->id]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
