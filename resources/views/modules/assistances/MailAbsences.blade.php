<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>

<body>
  <h6 style="background-color: hsla(209, 71%, 42%, 0.49); padding: 1rem; color: ivory;">BUENOS DIAS</h6>
  <br>
  <p>¡Hola! {{$nameFather}}, {{$nameMother}}</p>
  <br>
  <p>Extrañamos a {{$nameStudent}} esperamos que se encuentre bien de salud y por favor cuéntanos porque no asistió a su jardín….</p>
  <br>
  <p>¡Lo esperamos con toda la felicidad! Cordial saludo,</p>
  <br>
  <p>{{$nameGarden}}</p>
  <hr>
  <img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 100px; height: auto;"><br>
</body>

</html>