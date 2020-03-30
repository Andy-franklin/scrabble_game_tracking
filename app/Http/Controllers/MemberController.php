<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MemberController extends BaseController
{
    public function show(Member $member)
    {
        return view('member.profile', ['member' => $member]);
    }

    public function index()
    {
        $members = Member::all();

        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
        ]);

        Member::create($request->all());

        return redirect('/member')->with('success', 'Member Saved');
    }

    public function edit(Member $member)
    {
        return view('member.update', ['member' => $member]);
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
        ]);

        $member->update($request->all());

        return redirect('/member')->with('success', 'Member Saved');
    }

    public function destroy()
    {
        //@Todo:
    }
}
