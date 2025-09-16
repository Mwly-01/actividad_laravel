<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAmenityRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Traits\ApiResponse;
use App\Models\AmenityRoom;
use Illuminate\Http\JsonResponse;

class AmenityRoomController extends Controller
{
    use ApiResponse;
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
    public function store(StoreAmenity_roomRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Amenity_room $amenity_room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amenity_room $amenity_room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAmenity_roomRequest $request, Amenity_room $amenity_room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amenity_room $amenity_room)
    {
        //
    }
}
