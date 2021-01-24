@extends('layouts.backend')

@section('title', 'Data Kader')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
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
                    {data: 'posyandu_id', name: 'posyandu_id', searchable: true, orderable: true},
                    {data: 'kader_kode', name: 'kader_kode', searchable: true, orderable: true},
                    {data: 'kader_nama', name: 'kader_nama', searchable: true, orderable: true},
                    {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
                ],
            });
        });

        function open_container()
        {
            // var size='standard';
            var content = '<form role="form">'+
                            '<div class="form-group">'+
                                '<label for="form-input-posyandu">Kode Posyandu</label>'+
                                '<input type="text" class="form-control" id="form-input-posyandu" placeholder="Kode Posyandu">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-kode">Kode Kader</label>'+
                                '<input type="text" class="form-control" id="form-input-kode" placeholder="Kode Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nama">Nama Kader</label>'+
                                '<input type="text" class="form-control" id="form-input-nama" placeholder="Nama Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nik">NIK Kader</label>'+
                                '<input type="text" class="form-control" id="form-input-nik" placeholder="NIK Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-kk">KK Kader</label>'+
                                '<input type="text" class="form-control" id="form-input-kk" placeholder="KK Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-alamat">Alamat Kader</label>'+
                                '<input type="text" class="form-control" id="form-input-alamat" placeholder="Alamat Kader">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-no-telp">No. Telp</label>'+
                                '<input type="text" class="form-control" id="form-input-no-telp" placeholder="No. Telp">'+
                            '</div></form>';
            var title   = 'New Kader Posyandu';
            // var footer  = '<button type="button" class="btn btn-primary">Save changes</button>';
            setModalBox(content, title);
            $('#composemodal').modal('show');
        }
        function setModalBox(content, title)
        {
            document.getElementById('modal-body').innerHTML=content;
            document.getElementById('composemodalTitle').innerHTML=title;
            //document.getElementById('modal-footer').innerHTML=footer;
            // if($size == 'large')
            // {
            //     $('#composemodal').attr('class', 'modal fade bs-example-modal-lg')
            //         .attr('aria-labelledby','myLargeModalLabel');
            //     $('.modal-dialog').attr('class','modal-dialog modal-lg');
            // }
            // if($size == 'standart')
            // {
                $('#composemodal').attr('class', 'modal fade')
                    .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
            // }
            // if($size == 'small')
            // {
            //     $('#composemodal').attr('class', 'modal fade bs-example-modal-sm')
            //         .attr('aria-labelledby','mySmallModalLabel');
            //     $('.modal-dialog').attr('class','modal-dialog modal-sm');
            // }
        }
    </script>
@endsection
