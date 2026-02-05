<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Vehículo</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        /* Logo en la esquina superior izquierda */
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
        }

        /* Título centrado */
        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* gris claro */
            /* Si quieres amarillo, reemplaza por: background-color: #fff176; */
        }

        td div {
            margin-bottom: 2px; /* para separar usuarios */
        }
    </style>
</head>
<body>

    <!-- Logo -->
    <img src="{{ public_path('images/logo_hr.svg') }}" alt="Logo" class="logo">

    <!-- Título centrado -->
    <h2>REPORTE DE VEHÍCULO</h2>
    <br>
    <br>
    <br>

    @if(count($datos) > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vehículo</th>
                    <th>Propietario</th>
                    <th>Dispositivo</th>
                    <th>Fecha</th>
                    <th>Usuarios</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td> <!-- numeración -->
                        <td>{{ $r['vehiculo'] }}</td>
                        <td>{{ $r['dueno'] }}</td>
                        <td>{{ $r['dispositivo'] }}</td>
                        <td>{{ $r['fecha'] }}</td>
                        <td>
                            @if(!empty($r['usuarios']))
                                @foreach($r['usuarios'] as $usuario)
                                    <div>{{ $usuario }}</div>
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontraron registros con los filtros seleccionados.</p>
    @endif

</body>
</html>
