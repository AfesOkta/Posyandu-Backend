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
        <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item">
            <a class="nav-link active show" id="anggota-tab2" data-toggle="tab" href="#anggota" role="tab" aria-controls="anggota"
                aria-selected="false">Anggota</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" id="kader-tab2" data-toggle="tab" href="#kader" role="tab" aria-controls="profile"
                aria-selected="false">Kader</a>
            </li>
        </ul>
        <div class="tab-content tab-bordered" id="myTab3Content">
            <div class="tab-pane fade active show" id="anggota" role="tabpanel" aria-labelledby="home-tab2">
                <div class="form-group cetak">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label for="form-input-posyandu">Kode Posyandu</label>
                            <select id="posyandu_id" name="posyandu_id" class="form-control posyandu_id">
                                <option value="">Silahkan pilih Posyandu</option>
                                    @foreach($posyandus as $posyandu)
                                <option value="{{ $posyandu->posyandu_kode }}" data-name="{{$posyandu->posyandu_nama}}">{{ $posyandu->posyandu_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <label for="form-input-posyandu">Range Tanggal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                </div>
                                <input type="text" class="form-control daterange-cus">
                                <button type="button" class="btn btn-primary cetak" id="cetak_anggota" style="margin-right: 2px">Cetak <i class="fab fa-print ml-1"></i></button>
                                <button type="button" class="btn btn-primary batal" id="batal">Batal <i class="fab fa-close ml-1"></i></button>
                            </div>
                        </div>
                    </div>

                    <hr/>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="table-1" style="width:100%">
                            <thead>
                                <th class="text-center thColor">
                                #
                                </th>
                                <th class="tdLeft thColor">Kode Posyandu</th>
                                <th class="tdLeft thColor">Nama Anggota</th>
                                <th class="tdLeft thColor">Tanggal</th>
                                <th class="tdLeft thColor">Jam Masuk</th>
                                <th class="tdLeft thColor">Jam Pulang</th>
                                <th class="tdCenter thColor">Action</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="kader" role="tabpanel" aria-labelledby="profile-tab2">
                <div class="form-group cetak">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label for="form-input-posyandu">Kode Posyandu</label>
                            <select id="posyandu_id" name="posyandu_id" class="form-control posyandu_id">
                                <option value="">Silahkan pilih Posyandu</option>
                                    @foreach($posyandus as $posyandu)
                                <option value="{{ $posyandu->posyandu_kode }}" data-name="{{$posyandu->posyandu_nama}}">{{ $posyandu->posyandu_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <label for="form-input-posyandu">Range Tanggal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                </div>
                                <input type="text" class="form-control daterange-cus">
                                <button type="button" class="btn btn-primary cetak" id="cetak_kader" style="margin-right: 2px">Cetak <i class="fab fa-print ml-1"></i></button>
                                <button type="button" class="btn btn-primary batal" id="batal">Batal <i class="fab fa-close ml-1"></i></button>
                            </div>
                        </div>
                    </div>

                    <hr/>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="table-2" style="width:100%">
                            <thead>
                                <th class="text-center thColor">
                                #
                                </th>
                                <th class="tdLeft thColor">Kode Posyandu</th>
                                <th class="tdLeft thColor">Nama Kader</th>
                                <th class="tdLeft thColor">Tanggal</th>
                                <th class="tdLeft thColor">Jam Masuk</th>
                                <th class="tdLeft thColor">Jam Pulang</th>
                                <th class="tdCenter thColor">Action</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
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
<script>
    $(function () {
        let startDate;
        let endDate;
        var collapsedGroups = [];
        var groupParent = [];
        var counter = 1;
        $('.cetak').hide();
        let groupColumn1 = 1;
        let groupColumn2 = 2;
        var table1 = $('#table-1').DataTable({
            //dom: '<"col-md-6"l><"col-md-6"f>rt<"col-md-6"i><"col-md-6"p>',
            processing: true,
            serverSide: true,
            method: 'get',
            ajax: '{{route('absensi.json.anggota')}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                {data: 'posyandu_nama', name: 'posyandu_nama', searchable: true, orderable: true},
                {data: 'nama', name: 'nama', searchable: true, orderable: true},
                {data: 'tanggal', name: 'tanggal', searchable: true, orderable: true},
                {data: 'jam_msk', name: 'jam_msk', searchable: true, orderable: true},
                {data: 'jam_plg', name: 'jam_plg', searchable: true, orderable: true},
                // {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
            ],
            columnDefs: [
                { "visible": false, "targets": [1,2] }
            ],
            // "order": [[ groupColumn, 'asc' ]],
            order: [[1, 'asc'], [2, 'asc']],
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                var json = api.ajax.json();
                api.column(groupColumn1, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group text-bold"><td colspan="5"> '+group+'</td></tr>'
                        );

                        last = group;
                    }
                } );
                api.column(groupColumn2, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        var col = api.ajax.json().data;
                        url = btoa(col[i].posyandu_kode+'&'+col[i].kode);
                        $(rows).eq( i ).before(
                            '<tr class="group text-bold">'+
                                '<td colspan="4"> &nbsp;&nbsp;&nbsp;'+ group+'</td>'+
                                '<td style="text-align:center">'+
                                    '<a href="absensi/view-anggota/'+url+'"'+
                                    ' title="View '+col[i].nama+'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-search">&nbsp;View</i></a>'+
                                '</td>'+
                            '</tr>'
                        );
                        last = group;
                    }
                } );
            },
        });

        var table2 = $('#table-2').DataTable({
            //dom: '<"col-md-6"l><"col-md-6"f>rt<"col-md-6"i><"col-md-6"p>',
            processing: true,
            serverSide: true,
            method: 'get',
            ajax: '{{route('absensi.json.kader')}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                {data: 'posyandu_nama', name: 'posyandu_nama', searchable: true, orderable: true},
                {data: 'nama', name: 'nama', searchable: true, orderable: true},
                {data: 'tanggal', name: 'tanggal', searchable: true, orderable: true},
                {data: 'jam_msk', name: 'jam_msk', searchable: true, orderable: true},
                {data: 'jam_plg', name: 'jam_plg', searchable: true, orderable: true},
                // {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
            ],
            columnDefs: [
                { "visible": false, "targets": [1,2] }
            ],
            // "order": [[ groupColumn, 'asc' ]],
            order: [[1, 'asc'], [2, 'asc']],
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(groupColumn1, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group text-bold"><td colspan="5"> '+group+'</td></tr>'
                        );

                        last = group;
                    }
                } );
                api.column(groupColumn2, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        var col = api.ajax.json().data;
                        url = btoa(col[i].posyandu_kode+'&'+col[i].kode);
                        $(rows).eq( i ).before(
                            '<tr class="group text-bold">'+
                                '<td colspan="4"> &nbsp;&nbsp;&nbsp;'+ group+'</td>'+
                                '<td style="text-align:center">'+
                                    '<a href="absensi/view-kader/'+url+'"'+
                                    ' title="View '+col[i].nama+'" class="btn btn-info btn-sm btn-icon" data-dismiss="modal"><i class="fas fa-search">&nbsp;View</i></a>'+
                                '</td>'+
                            '</tr>'
                        );
                        last = group;
                    }
                } );
            },
        });

        $('body #cetak_anggota').on('click', function(){
            startDate   = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');;
            endDate     = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD');;

            let posyanduKode = $('#posyandu_id').val();
            if (posyanduKode == "" || posyandu_id == undefined || posyandu_id == '') {
                $.toast({
                    heading: 'Warning',
                    text: 'Posyandu harus diisi !!!',
                    showHideTransition: 'plain',
                    icon: 'warning'
                });
            }else{
                encode = btoa(startDate+'&'+endDate+'&'+posyanduKode);
                url = "/absensi/cetak-anggota/"+encode;
                var win = window.open(url, '_blank');
                win.focus();
            }
        });

        $('body #cetak_kader').on('click', function(){
            startDate   = $('.daterange-cus').data('daterangepicker').startDate.format('YYYY-MM-DD');;
            endDate     = $('.daterange-cus').data('daterangepicker').endDate.format('YYYY-MM-DD');;

            let posyanduKode = $('#posyandu_id').val();
            if (posyanduKode == "" || posyandu_id == undefined || posyandu_id == '') {
                $.toast({
                    heading: 'Warning',
                    text: 'Posyandu harus diisi !!!',
                    showHideTransition: 'plain',
                    icon: 'warning'
                });
            }else{
                encode = btoa(startDate+'&'+endDate+'&'+posyanduKode);
                url = "/absensi/cetak-kader/"+encode;
                var win = window.open(url, '_blank');
                win.focus();
            }
        });

        $('body #batal').on('click',function(){
            $('.cetak').hide();
        })
    });

    function open_container() {
        $('.cetak').show();
    }

    var view_kader = function(posyandu_kode, kader_kode){
        alert('test_kader')
    };

    var view_anggota = function(posyandu_kode, anggota_kode){
        alert('test_anggota')
    };

</script>
@endsection
