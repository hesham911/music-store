<?php

namespace App\Http\Requests\Api\Songs;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSongRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title'         => 'required|string|min:2|max:255',
            'song'          => 'required|mimetypes:audio/mpeg,audio/ogg|max:10240',
            'imgSong'       => 'required|image||mimes:jpeg,png,jpg|max:2048',
            'artistsIds'     => 'required|array',
            'artistsIds.*'  => 'integer|exists:artists,id',
            'album_id'      => 'required|integer|exists:albums,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'title'         => $this->title,
            'imgSong'       => $this->imgSong,
            'song'          => $this->song,
            'artistsIds'    => $this->artistsIds,
            'album_id'      => $this->albumId,
        ]);
    }

    public function attributes(): array
    {
        return [
            'title'         => __('songs.titles.title'),
            'song'          => __('songs.titles.song'),
            'imgSong'       => __('songs.titles.imgSong'),
            'artistsIds'    => __('songs.titles.artistsIds'),
            'artistsIds.*'  => __('songs.titles.artistId'),
            'album_id'      => __('songs.titles.albumId'),
        ];
    }

    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages(): array
    {
        return[
            'title.required'        =>  __('songs.validation.error.title.required'),
            'title.string'          =>  __('songs.validation.error.title.string'),
            'title.min'             =>  __('songs.validation.error.title.min'),
            'title.max'             =>  __('songs.validation.error.title.max'),
            'song.required'         =>  __('songs.validation.error.song.required'),
            'song.mimetypes'        =>  __('songs.validation.error.song.mimetypes'),
            'song.max'              =>  __('songs.validation.error.song.max'),
            'imgSong.required'      =>  __('songs.validation.error.imgSong.required'),
            'imgSong.image'         =>  __('songs.validation.error.imgSong.image'),
            'imgSong.mimetypes'     =>  __('songs.validation.error.imgSong.mimetypes'),
            'imgSong.max'           =>  __('songs.validation.error.imgSong.max'),
            'artistsIds.required'   =>  __('songs.validation.error.artistsIds.required'),
            'artistsIds.array'      =>  __('songs.validation.error.artistsIds.array'),
            'artistsIds.*.integer'  =>  __('songs.validation.error.artistId.integer'),
            'artistsIds.*.exists'   =>  __('songs.validation.error.artistId.exists'),
            'albumId.required'      =>  __('artists.validation.error.albumId.required'),
            'albumId.exists'        =>  __('artists.validation.error.albumId.exists'),
            'albumId.integer'       =>  __('artists.validation.error.albumId.integer'),
        ];
    }
}
