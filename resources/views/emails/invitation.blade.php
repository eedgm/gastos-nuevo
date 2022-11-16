<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitación</title>
</head>
<body>
    <h1>Manejo de gastos</h1>

    <p>Este correo contiene un link con una invitación para poder crear su usuario para manejar sus gastos.</p>

    <p>La intensión del mismo es que la información sea enteramente de uso personal y nadie mas tiene acceso a la misma.</p>

    <p>A continuación puede dar click a este link:</p>

    <p><a href="{{ route('register', ['email' => $details['email'], 'permission' => $details['permission']]) }}">Registrarse</a></p>


</body>
</html>
