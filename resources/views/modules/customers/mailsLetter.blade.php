<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>RECORDATORIO</title>
</head>
<body>
	<h3>!HOLA <b><?php echo $datesMail[0][0]; ?></b>!</h3><br>
	<p style="text-align: justify; font-size: 12px; color: #000; padding: 20px; border: 1px solid green;">
		Recuerda que te esperamos el día <b><?php echo $datesMail[0][1] . ' ' . $datesMail[0][2]; ?></b> a las <b><?php echo $datesMail[0][3]; ?></b> en nuestra sede para tener el gusto de conocernos y mostrarte nuestras instalaciones y programa de estimulación. 
		Queremos compartir con <b><?php echo $datesMail[0][4]; ?></b>  un momento de diversión y entretenimiento 
		Te esperamos en: <?php echo $datesMail[0][6]; ?>.<br>
		Cordial saludo,
	</p><br>
	<img src="{{ asset('storage/garden/logo.png') }}" style="width: 100px; height: auto;"><br>
	<h4><?php echo $datesMail[0][5]; ?></h4>
	<h4><?php echo $datesMail[0][7]; ?></h4>
</body>
</html>