@extends('layouts.backend')

@section('title', 'Data Absensi')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

<style>
    .daterangepicker{ z-index:99999 !important; }
</style>
@endsection

@section('content')
<x-section-header heading="Absensi" breadcrumb="Absensi" />

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
            <b>Daftar Absensi<b>
            <a class="btn btn-primary float-right" href="{{route('absensi')}}" ><i class="fas fa-back"></i>
            <span>Kembali</span></a>
        </div>
    </div>
    <div class="card-body">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <p><h4>{{$posyandu[0]->posyandu_nama}} ({{$posyandu[0]->posyandu_kode}})</h4></p>
                    @if( $status == 1 )
                        <p>Nama Kader    {{$kader->kader_nama}} ({{$kader->kader_kode}}</p>
                    @endif
                    @if ($status == 0)
                        <p>Nama Anggota    {{$lansia->lansia_nama}} ({{$lansia->lansia_kode}})</p>
                    @endif

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-1" style="width:100%">
                    <thead>
                        <th class="tdLeft thColor">Tanggal</th>
                        <th class="tdLeft thColor">Jam Masuk</th>
                        <th class="tdLeft thColor">Jam Pulang</th>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data )
                            <tr>
                                <td style="text-align:left">{{date("d-m-Y", strtotime($data->tanggal))}}</td>
                                <td style="text-align:left">{{date("h:i", strtotime($data->jam_msk))}}</td>
                                <td style="text-align:left">{{date("h:i", strtotime($data->jam_plg))}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('plugin')
    <script src="{{asset('stisla/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('stisla/modules/select2/dist/js/select2.js')}}"></script>
    <script src="{{asset('stisla/modules/jquery-toast/jquery.toast.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{asset('stisla/modules/cleave-js/dist/cleave.min.js')}}"></script>
    <script src="{{asset('stisla/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('stisla/js/page/forms-advanced-forms2.js')}}"></script>
@endsection

@section('js')

@endsection
