<?php

namespace App\Http\Requests\Api\Albums;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateAlbumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|min:2|max:255',
            'artwork_url'   => 'required|url|max:255',
            'artistsIds'    => 'required|array',
            'artistsIds.*'  => 'integer|distinct|exists:artists,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'title'         => $this->title,
            'artwork_url'   => $this->artworkUrl,
            'artistsIds'    => $this->artistsIds,

        ]);
    }

    public function attributes(): array
    {
        return [
            'title'         => __('albums.titles.title'),
            'artwork_url'   => __('albums.titles.artworkUrl'),
            'artistsIds'    => __('albums.titles.artistsIds'),
            'artistsIds.*'  => __('albums.titles.artistId'),
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
            'title.required'        =>  __('albums.validation.error.title.required'),
            'title.string'          =>  __('albums.validation.error.title.string'),
            'title.min'             =>  __('albums.validation.error.title.min'),
            'title.max'             =>  __('albums.validation.error.title.max'),
            'artworkUrl.required'   =>  __('albums.validation.error.artworkUrl.required'),
            'artworkUrl.url'        =>  __('albums.validation.error.artworkUrl.url'),
            'artworkUrl.max'        =>  __('albums.validation.error.artworkUrl.max'),
            'artistsIds.required'   =>  __('albums.validation.error.artistsIds.required'),
            'artistsIds.array'      =>  __('albums.validation.error.artistsIds.array'),
            'artistsIds.*.integer'  =>  __('albums.validation.error.artistId.integer'),
            'artistsIds.*.distinct' =>  __('albums.validation.error.artistId.distinct'),
            'artistsIds.*.exists'   =>  __('albums.validation.error.artistId.exists'),
        ];
    }
}
