<?php

namespace App\Http\Controllers\Api\v1\Songs;

use App\Http\Controllers\Api\v1\BasicController;
use App\Http\Requests\Api\Songs\CreateSongRequest;
use App\Http\Resources\SongResource;
use App\Http\Resources\SongsResource;
use App\Models\Song;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Owenoj\LaravelGetId3\GetId3;

class SongController extends BasicController
{

    public function index(): JsonResponse
    {
        $data = Song::query()->with('media')->limit(100)->paginate(10);

        return $this->sendResponse(new SongsResource($data),'All Song Return');
    }


    public function store(CreateSongRequest $request): JsonResponse
    {
        $song = $request->song;
        $songInfo = new GetId3($song);
        $request['duration'] = $this->getDurationFromStringTime($songInfo->getPlaytime());
        $songCreated = Song::query()->create($request->all());

        $songCreated->addMedia($song)->toMediaCollection('songs');
        $songCreated->addMedia($request->imgSong)->toMediaCollection('image-song');

        $songCreated->artists()->attach($request->artistsIds);

        return $this->sendResponse($songCreated,'Song created Successfully');
    }


    public function show($id): JsonResponse
    {
        $song = Song::find($id);

        return $song ? $this->sendResponse(new SongResource($song->loadMissing(['media'])),'Retrieved Successfully.') : $this->sendError('Song not found.');
    }

    public function getDurationFromStringTime($string): int
    {
       $minInSec =  intval(substr($string,0,strpos($string,':'))) * 60;

       return $minInSec + intval(substr($string, strpos($string, ":") + 1));

    }
}
