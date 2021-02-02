@extends('layouts.backend')

@section('title', 'Data Kader')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection

@section('content')
<x-section-header heading="Kader Posyandu" breadcrumb="Kader Posyandu" />

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
            <b>Daftar Kader Posyandu<b>
            <button class="btn btn-primary dropdown-toggle float-right" type="button"
                    data-toggle="dropdown"><i class="fas fa-plus-square"></i>
                <span class="caret"></span></button>
            <div class="dropdown-menu dropdown-menu-puskesmas dropdown-menu-right" role="menu">
                <a class="dropdown-item" role="presentation"
                    href="javascript:void(0)" onClick="open_container();" title="Tambah Kader">Add</a>
                <a class="dropdown-item" role="presentation" href="javascript:void(0)" data-toggle="modal"
                    data-target="#kader-import" title="Import Kader">Import</a>
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
                        <th class="tdLeft thColor">Kode Kader</th>
                        <th class="tdLeft thColor">Nama Kader</th>
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
            var table = $('#table-1').DataTable({
                //dom: '<"col-md-6"l><"col-md-6"f>rt<"col-md-6"i><"col-md-6"p>',
                processing: true,
                serverSide: true,
                method: 'get',
                ajax: '{{route('kader.json')}}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                    {data: 'posyandu.posyandu_nama', name: 'posyandu.posyandu_nama', searchable: true, orderable: true},
                    {data: 'kader_kode', name: 'kader_kode', searchable: true, orderable: true},
                    {data: 'kader_nama', name: 'kader_nama', searchable: true, orderable: true},
                    {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
                ],
            });

            $('body #composemodal').on('click','.save',function(e){
                e.preventDefault();
                let posyandu_id = $('.posyandu_id').val();
                let kader_kode = $('.kader_kode').val();
                let kader_nama = $('.kader_nama').val();
                let kader_alamat = $('.kader_alamat').val();
                let kader_kk = $('.kader_kk').val();
                let kader_nik = $('.kader_nik').val();
                let kader_telp = $('.kader_telp').val();
                let kader_id = $('#form-input-id').val();
                $('.save').attr("disabled","disabled");
                if (kader_kode == '' || kader_kode == null || kader_kode == undefined) {
                    $.toast({
                        heading: 'Warning',
                        text: 'Kode kader harus diisi !!!',
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
                    if (kader_id == null || kader_id == "" || kader_id == undefined) {
                        url = "{{route('kader.store')}}";
                    }else{
                        url = "{{route('kader.update')}}";
                    }
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: '{{ csrf_token() }}',
                            posyandu_id: posyandu_id,
                            kader_kode: kader_kode,
                            kader_nama: kader_nama,
                            kader_alamat: kader_alamat,
                            kader_kk: kader_kk,
                            kader_nik: kader_nik,
                            kader_telp: kader_telp,
                            kader_id  : kader_id,
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

        function open_container()
        {
            // var size='standard';
            var content = '<div class="form-group">'+
                                '<label for="form-input-posyandu">Kode Posyandu</label>'+
                                '<select id="posyandu_id" name="posyandu_id" class="form-control posyandu_id">'+
                                    '<option value="">Silahkan pilih Posyandu</option>'+
                                    @foreach($posyandus as $posyandu)
                                    '<option value="{{ $posyandu->id }}" data-name="{{$posyandu->posyandu_nama}}">{{ $posyandu->posyandu_nama }}</option>'+
                                    @endforeach
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="kader_kode">Kode Kader</label>'+
                                '<input type="text" class="form-control kader_kode col-sm-4" id="kader_kode" maxlength="5" placeholder="Kode Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="kader_nama">Nama Kader</label>'+
                                '<input type="text" class="form-control kader_nama" id="kader_nama" placeholder="Nama Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="kader_nik">NIK Kader</label>'+
                                '<input type="text" class="form-control kader_nik" id="kader_nik" placeholder="NIK Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="kader_kk">KK Kader</label>'+
                                '<input type="text" class="form-control kader_kk" id="kader_kk" placeholder="KK Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="kader_alamat">Alamat Kader</label>'+
                                '<input type="text" class="form-control kader_alamat" id="kader_alamat" placeholder="Alamat Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="kader_telp">No. Telp</label>'+
                                '<input type="text" class="form-control kader_telp" id="kader_telp" placeholder="No. Telp">'+
                            '</div>';
            var title   = 'New Kader Posyandu';
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
            $('.modal-dialog').attr('class','modal-dialog');
        }

        var edit = function(id){
            $.ajax({
                type: "get",
                url: "{{ url('kader/get') }}/"+id,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var content =   '<div class="form-group">'+
                                        '<label for="form-input-posyandu">Kode Posyandu</label>'+
                                        '<select id="posyandu_id" name="posyandu_id" class="form-control posyandu_id">'+
                                            @foreach($posyandus as $posyandu)
                                            '<option value="{{ $posyandu->id }}" {{ $posyandu->id == "'+data.posyandu_id+'" ? 'selected' : '' }}>{{ $posyandu->posyandu_nama }}</option>'+
                                            @endforeach
                                        '</select>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="kader_kode">Kode Kader</label>'+
                                        '<input type="text" class="form-control kader_kode col-sm-4" id="kader_kode" value="'+data.kader_kode+'" maxlength="5" placeholder="Kode Kader" disabled="disabled">'+
                                        '<input type="text" class="form-control id_kader" maxlength="5" id="form-input-id" placeholder="Id kader" value="'+data.id+'" style="display:none">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="kader_nama">Nama Kader</label>'+
                                        '<input type="text" class="form-control kader_nama" id="kader_nama" value="'+data.kader_nama+'" placeholder="Nama Kader">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="kader_nik">NIK Kader</label>'+
                                        '<input type="text" class="form-control kader_nik" id="kader_nik" value="'+data.kader_nik+'" placeholder="NIK Kader">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="kader_kk">KK Kader</label>'+
                                        '<input type="text" class="form-control kader_kk" id="kader_kk" value="'+data.kader_kk+'" placeholder="KK Kader">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="kader_alamat">Alamat Kader</label>'+
                                        '<input type="text" class="form-control kader_alamat" id="kader_alamat" value="'+data.kader_alamat+'" placeholder="Alamat Kader">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="kader_telp">No. Telp</label>'+
                                        '<input type="text" class="form-control kader_telp" id="kader_telp" value="'+data.kader_telp+'" placeholder="No. Telp">'+
                                    '</div>';
                    var title   = 'Edit Kader';
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
    </script>
@endsection
