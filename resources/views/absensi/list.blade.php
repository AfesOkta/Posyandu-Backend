@extends('layouts.backend')

@section('title', 'Data Absensi')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection

@section('content')
<x-section-header heading="Absensi" breadcrumb="Absensi" />

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
            <b>Daftar Absensi<b>
            <button class="btn btn-primary dropdown-toggle float-right" type="button"
                    data-toggle="dropdown"><i class="fas fa-plus-square"></i>
                <span class="caret"></span></button>
            <div class="dropdown-menu dropdown-menu-puskesmas dropdown-menu-right" role="menu">
                <a class="dropdown-item" role="presentation"
                    href="javascript:void(0)" onClick="open_container();" title="Cetak Absensi">Cetak</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-1" style="width:100%">
                    <thead>
                        <th class="text-center thColor">
                        #
                        </th>
                        <th class="tdLeft thColor">Kode Posyandu</th>
                        <th class="tdLeft thColor">Nama Anggota/Kader</th>
                        <th class="tdLeft thColor">Masuk</th>
                        <th class="tdLeft thColor">Pulang</th>
                        <th class="tdCenter thColor">Action</th>
                    </thead>
                    <tbody>
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
@endsection

@section('js')
<script>
    $(function () {
        let groupColumn = 1;
        var table = $('#table-1').DataTable({
            //dom: '<"col-md-6"l><"col-md-6"f>rt<"col-md-6"i><"col-md-6"p>',
            processing: true,
            serverSide: true,
            method: 'get',
            ajax: '{{route('absensi.json')}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                {data: 'posyandu.posyandu_nama', name: 'posyandu.posyandu_nama', searchable: true, orderable: true},
                {data: 'anggota', name: 'anggota', searchable: true, orderable: true},
                {data: 'masuk', name: 'masuk', searchable: true, orderable: true},
                {data: 'pulang', name: 'pulang', searchable: true, orderable: true},
                {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
            ],
            "columnDefs": [
                { "visible": false, "targets": groupColumn }
            ],
            "order": [[ groupColumn, 'asc' ]],
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group text-bold"><td colspan="5"> '+group+'</td></tr>'
                        );

                        last = group;
                    }
                } );
            },
        });
    });
</script>
@endsection
