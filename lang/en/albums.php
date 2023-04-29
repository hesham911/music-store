<?php
return [
    'titles' => [
        'title'         => 'title',
        'artworkUrl'    => 'artwork Url',
        'artistsIds'    => 'artists Ids',
        'artistId'      => 'id',
    ],
    'validation' => [
        'error'     => [
            'title'         => [
                'required'      => ':attribute is required',
                'string'        => 'The :attribute must be string',
                'max'           => 'The :attribute must be less than 255 letters',
                'min'           => 'The :attribute must be more than 2 letters',
            ],
            'artworkUrl'    => [
                'required'      => ':attribute is required',
                'url'           => 'The :attribute must be url',
                'max'           => 'The :attribute must be less than 255 letters',
            ],
            'artistsIds'    => [
                'required'      => ':attribute is required',
                'array'         => 'The :attribute must be array',
            ],
            'artistId'      => [
                'integer'       => ':attribute must be integer',
                'distinct'      => 'The :attribute must be unique',
                'exists'        => 'The :attribute not found artist',
            ],
        ]
    ]

];
