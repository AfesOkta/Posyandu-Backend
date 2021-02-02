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
                ajax: '{{route('anggota.json')}}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                    {data: 'posyandu.posyandu_name', name: 'posyandu.posyandu_name', searchable: true, orderable: true},
                    {data: 'anggota_kode', name: 'anggota_kode', searchable: true, orderable: true},
                    {data: 'anggota_nama', name: 'anggota_nama', searchable: true, orderable: true},
                    {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
                ],
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
            var content = ' <div class="form-group">'+
                                '<label for="form-input-posyandu">Kode Posyandu</label>'+
                                '<select id="posyandu_id" name="posyandu_id" class="form-control posyandu_id">'+
                                    '<option value="">Silahkan pilih Posyandu</option>'+
                                    @foreach($posyandus as $posyandu)
                                    '<option value="{{ $posyandu->id }}" data-name="{{$posyandu->posyandu_nama}}">{{ $posyandu->posyandu_nama }}</option>'+
                                    @endforeach
                                '</select>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-kode">Kode Anggota</label>'+
                                '<input type="text" class="form-control lansia_kode" id="form-input-kode" placeholder="Kode lansia">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nama">Nama Anggota</label>'+
                                '<input type="text" class="form-control lansia_nama" id="form-input-nama" placeholder="Nama Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nik">NIK Anggota</label>'+
                                '<input type="text" class="form-control lansia_nik" id="form-input-nik" placeholder="NIK Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-kk">KK Anggota</label>'+
                                '<input type="text" class="form-control lansia_kk" id="form-input-kk" placeholder="KK Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-alamat">Alamat Anggota</label>'+
                                '<input type="text" class="form-control lansia_alamat" id="form-input-alamat" placeholder="Alamat Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-no-telp">No. Telp</label>'+
                                '<input type="text" class="form-control lansia_telp" id="form-input-no-telp" placeholder="No. Telp">'+
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
            $('.modal-dialog').attr('class','modal-dialog');
        }

        var edit = function(id){
            $.ajax({
                type: "get",
                url: "{{ url('lansia/get') }}/"+id,
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
                                        '<label for="lansia_kode">Kode lansia</label>'+
                                        '<input type="text" class="form-control lansia_kode col-sm-4" id="lansia_kode" value="'+data.lansia_kode+'" maxlength="5" placeholder="Kode lansia" disabled="disabled">'+
                                        '<input type="text" class="form-control id_lansia" maxlength="5" id="form-input-id" placeholder="Id lansia" value="'+data.id+'" style="display:none">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="lansia_nama">Nama lansia</label>'+
                                        '<input type="text" class="form-control lansia_nama" id="lansia_nama" value="'+data.lansia_nama+'" placeholder="Nama lansia">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="lansia_nik">NIK lansia</label>'+
                                        '<input type="text" class="form-control lansia_nik" id="lansia_nik" value="'+data.lansia_nik+'" placeholder="NIK lansia">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="lansia_kk">KK lansia</label>'+
                                        '<input type="text" class="form-control lansia_kk" id="lansia_kk" value="'+data.lansia_kk+'" placeholder="KK lansia">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="lansia_alamat">Alamat lansia</label>'+
                                        '<input type="text" class="form-control lansia_alamat" id="lansia_alamat" value="'+data.lansia_alamat+'" placeholder="Alamat lansia">'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label for="lansia_telp">No. Telp</label>'+
                                        '<input type="text" class="form-control lansia_telp" id="lansia_telp" value="'+data.lansia_telp+'" placeholder="No. Telp">'+
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
    </script>
@endsection
