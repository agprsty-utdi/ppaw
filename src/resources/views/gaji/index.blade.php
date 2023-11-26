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
                            <div class="float-right">
                                @include('gaji.search', ['url' => 'gaji', 'link' => 'gaji'])
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <font size="4" face="Arial">
                        <table align="center" width="60%">
                            <tr>
                                <td>Tahun </td>
                                <td> : {{ request()->get('tahun') ? ucfirst(request()->get('tahun')):"All" }} </td>
                            </tr>
                            <tr>
                                <td>Bulan </td>
                                <td> : {{ request()->get('bulan') && request()->get('bulan') != 'all' ? date('F', mktime(0, 0, 0, request()->get('bulan'), 1)):"All" }} </td>
                            </tr>
                        </table>
                    </font>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Gaji Pokok</th>
                                        <th>Tunjangan</th>
                                        <th>Potongan</th>
                                        <th>Total</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Cetak</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($gaji as $gj)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $gj->pegawai_id }}</td>
                                            <td>{{ \App\Models\Pegawai::find($gj->pegawai_id)->nama }}</td>
                                            <td>{{ number_format($gj->gaji_pokok) }}</td>
                                            <td>{{ number_format($gj->tunjangan) }}</td>
                                            <td>{{ number_format($gj->potongan) }}</td>
                                            <td>{{ number_format(($gj->gaji_pokok + $gj->tunjangan) - $gj->potongan) }}</td>
                                            <td>{{ date('F', mktime(0, 0, 0, $gj->bulan, 1)).'/'.$gj->tahun }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary "
                                                    href="{{ route('gaji.show', $gj->id) }}">
                                                    <i class="fa fa-fw fa-print"></i> Cetak</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $gaji->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
@endsection
