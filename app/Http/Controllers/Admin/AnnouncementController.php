<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return Announcement::all();
    }

    public function store(Request $request)
    {
        return Announcement::create([
            "content" => $request->content
        ]);
    }

    public function update(Announcement $announcement, Request $request)
    {
        return $announcement->update([
            "content" => $request->content
        ]);
    }

    public function delete(Announcement $announcement)
    {
        return $announcement->delete();
    }
}
