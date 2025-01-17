<?php

namespace App\Http\Requests\Api\Artists;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateArtistRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'user_id'   => ['required', Rule::exists('users','id')],
            'bio'       => 'required|string|min:10|max:255',
            'name'      => 'required|string|min:2|max:255'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id'    => $this->userId,
            'bio'        => $this->bio,
            'name'       => $this->name,
        ]);
    }

    public function attributes(): array
    {
        return [
            'userId'         => __('artists.titles.UserId'),
            'bio'            => __('artists.titles.bio'),
            'name'           => __('artists.titles.name'),
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
            'userId.required'   =>  __('artists.validation.error.user.required'),
            'userId.exists'     =>  __('artists.validation.error.user.exists'),
            'bio.required'      =>  __('artists.validation.error.bio.required'),
            'bio.string'        =>  __('artists.validation.error.bio.string'),
            'bio.min'           =>  __('artists.validation.error.bio.min'),
            'bio.max'           =>  __('artists.validation.error.bio.max'),
            'name.required'     =>  __('artists.validation.error.name.required'),
            'name.string'       =>  __('artists.validation.error.name.string'),
            'name.min'          =>  __('artists.validation.error.name.min'),
            'name.max'          =>  __('artists.validation.error.name.max'),

        ];
    }

}
