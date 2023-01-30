<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario Email</title>
</head>
<body>
    <form action="{{route('email')}}" method="get">
        <p><strong>Enviar invitación a</strong></p>
        <p><strong>Asunto:</strong></p>
        <textarea name="asuntotest">{{old('content')}}</textarea>
        <p><strong>Contenido:</strong></p>
        <textarea name="emailtest">{{old('content')}}</textarea>
        <button>Enviar</button>
    </form>
</body>
</html>