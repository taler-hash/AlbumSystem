<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Vote;
use Mockery\Undefined;

class AlbumServices {
    
    public function getAlbums($request) {
        $albums = Album::withCount(['votes as upvotes_count' => function($query) {
            $query->where('vote', true);
        }])
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->orderByRaw('CASE WHEN upvotes_count > 0 THEN 0 ELSE 1 END, upvotes_count DESC, name ASC')
        ->paginate(10);

        return $albums;
    }

    public function deleteAlbum($request) {
        $album = Album::find($request->id);
        $album->votes()->delete();
        $album->delete();
    }

    public function checkIfUserAlreadyVoted($request) {
        $albumVote = Vote::where('user_id', $request->user_id)
        ->where('album_id', $request->album_id);
        $vote = $albumVote->first()?->vote === null ? null : (boolean)$albumVote->first()?->vote;

        return $vote === $request->vote;
    }

    public function voteAlbum($request) {
        Vote::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'album_id' => $request->album_id
            ],
            ['vote' => (boolean)$request->vote]
        );

        return response()->json([
            'message' => "Successfully ". ((boolean)$request->vote ? 'upvoted' : 'downvoted')
        ], 200);
    }
}