<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return Review::all();
    }

    public function getReview(Review $review)
    {
        return $review;
    }
    public function addReply(Review $review, Request $request)
    {
        return $review->replies()->create([
            "reply" => $request->reply
        ]);
    }

    public function updateReply(Reply $reply, Request $request)
    {
        return $reply->update([
            "reply" => $request->reply
        ]);
    }

    public function deleteReply(Reply $reply)
    {
        return $reply->delete();
    }
}
