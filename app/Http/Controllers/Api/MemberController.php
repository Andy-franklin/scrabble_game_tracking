<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MemberResource;
use App\Http\Resources\MembersResource;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MemberController extends BaseController
{
    public function show(Member $member): MemberResource
    {
        MemberResource::withoutWrapping();

        return new MemberResource($member);
    }

    public function index()
    {
        return new MembersResource(Member::with('games')->paginate());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'email' => 'email',
            'phone_number' => 'numeric'
        ]);

        $member = Member::create($request->all());

        return new MemberResource($member);
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'email' => 'email',
            'phone_number' => 'numeric'
        ]);

        $member->update($request->all());

        return new MemberResource($member);
    }

    public function destroy()
    {
        //@Todo:
    }
}
