<table>
    <thead>
    <tr>
        <th style="border: 1px solid #000000;background-color: #00B0F0; font-weight: bold; text-align: center;">ID</th>
        <th style=" border: 1px solid #000000;background-color: #00B0F0; font-weight: bold; text-align: center;">NOMBRE</th>
        <th style="border: 1px solid #000000;background-color: #00B0F0; font-weight: bold; text-align: center;">EMAIL</th>
        <th style="border: 1px solid #000000;background-color: #00B0F0; font-weight: bold; text-align: center; ">ROL</th>
        <th style="border: 1px solid #000000;background-color: #00B0F0; font-weight: bold; text-align: center; ">ESTATUS</th>
        <th style="border: 1px solid #000000;background-color: #00B0F0; font-weight: bold; text-align: center; ">REGISTRO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td style="border: 1px solid #000000; text-align: center">{{ $user->id }}</td>
            <td style="border: 1px solid #000000; text-align: center">{{ ucwords($user->name) }}</td>
            <td style="border: 1px solid #000000; text-align: center">{{ $user->email }}</td>
            <td style="border: 1px solid #000000; text-align: center">{{ verRole($user->role, $user->roles_id) }}</td>
            <td style="border: 1px solid #000000; text-align: center">{!! verEstatusUsuario($user->estatus)  !!}</td>
            <td style="border: 1px solid #000000; text-align: center">{{ verFecha($user->created_at) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{{--@if($img)
    <img src="{{ asset('img/qrcodes/qrcode.svg') }}">
@endif--}}
