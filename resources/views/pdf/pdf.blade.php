<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formato de Entrega o Mejora</title>
    <style>
        h1 {
            font-size: 20px;
            font-weight: bold;
        }

        p {
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #ccc;
        }

        .t-header {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            background-color: #ccc;
            font-weight: bold;
        }

        .tx-left {
            text-align: left;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            width: 100%;

        }
    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <td>Hospital Vicente Dantoni</td>
                <td>Entrega de Equipo</td>
                <td>Pagina CALCULAR PAGINA</td>
            </tr>
            <tr>
                <td>Área:
                    @foreach ($records as $record)
                        {{ $record->device->ubication }}
                    @endforeach
                </td>
                <td>Fecha de Vigencia: CALCULA (AUN NO SE COMO)</td>
                <td>Numero de Revision (QUE?)</td>
            </tr>
            {{-- <tr>
                <td>Politica (  )       Procedimiento (  )      Instructivo (  )</td>
            </tr> --}}
        </table>
    </header>

    <h1>{{ $record->type }} de Equipo </h1>
    <hr>
    <div class="t-header">
        Datos del Colaborador
    </div>
    <table>
        <tr>
            <th>Nombre</th>
            <td>{{ $record->partner->name }}</td>
            <th>Cargo</th>
            <td>{{ $record->partner->company_position }}</td>
            <th>Usuario de red</th>
            <td>{{ $record->partner->username_network }}</td>
        </tr>
        <tr>
            <th>Teléfono/Ext.</th>
            <td>{{ $record->partner->extension }}</td>
            <th>Correo</th>
            <td>{{ $record->partner->email }}</td>
            <th>Área</th>
            <td>{{ $record->partner->department->name }}</td>
        </tr>
    </table>
    <div class="t-header">
        Equipo Asignado: {{ $record->device->name }}
    </div>
    <br>
    <div class="t-header">
        Hardware
    </div>
    <table>
        <tr>
            <th>No.</th>
            <th>Pieza o Equipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>No. Activo</th>
            <th>No.Serie</th>
        </tr>
        {{-- Ciclo FOR PARA LAS PIEZAS --}}
        {{ $i = 1 }}
        @foreach ($record->device_change as $change)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $change->name }}</td>
                <td>{{ $change->brand->name }}</td>
                <td>{{ $change->model->name }}</td>
                <td>{{ $change->asset_number }}</td>
                <td>{{ $change->serial_number }}</td>
            </tr>
        @endforeach
        {{-- <td>{{ $record->device_change->brand_id }}</td>
                <td>{{ $record->device_change->model_id }}</td> --}}
        {{-- <td>{{ $record->device->asset_number }}</td>
                <td>{{ $record->device->serial_number }}</td> --}}
        {{-- <p>{{ $record->device_change }}</p> --}}


    </table>
    <br>
    <div class="t-header">
        Observaciones
    </div>
    <table>
        <tr>
            <td style="text-align: justify">Certifico que los elementos detallados en el presente documento me han sido
                entregados para mi cuidado y
                custodia con el propósito de cumplir con las tareas y asignaciones propias de mi cargo en la
                organización, siendo estos de mi única y exclusiva responsabilidad.
                <br>
                Me comprometo a usar correctamente los recursos, y solo para los fines establecidos, a no instalar o
                permitir la instalación de software o hardware por personal ajeno al departamento de IT.
            </td>
        </tr>
        <tr>
            <td>
                <b>{{ $record->description }}</b>
            </td>
        </tr>
    </table>
    <br>
    <div class="t-header">
        {{ $record->type }} de Equipo
    </div>
    <table>
        <tr>
            <th>Recibe</th>
            <th>Entrega</th>
        </tr>
        <tr>
            <td class="tx-left">Nombre: {{ $record->partner->name }}</td>
            <td class="tx-left">Nombre: Anibal Moradel</td>
        </tr>
        <tr>
            <td class="tx-left">Firma: </td>
            <td class="tx-left">Firma: </td>
        </tr>
        <tr>
            <td class="tx-left">Fecha: {{ $record->created_at }}</td>
            <td class="tx-left">Fecha: {{ $record->created_at }}</td>
        </tr>
    </table>
    <br>
    <footer>
        <table>
            <tr>
                <td>Preparado Por: <br>Anibal Moradel</td>
                <td>Revisado Por: <br>Sandra Gonzales</td>
                <td>Aprobado Por: <br>Hugo Cabrera</td>
            </tr>
        </table>
    </footer>
</body>

</html>
