<?php
return [
    'titles' => [
        'title'         => 'title',
        'song'          => 'Song',
        'imgSong'       => 'Image Song',
        'artistsIds'    => 'artists Ids',
        'artistId'      => 'id',
        'albumId'       => 'Album',
    ],
    'validation' => [
        'error'     => [
            'title'         => [
                'required'      => ':attribute is required',
                'string'        => 'The :attribute must be string',
                'max'           => 'The :attribute must be less than 255 letters',
                'min'           => 'The :attribute must be more than 2 letters',
            ],
            'song'          => [
                'required'      => ':attribute is required',
                'mimetypes'     => 'The :attribute must be with any mine mpga, mp2, mp2a, mp3, m2a, m3a, oga, ogg, spx, opus',
                'max'           => 'The :attribute must be less than or equal 10 MB',
            ],
            'imgSong'       => [
                'required'      => ':attribute is required',
                'image'         => ':attribute is required',
                'mimetypes'     => 'The :attribute must be with any mine jpeg, png, jpg',
                'max'           => 'The :attribute must be less than 2 MB',
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
            'albumId'       => [
                'exists'        => 'The :attribute not found artist',
                'integer'       => ':attribute must be integer',
            ]
        ]
    ]

];
