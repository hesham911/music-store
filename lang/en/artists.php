<?php
return [
    'titles' => [
        'UserId'    => 'user',
        'bio'       => 'bio',
        'name'      => 'name',
    ],
    'validation' => [
        'error'     => [
            'user'      => [
                'required'  => 'You should Be :attribute, register and come again',
                'exists'    => 'You try to create artist does\'t exist :attribute',
            ],
            'bio'       => [
                'required'  => ':attribute is required',
                'string'    => 'The :attribute must be string',
                'max'       => 'The :attribute must be less than 255 letters',
                'min'       => 'The :attribute must be more than 10 letters',
            ],
            'name'      => [
                'required'  => ':attribute is required',
                'string'    => 'The :attribute must be string',
                'max'       => 'The :attribute must be less than 255 letters',
                'min'       => 'The :attribute must be more than 2 letters',
            ],
        ]
    ]

];
