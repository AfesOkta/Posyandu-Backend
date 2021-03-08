@extends('layouts.backend')

@section('title', 'Data Anggota')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection

@section('content')
<x-section-header heading="Anggota Posyandu" breadcrumb="Anggota Posyandu" />

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
            <b>Daftar Anggota Posyandu<b>
            <button class="btn btn-primary dropdown-toggle float-right" type="button"
                    data-toggle="dropdown"><i class="fas fa-plus-square"></i>
                <span class="caret"></span></button>
            <div class="dropdown-menu dropdown-menu-puskesmas dropdown-menu-right" role="menu">
                <a class="dropdown-item" role="presentation"
                    href="javascript:void(0)" onClick="open_container();" title="Tambah Anggota">Add</a>
                <a class="dropdown-item" role="presentation"
                    href="javascript:void(0)" onClick="open_container_import();" title="Import Anggota">Import</a>
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
                        <th class="tdLeft thColor">Kode Anggota</th>
                        <th class="tdLeft thColor">Nama Anggota</th>
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

    @include('components.modal_import')
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
                ajax: '{{route('anggota.json')}}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                    {data: 'posyandu.posyandu_nama', name: 'posyandu.posyandu_nama', searchable: true, orderable: true},
                    {data: 'lansia_kode', name: 'lansia_kode', searchable: true, orderable: true},
                    {data: 'lansia_nama', name: 'lansia_nama', searchable: true, orderable: true},
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
                                '<tr class="group text-bold"><td colspan="4"> '+group+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                },
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
                let ibu       = $('#form-input-ibu').val();
                let bapak       = $('#form-input-bapak').val()
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
                            ibu        : ibu,
                            bapak        : bapak,
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

        function open_container_import()
        {
            var content = '<form id="import-form" enctype="multipart/form-data" action="{{route('anggota.import')}}" method="POST">'+
                                '{{ csrf_field() }}'+
                                '<div class="modal-body">'+
                                    '<div class="row clearfix">'+
                                        '<div class="form-group">'+
                                            '<div class="col-sm-12">'+
                                                '<input type="file" id="file" name="file" class="form-control">'+
                                            '</div>'+
                                            '<br/>'+
                                            '<div class="col-sm-4">'+
                                                '<button type="submit" class="btn btn-primary process">Process <i class="fab fa-upload ml-1"></i></button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</form>';
            var title   = 'Import Anggota';
            setModalBoxImport(content, title);
            $('#importmodal').modal('show');
        }

        function open_container()
        {
            // var size='standard';
            var content = ' <div class="form-group">'+
                                '<label for="form-input-posyandu">Kode Posyandu</label>'+
                                '<select id="posyandu_id" name="posyandu_id" class="form-control posyandu_id">'+
                                    '<option value="">Silahkan pilih Posyandu</option>'+
                                    @foreach($posyandus as $posyandu)
                                    '<option value="{{ $posyandu->posyandu_kode }}" data-name="{{$posyandu->posyandu_nama}}">{{ $posyandu->posyandu_nama }}</option>'+
                                    @endforeach
                                '</select>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-4 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="form-input-kode">Kode Anggota</label>'+
                                        '<input type="text" class="form-control lansia_kode" id="form-input-kode" placeholder="Kode lansia">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-8 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="form-input-nama">Nama Anggota</label>'+
                                        '<input type="text" class="form-control lansia_nama" id="form-input-nama" placeholder="Nama Anggota">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-6 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="form-input-ibu">Nama Ibu</label>'+
                                        '<input type="text" class="form-control nama_ibu" id="form-input-ibu" placeholder="Nama Ibu">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="form-input-bapak">Nama Bapak</label>'+
                                        '<input type="text" class="form-control nama_bapak" id="form-input-bapak" placeholder="Nama Bapak">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-6 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="form-input-nik">NIK Anggota</label>'+
                                        '<input type="text" class="form-control lansia_nik" id="form-input-nik" placeholder="NIK Anggota">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="form-input-kk">KK Anggota</label>'+
                                        '<input type="text" class="form-control lansia_kk" id="form-input-kk" placeholder="KK Anggota">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-alamat">Alamat Anggota</label>'+
                                '<input type="text" class="form-control lansia_alamat" id="form-input-alamat" placeholder="Alamat Anggota">'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-6 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="form-input-no-telp">No. Telp</label>'+
                                        '<input type="text" class="form-control lansia_telp" id="form-input-no-telp" placeholder="No. Telp">'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-6 col-sm-12">'+
                                    '<div class="form-group">'+
                                        '<label for="email">Email</label>'+
                                        '<input type="email" class="form-control email" id="email" placeholder="Email">'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
            var title   = 'New Anggota';
            // var footer  = '<button type="button" class="btn btn-primary">Save changes</button>';
            setModalBox(content, title);
            $('#composemodal').modal('show');
        }

        function setModalBox(content, title)
        {
            document.getElementById('modal-body').innerHTML=content;
            document.getElementById('composemodalTitle').innerHTML=title;
            $('#composemodal').attr('class', 'modal fade')
                .attr('aria-labelledby','myModalLabel');
            $('.modal-dialog').attr('class','modal-dialog modal-lg');
        }

        function setModalBoxImport(content, title)
        {
            document.getElementById('modal-body-import').innerHTML=content;
            document.getElementById('importmodalTitle').innerHTML=title;
            $('#importmodal').attr('class', 'modal fade')
                .attr('aria-labelledby','myModalLabel');
            $('.modal-dialog').attr('class','modal-dialog');
            $('.download').attr('href','{{route('anggota.download')}}');
        }

        var edit = function(id){
            $.ajax({
                type: "get",
                url: "{{ url('anggota/get') }}/"+id,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var content =  ' <div class="form-group">'+
                                '<label for="form-input-posyandu">Kode Posyandu</label>'+
                                '<select id="posyandu_id" name="posyandu_id" class="form-control posyandu_id">'+
                                    '<option value="">Silahkan pilih Posyandu</option>'+
                                    @foreach($posyandus as $posyandu)
                                    '<option value="{{ $posyandu->posyandu_kode }}" {{ $posyandu->posyandu_kode == "'+data.posyandu_kode+'" ? 'selected' : '' }}>{{ $posyandu->posyandu_nama }}</option>'+
                                    @endforeach
                                '</select>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-lg-4 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="form-input-kode">Kode Anggota</label>'+
                                            '<input type="text" class="form-control lansia_kode" id="lansia_kode" value="'+data.lansia_kode+'" maxlength="6" placeholder="Kode lansia" disabled="disabled">'+
                                            '<input type="text" class="form-control id_lansia" maxlength="5" id="form-input-id" placeholder="Id lansia" value="'+data.id+'" style="display:none">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-8 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="form-input-nama">Nama Anggota</label>'+
                                            '<input type="text" class="form-control lansia_nama" id="lansia_nama" value="'+data.lansia_nama+'" placeholder="Nama lansia">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-lg-6 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="form-input-ibu">Nama Ibu</label>'+
                                            '<input type="text" class="form-control nama_ibu" id="form-input-ibu" value="'+data.nama_ibu+'" placeholder="Nama Ibu">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-6 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="form-input-bapak">Nama Bapak</label>'+
                                            '<input type="text" class="form-control nama_bapak" id="form-input-bapak" value="'+data.nama_bapak+'" placeholder="Nama Bapak">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-lg-6 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="form-input-nik">NIK Anggota</label>'+
                                            '<input type="text" class="form-control lansia_nik" id="lansia_nik" value="'+data.lansia_nik+'" placeholder="NIK lansia">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-6 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="form-input-kk">KK Anggota</label>'+
                                            '<input type="text" class="form-control lansia_kk" id="lansia_kk" value="'+data.lansia_kk+'" placeholder="KK lansia">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="form-group">'+
                                    '<label for="form-input-alamat">Alamat Anggota</label>'+
                                    '<input type="text" class="form-control lansia_alamat" id="lansia_alamat" value="'+data.lansia_alamat+'" placeholder="Alamat lansia">'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-lg-6 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="form-input-no-telp">No. Telp</label>'+
                                            '<input type="text" class="form-control lansia_telp" id="lansia_telp" value="'+data.lansia_telp+'" placeholder="No. Telp">'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-6 col-sm-12">'+
                                        '<div class="form-group">'+
                                            '<label for="email">Email</label>'+
                                            '<input type="email" class="form-control email" id="email" value="'+data.email+'" placeholder="Email" disabled="disabled">'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';

                    var title   = 'Edit lansia';
                    // var footer  = '<button type="button" class="btn btn-primary">Save changes</button>';
                    setModalBox(content, title);
                    $('#composemodal').modal('show');
                },
                error: function() {
                    $.toast({
                        heading: 'Error',
                        text: "Posyandu tidak ditemukan",
                        showHideTransition: 'plain',
                        icon: 'error'
                    })
                }
            })
        };

        function generate_code(id) {
            location.replace('{{url("anggota/generate/qr-code")}}/'+id);
        }

        var hapus = function(id){
            swal({
                title: "Yakin?",
                text: "Data Anggota mau dihapus?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus saja!",
                closeOnConfirm: false
            }).then(function () {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    data: {_token: '{{ csrf_token() }}', id: id},
                    url: "{{ route('anggota.delete') }}",
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
                                text: "Data anggota tidak dapat dihapus",
                                showHideTransition: 'plain',
                                icon: 'error'
                            })
                        }
                    },
                    error: function (data) {
                        $.toast({
                            heading: 'Error',
                            text: "Data anggota tidak ditemukan",
                            showHideTransition: 'plain',
                            icon: 'error'
                        })
                    }
                });
            });
        }
    </script>
@endsection
