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

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
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

];
