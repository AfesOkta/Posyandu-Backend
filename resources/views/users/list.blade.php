@extends('layouts.backend')

@section('title', 'Data Users')

@section('css')
    <link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection

@section('content')
<x-section-header heading="Users" breadcrumb="Users" />

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
            <b>Daftar Users<b>
            <button class="btn btn-primary dropdown-toggle float-right" type="button"
                    data-toggle="dropdown"><i class="fas fa-plus-square"></i>
                <span class="caret"></span></button>
            <div class="dropdown-menu dropdown-menu-puskesmas dropdown-menu-right" role="menu">
                <a class="dropdown-item" role="presentation"
                    href="javascript:void(0)" onClick="open_container();" title="Tambah Anggota">Add</a>
                <a class="dropdown-item" role="presentation" href="javascript:void(0)" data-toggle="modal"
                    data-target="#anggota-import" title="Import Anggota">Import</a>
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
                        {{-- <th class="tdLeft thColor">Posyandu</th> --}}
                        <th class="tdLeft thColor">Username</th>
                        <th class="tdLeft thColor">Email</th>
                        <th class="tdCenter thColor">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    @include('components.modal')

@endsection

@section('plugin')
    <script src="{{asset('stisla/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('stisla/modules/select2/dist/js/select2.js')}}"></script>
    <script src="{{asset('stisla/modules/jquery-toast/jquery.toast.min.js')}}"></script>
@endsection

@section('js')
     <script>
        $(function () {
            // let groupColumn = 1;
            var table = $('#table-1').DataTable({
                //dom: '<"col-md-6"l><"col-md-6"f>rt<"col-md-6"i><"col-md-6"p>',
                processing: true,
                serverSide: true,
                method: 'get',
                ajax: '{{route('users.json')}}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                    // {data: 'user_posyandu.posyandu_kode', name: 'user_posyandu.posyandu_kode', searchable: true, orderable: true},
                    {data: 'name', name: 'name', searchable: true, orderable: true},
                    {data: 'email', name: 'email', searchable: true, orderable: true},
                    {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
                ],
                // "columnDefs": [
                //     { "visible": false, "targets": groupColumn }
                // ],
                // "order": [[ groupColumn, 'asc' ]],
                // "drawCallback": function ( settings ) {
                //     var api = this.api();
                //     var rows = api.rows( {page:'current'} ).nodes();
                //     var last=null;

                //     api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                //         if ( last !== group ) {
                //             $(rows).eq( i ).before(
                //                 '<tr class="group text-bold"><td colspan="4"> '+group+'</td></tr>'
                //             );

                //             last = group;
                //         }
                //     } );
                // },
            });

            $('body #composemodal').on('click','.save',function(e){
                e.preventDefault();
                let posyandu_id = $('.posyandu_id').val();
                let lansia_kode = $('.lansia_kode').val();
                let lansia_nama = $('.lansia_nama').val();
                let lansia_alamat = $('.lansia_alamat').val();
                let lansia_kk = $('.lansia_kk').val();
                let lansia_nik = $('.lansia_nik').val();
                let lansia_telp = $('.lansia_telp').val();
                let email = $('.email').val();
                let lansia_id = $('#form-input-id').val();
                $('.save').attr("disabled","disabled");
                if (lansia_kode == '' || lansia_kode == null || lansia_kode == undefined) {
                    $.toast({
                        heading: 'Warning',
                        text: 'Kode lansia harus diisi !!!',
                        showHideTransition: 'plain',
                        icon: 'warning'
                    });
                    $('.save').removeAttr("disabled");
                }else if (posyandu_id == '' || posyandu_id == null || posyandu_id == undefined) {
                    $.toast({
                        heading: 'Warning',
                        text: 'Posyandu harus diisi !!!',
                        showHideTransition: 'plain',
                        icon: 'warning'
                    });
                    $('.save').removeAttr("disabled");
                }else{
                    if (lansia_id == null || lansia_id == "" || lansia_id == undefined) {
                        url = "{{route('anggota.store')}}";
                    }else{
                        url = "{{route('anggota.update')}}";
                    }
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: '{{ csrf_token() }}',
                            posyandu_id: posyandu_id,
                            lansia_kode: lansia_kode,
                            lansia_nama: lansia_nama,
                            lansia_alamat: lansia_alamat,
                            lansia_kk: lansia_kk,
                            lansia_nik: lansia_nik,
                            lansia_telp: lansia_telp,
                            lansia_id  : lansia_id,
                            email      : email,
                        },
                        url: url,
                        success: function (data) {
                            if (data.status) {
                                $.toast({
                                    heading: 'Success',
                                    text: data.message,
                                    showHideTransition: 'slide',
                                    icon: 'success'
                                }),
                                location.reload();
                            } else {
                                $.toast({
                                    heading: 'Error',
                                    text: data.message,
                                    showHideTransition: 'plain',
                                    icon: 'error'
                                });
                                $('.save').removeAttr("disabled");
                            }
                        },
                        error: function (data) {
                            $.toast({
                                heading: 'Error',
                                text: data.message,
                                showHideTransition: 'plain',
                                icon: 'error'
                            });
                            $('.save').removeAttr("disabled");
                        }
                    });
                }
            });
        });


    </script>
@endsection
