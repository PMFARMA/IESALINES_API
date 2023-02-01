<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario Email</title>
</head>
<body>
    <form action="{{route('storemail')}}" method="post">
        @csrf {{--En laravel por motivos de seguridad es necesario verificar formularios con un token, al agregar este comando Laravel pone un campo oculto con el token permitiendo el acceso  --}}
        <p><strong>Enviar invitación a</strong></p>
        <textarea name="emailtomsg">bla@bla.bla</textarea>
        <p><strong>Asunto:</strong></p>
        <textarea name="asuntomsg">{{old('asuntomsg')}}</textarea>
        <p><strong>Contenido:</strong></p>
        <textarea name="textomsg">{{old('textomsg')}}</textarea>
        <button>Enviar</button>
    </form>
</body>
</html>