<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberBookingResource;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Traits\ApiResponse;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
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
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    public function bookings(Member $member)
    {
        $bookings = $member->bookings()->with('room')->get();

        return $this->success(
            MemberBookingResource::collection($bookings),
            "Bookings retrieved successfully"
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
