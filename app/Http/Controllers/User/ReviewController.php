<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function index(Request $request)
    {
        return $request->user()->reviews()->get();
    }

    public function create(Request $request)
    {
        return $request->user()->reviews()->create([
            "review" => $request->review
        ]);
    }

    public function update(Review $review, Request $request)
    {
        return $review->update([
            "review" => $request->review
        ]);
    }

    public function delete(Review $review)
    {
        $review->replies()->delete();
        return $review->delete();
    }


}
