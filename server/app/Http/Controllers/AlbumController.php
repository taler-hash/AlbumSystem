<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAlbumRequest;
use App\Http\Requests\VoteRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Services\AlbumServices;

class AlbumController extends Controller
{
    public function index(Request $request, AlbumServices $albumServices)
    {
        return response()->json($albumServices->getAlbums($request), 200);
    }

    public function delete(DeleteAlbumRequest $request, AlbumServices $albumServices)
    {
       $albumServices->deleteAlbum($request);
    }

    public function vote(VoteRequest $request,AlbumServices $albumServices)
    {
        $alreadyVoted = $albumServices->checkIfUserAlreadyVoted($request);

        if($alreadyVoted) {
            return response()->json([
                'error' => "You already " . ($request->vote ? 'upvoted' : 'downvoted')
             ], 422);
        } else {
            return $albumServices->voteAlbum($request);
        }
    }
}
