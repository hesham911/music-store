<?php

namespace App\Http\Controllers\Api\v1\Albums;

use App\Http\Controllers\Api\v1\BasicController;
use App\Http\Requests\Api\Albums\CreateAlbumRequest;
use App\Http\Resources\Albums\AlbumResource;
use App\Http\Resources\Albums\AlbumsResource;
use App\Models\Album;
use Illuminate\Http\JsonResponse;

class AlbumController extends BasicController
{

    public function index(): JsonResponse
    {
        $data = Album::query()->limit(100)->paginate(10);

        return $this->sendResponse(new AlbumsResource($data),'All Albums Return');
    }

    public function store(CreateAlbumRequest $request): JsonResponse
    {
        $data  = $request->all();
        $album = Album::create($data);
        $album->artists()->attach($request->artistsIds);

        return $this->sendResponse(new AlbumResource($album), 'Artist Created Successfully');
    }


    public function show($id): JsonResponse
    {
        $album = Album::find($id);

        return $album ? $this->sendResponse(new AlbumResource($album),'Retrieved Successfully.') : $this->sendError('Album not found.');
    }
}
