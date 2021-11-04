<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title style="background-color: hsla(228, 79%, 53%, 0.52); padding: 1rem; color: ivory;">{{ $subject ." - ". mb_strtoupper(config('app.name')) }}</title>
</head>

<body>
  <hr>
  <h6 style="background-color: hsla(209, 71%, 42%, 0.49); padding: 1rem; color: ivory;">BUENOS DIAS</h6>
  <p style="margin: 1rem;">{{$hi->sch_body}}</p>
  <p style="margin: 1rem;">{{$cont}}</p>
  <br>
  Atentamente,<br>
  Erika Patricia Pertuz<br>
  Directora Administrativa</p>
  <hr>
  <img src="{{ asset('storage/garden/logo.jpg') }}" style="width: 100px; height: auto;"><br>
  <hr>
  <div style="max-width: fit-content; font-size: 12px; border: 1px solid hsla(26,65%,42%,0.75);">
    <p style="background-color: hsla(26, 65%, 42%, 0.75); padding: 0.3rem; color: ivory;">Archivos Adjuntos </p>
    <ul style="margin-right: 1rem;">
      @forEach($NameFiles as $Name)
      <li>{{$Name}}</li>
      @endforeach
    </ul>
  </div>
</body>

</html>