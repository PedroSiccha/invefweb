<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invef | Acceso</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg" background="{{asset('img/INVEF.jpg')}}" style="background-size: cover;">

    <div class="middle-box text-center loginscreen animated fadeInDown" style="position: relative; right: 0%; top: 25%;">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">
                    <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="off" placeholder="Usuario" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Contraseña">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Acceder</button>
                    </form>
                    <p class="m-t">
                        <small>Inforad 2019</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Desarrollado por InfoRad
            </div>
            <div class="col-md-6 text-right">
               <small>© 2019</small>
            </div>
        </div>
    </div>

</body>

</html>
