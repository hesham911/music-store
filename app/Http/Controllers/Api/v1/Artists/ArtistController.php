<?php

namespace App\Http\Controllers\Api\v1\Artists;

use App\Enum\UserStatus;
use App\Enum\UserTypes;
use App\Http\Controllers\Api\v1\BasicController;
use App\Http\Requests\Api\Artists\CreateArtistRequest;
use App\Http\Resources\Artists\ArtistResource;
use App\Http\Resources\Artists\ArtistsResource;
use App\Models\Artist;
use Illuminate\Http\JsonResponse;


class ArtistController extends BasicController
{
    public function index(): JsonResponse
    {
        $data = Artist::query()->whereHas('user', function ($q) {
            $q->where('status', UserStatus::Active);
        })
            ->limit(100)
            ->paginate(request()->all());

        return $this->sendResponse(new ArtistsResource($data),'All Artists Return');
    }

    public function store(CreateArtistRequest $request): JsonResponse
    {
        $data = $request->all();

        $artist = Artist::create($data);

        $artist->user->update([
            'type' => UserTypes::Artist
        ]);

        return $this->sendResponse(new ArtistResource($artist), 'Artist Created Successfully');
    }


    public function show($id)
    {
        $artist = Artist::find($id);

       return $artist ? $this->sendResponse(new ArtistResource($artist),'Retrieved Successfully.') : $this->sendError('Artist not found.');
    }
}
