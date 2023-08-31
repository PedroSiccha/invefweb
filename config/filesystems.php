<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],
        'perfil' => [
            'driver' => 'local',
            'root' => public_path('img/perfil'),
            'visibility'=> 'public',
        ],
        'perfilEmpleado' => [
            'driver' => 'local',
            'root' => public_path('img/perfilEmpleado'),
            'visibility'=> 'public',
        ],
        'pagosGa' => [
            'driver' => 'local',
            'root' => public_path('img/pagosGa'),
            'visibility'=> 'public',
        ],
        'pagosBanco' => [
            'driver' => 'local',
            'root' => public_path('img/pagosBanco'),
            'visibility'=> 'public',
        ],
        'notifiPrestamo' => [
            'driver' => 'local',
            'root' => public_path('img/notifiPrestamo'),
            'visibility'=> 'public',
        ],
        'banner' => [
            'driver' => 'local',
            'root' => public_path('img/banner'),
            'visibility'=> 'public',
        ],
        'resumenEmpresa' => [
            'driver' => 'local',
            'root' => public_path('img/resumenEmpresa'),
            'visibility'=> 'public',
        ],
        'bannerNosotros' => [
            'driver' => 'local',
            'root' => public_path('img/bannerNosotros'),
            'visibility'=> 'public',
        ],
        'detalleNosotros' => [
            'driver' => 'local',
            'root' => public_path('img/detalleNosotros'),
            'visibility'=> 'public',
        ],
        'imgNosotros' => [
            'driver' => 'local',
            'root' => public_path('img/imgNosotros'),
            'visibility'=> 'public',
        ],
        'bannerServicio' => [
            'driver' => 'local',
            'root' => public_path('img/bannerServicio'),
            'visibility'=> 'public',
        ],
        'imgServicio' => [
            'driver' => 'local',
            'root' => public_path('img/imgServicio'),
            'visibility'=> 'public',
        ],
        'bannerPregunta' => [
            'driver' => 'local',
            'root' => public_path('img/bannerPregunta'),
            'visibility'=> 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
