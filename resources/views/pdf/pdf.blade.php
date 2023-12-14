<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formato de Entrega o Mejora</title>
    <style>
        body {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif
        }

        @page {
            margin-top: 8cm;
            margin-bottom: 10cm;
        }

        #header {
            position: fixed;
            width: 100%;
            top: -6.5cm;
        }

        #footer {
            position: fixed;
            left: 0px;
            right: 0px;
            height: 40px;
            bottom: 0.5cm;
        }

        h1 {
            font-size: 20px;
            font-weight: bold;
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
            background-color: green;
            color: white;
        }

        .t-header {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            background-color: green;
            color: white;
            font-weight: bold;
        }

        .tx-left {
            text-align: left;
        }

        .font-sm {
            font-size: 10px;
        }

        .font-m {
            font-size: 12px;
        }

        .pagenum:before {
            content: counter(page);
        }

        .page-break {
            page-break-before: always;
            margin-top: -2.5cm;
        }
    </style>
</head>

<body>
    {{-- Header --}}

    <header id="header">
        <table class="font-sm">
            <tr>
                <td>Hospital Vicente Dantoni</td>
                <td>Entrega de Equipo</td>
                <td>Número de Pagina: <span class="pagenum"></span></td>
            </tr>
            <tr>
                <td>Área:
                    @foreach ($records as $record)
                        {{ $record->partner->department->name }}
                    @endforeach
                </td>
                <td>Fecha de Vigencia: 10 de Octubre de 2020</td>
                <td>Numero de Revision: #1</td>
            </tr>
            <tr>
                <td>Politica ( )</td>
                <td>Procedimiento ( )</td>
                <td>Instructivo ( )</td>
            </tr>
        </table>

        <h1>1. {{ $record->type }} de Equipo </h1>
        <hr>
        <div class="t-header">
            Datos del Colaborador
        </div>
        {{-- Tabla que muestra los datos del empleado/partner --}}
        <table>
            <tr>
                <th>Nombre</th>
                <td>{{ $record->partner->name }}</td>
                <th>Cargo</th>
                <td>{{ $record->partner->job_position }}</td>
                <th>Usuario de red</th>
                <td>{{ $record->partner->username_network }}</td>
            </tr>
            <tr>
                <th>Correo</th>
                <td>{{ $record->partner->email }}</td>
                <th>Área</th>
                <td>{{ $record->partner->department->name }}</td>
                <th>Teléfono/Ext.</th>
                <td>{{ $record->partner->extension }}</td>
            </tr>
        </table>
        {{-- Fin de los datos --}}
    </header>
    {{-- End Header --}}

    {{-- Footer --}}
    <div id="footer">
        <div class="t-header">
            Observaciones
        </div>
        <table>
            <tr>
                <td style="text-align: justify">Certifico que los elementos detallados en el presente documento me
                    han
                    sido
                    entregados para mi cuidado y
                    custodia con el propósito de cumplir con las tareas y asignaciones propias de mi cargo en la
                    organización, siendo estos de mi única y exclusiva responsabilidad.
                    <br>
                    Me comprometo a usar correctamente los recursos, y solo para los fines establecidos, a no
                    instalar o
                    permitir la instalación de software o hardware por personal ajeno al departamento de IT.
                </td>
            </tr>
            <tr>
                <td class="tx-left font-m">
                    <b>{{ ucfirst($record->description) }}</b>
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
                <th>{{ $record->type }}</th>
            </tr>
            <tr>
                <td class="tx-left">Nombre: {{ $record->partner->name }}</td>
                <td class="tx-left">Nombre: {{ ucwords(auth()->user()->name) }}</td>
            </tr>
            <tr>
                <td class="tx-left">Firma: </td>
                <td class="tx-left">Firma: </td>
            </tr>
            <tr>
                <td class="tx-left">Fecha: </td>
                <td class="tx-left">Fecha: {{ now()->format('d-m-Y') }}</td>
            </tr>
        </table>
        <br>
        <table class="font-sm">
            <tr>
                <td>Preparado Por: <br>Anibal Moradel</td>
                <td>Revisado Por: <br>Sandra Gonzales</td>
                <td>Aprobado Por: <br>Hugo Cabrera</td>
            </tr>
        </table>
    </div>
    {{-- End Footer --}}

    {{-- Tabla que muestra los datos de las entregas/mejoras --}}
    <div class="">
        <div class="t-header">
            Hardware
        </div>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pieza o Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>No. Activo</th>
                    <th>No.Serie</th>
                </tr>
            </thead>
            <tbody class="font-m">
                {{-- Ciclo FOR PARA LAS PIEZAS --}}
                {{ $i = 1 }}
                @foreach ($record->devices as $device)
                    <tr class="@if ($i % 6 === 0) page-break @endif">
                        <td>{{ $i++ }}</td>
                        <td> {{ $device->name }}</td>
                        <td> {{ $device->brand->name }}</td>
                        <td> {{ $device->model->name }}</td>
                        <td> {{ $device->asset_number }}</td>
                        <td> {{ $device->serial_number }}</td>
                    </tr>
                @endforeach
                @foreach ($record->device_change as $change)
                    <tr class="@if ($i % 6 === 0) page-break @endif">
                        <td>{{ $i++ }}</td>
                        <td>{{ $change->name }}</td>
                        <td>{{ $change->brand->name }}</td>
                        <td>{{ $change->model->name }}</td>
                        <td>{{ $change->asset_number }}</td>
                        <td>{{ $change->serial_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table>
            <tr>
                <td><b>*** ULTIMA LINEA ***</b></td>
            </tr>
        </table>
        <br>
    </div>
</body>

</html>
