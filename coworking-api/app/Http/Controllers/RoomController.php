<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PostResource;
use App\Models\Post;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $result = Room::find($id);
        if ($result) {
            return $this->success(new PostResource($result), "Todo ok, como dijo el Pibe");
        } else {
            return $this->error("Todo mal, como NO dijo el Pibe", 404, ['id' => 'No se encontro el recurso con el id']);
        }
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
