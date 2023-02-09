<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Empresa</th>
            <th>Tipo_jurado</th>
            <th>Email</th>
            <th>Aceptacion</th>
        </tr>
    </thead>
    <tbody>
        
    if(count($jurados)>0){
        @foreach($jurados as $jurado)
        <tr>
            <td>{{$jurado->Nombre}}</td>
            <td>{{$jurado->Empresa}}</td>
            <td>{{$jurado->Tipo_jurado}}</td>
            <td>{{$jurado->Email}}</td>
            <td>{{$jurado->aceptacion}}</td>
        </tr>
        @endforeach
    }else{
        <tr>
            <td>No hay datos</td>
        </tr>
    }
        
        
    </tbody>

</table>