@extends('layouts.backend')

@section('title', 'Data Anggota')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
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
                    {data: 'posyandu_id', name: 'posyandu_id', searchable: true, orderable: true},
                    {data: 'anggota_kode', name: 'anggota_kode', searchable: true, orderable: true},
                    {data: 'anggota_nama', name: 'anggota_nama', searchable: true, orderable: true},
                    {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
                ],
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
                                '<input type="text" class="form-control" id="form-input-kode" placeholder="Kode Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nama">Nama Anggota</label>'+
                                '<input type="text" class="form-control" id="form-input-nama" placeholder="Nama Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nik">NIK Anggota</label>'+
                                '<input type="text" class="form-control" id="form-input-nik" placeholder="NIK Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-kk">KK Anggota</label>'+
                                '<input type="text" class="form-control" id="form-input-kk" placeholder="KK Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-alamat">Alamat Anggota</label>'+
                                '<input type="text" class="form-control" id="form-input-alamat" placeholder="Alamat Anggota">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-no-telp">No. Telp</label>'+
                                '<input type="text" class="form-control" id="form-input-no-telp" placeholder="No. Telp">'+
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
    </script>
@endsection
