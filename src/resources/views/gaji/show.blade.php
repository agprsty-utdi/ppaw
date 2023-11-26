@extends('adminlte::page')
@section('title', 'Gaji Pegawai')
@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Gaji Pegawai</li>
        </ol>
    </nav>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                <h3>Gaji Pegawai</h3>
                            </span>
                        </div>
                    </div>
                    <font size="4" face="Arial">
                        <table align="center" width="60%">
                            <tr>
                                <td>NIP </td>
                                <td> : {{ $gaji->pegawai_id }} </td>
                            </tr>
                            <tr>
                                <td>Nama </td>
                                <td> : {{ \App\Models\Pegawai::find($gaji->pegawai_id)->nama }} </td>
                            </tr>
                            <tr>
                                <td>Bulan/Tahun </td>
                                <td> : {{ date('F', mktime(0, 0, 0, $gaji->bulan, 1)).'/'.$gaji->tahun }} </td>
                            </tr>
                        </table>
                    </font>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Gaji Pokok</td>
                                            <td>{{ number_format($gaji->gaji_pokok) }}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Tunjungan</td>
                                            <td>{{ number_format($gaji->tunjangan) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <td>{{ number_format(($gaji->gaji_pokok + $gaji->tunjangan)) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Potongan</td>
                                            <td>{{ number_format($gaji->potongan) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ number_format(($gaji->gaji_pokok + $gaji->tunjangan) - $gaji->potongan) }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
