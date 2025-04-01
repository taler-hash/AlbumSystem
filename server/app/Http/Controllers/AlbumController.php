<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAlbumRequest;
use App\Http\Requests\VoteRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use App\Models\Vote;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::withCount(['votes as upvotes_count' => function($query) {
            $query->where('vote', true);
        }])
        ->where(function ($q) use ($request) {
            if (!empty($request?->searchString) && in_array($request?->searchBy, ['artist_name', 'name'])) {
                $q->where($request->searchBy, $request->searchString);
            }
        })
        ->orderByRaw('CASE WHEN upvotes_count > 0 THEN 0 ELSE 1 END, upvotes_count DESC, name ASC')
        ->paginate(10);

        return response()->json($albums, 200);
    }

    public function create() {}
    public function read() {}

    public function delete(DeleteAlbumRequest $request)
    {
        Album::find($request->id)->delete();

        return response()->json(['message' => 'Successfully Deleted'], 200);
    }

    public function vote(VoteRequest $request)
    {
        Vote::where('user_id', $request->user_id)
            ->where('album_id', $request->album_id)
            ->create([
                'vote' => $request->vote
            ]);

        return response()->json(['message' => 'Successfully Voted'], 200);
    }
}
