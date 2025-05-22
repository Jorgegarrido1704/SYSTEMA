@extends('layouts.main')

@section('contenido')
<link rel="stylesheet" href="{{ asset('/dash/css/vacaciones.css') }}">
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

<!-- First Period -->
<div class="row">
    <div class="col-lg-12 col-lx-12 mb-4">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Enginners</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <input type="text" name="cervera" id="cervera" value="Jesus Cervera" readonly>
                        <input type="text" name="rodriguez" id="rodriguez" value="Carlos Rodriguez" readonly>
                        <input type="text" name="aldana" id="aldana" value="Nancy Aldana" readonly>
                        <input type="text" name="silva" id="silva" value="Paola Silva" readonly>
                        <input type="text" name="santos" id="santos" value="Arturo Santos" readonly>
                        <input type="text" name="garrido" id="garrido" value="Jorge Garrido" readonly>
                    </div>
                </div>
    </div>
</div>
<!-- First Period -->
<div class="row">
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">January</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['1'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['1'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td id="{{ $dia['vacas'] }}">{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['1']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">February</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['2'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['2'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['2']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">March</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['3'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['3'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['3']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">April</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['4'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['4'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['4']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">May</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['5'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['5'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['5']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">June</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['6'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['6'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['6']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>

</div>
<!-- Second Period -->
<div class="row">
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">July</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['7'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['7'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['7']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">August</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['8'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['8'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['8']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">September</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['9'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['9'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['9']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">October</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['10'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['10'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['10']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">November</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['11'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['11'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['11']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>
    <div class="col-lg-2 col-lx-2 mb-2">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">December</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    @foreach (collect($diasAviles['12'])->take(5) as $dia)
                                     <td>  {{ $dia['Dia'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($diasAviles['12'] as $index => $dia)
                                    @if ($index % 5 === 0)
                                        <tr>
                                    @endif
                                    <td>{{ $dia['dia'] }}</td>
                                    @if (($index + 1) % 5 === 0 || $index + 1 === count($diasAviles['12']))
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
    </div>

</div>


@endsection
