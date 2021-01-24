@extends('layouts.backend')

@section('title', 'Data Posyandu')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection

@section('content')
<x-section-header heading="Posyandu" breadcrumb="posyandu" />

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
            <b>Daftar Posyandu<b>
            <button class="btn btn-primary dropdown-toggle float-right" type="button"
                    data-toggle="dropdown"><i class="fas fa-plus-square"></i>
                <span class="caret"></span></button>
            <div class="dropdown-menu dropdown-menu-puskesmas dropdown-menu-right" role="menu">
                <a class="dropdown-item" role="presentation"
                    href="javascript:void(0)" onClick="open_container();" title="Tambah Posyandu">Add</a>
                <a class="dropdown-item" role="presentation" href="javascript:void(0)" data-toggle="modal"
                    data-target="#Posyandu-import" title="Import Posyandu">Import</a>
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
                        <th class="tdLeft thColor">Nama Posyandu</th>
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
    <script src="{{asset('stisla/modules/jquery-toast/jquery.toast.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery-key-restrictions.js')}}"></script>
@endsection

@section('js')
    <script>
        $(function () {
            $('body .kode_posyandu').alphaNumericOnly();

            var table = $('#table-1').DataTable({
                //dom: '<"col-md-6"l><"col-md-6"f>rt<"col-md-6"i><"col-md-6"p>',
                processing: true,
                serverSide: true,
                method: 'get',
                ajax: '{{route('posyandu.json')}}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: true, orderable: true},
                    {data: 'posyandu_kode', name: 'posyandu_kode', searchable: true, orderable: true},
                    {data: 'posyandu_nama', name: 'posyandu_nama', searchable: true, orderable: true},
                    {data: 'action', className: 'tdCenter', searchable: false, orderable: false}
                ],
            });
            $('body #composemodal').on('click','.save',function(e){
                e.preventDefault();
                let kode = $('.kode_posyandu').val();
                let nama = $('.nama_posyandu').val();
                if (kode == '' || kode == null || kode == undefined) {
                    $.toast({
                        heading: 'Warning',
                        text: 'Kode Posyandu harus diisi !!!',
                        showHideTransition: 'plain',
                        icon: 'warning'
                    })
                }else{
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: '{{ csrf_token() }}',
                            posyandu_kode: kode,
                            posyandu_nama: nama,
                        },
                        url: "{{route('posyandu.store')}}",
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
                                })
                            }
                        },
                        error: function (data) {
                            $.toast({
                                heading: 'Error',
                                text: data.message,
                                showHideTransition: 'plain',
                                icon: 'error'
                            })
                        }
                    });
                }
            });
        });

        function open_container()
        {
            // var size='standard';
            var content = '<form role="form">'+
                            '<div class="form-group">'+
                                '<label for="form-input-kode">Kode Posyandu</label>'+
                                '<input type="text" class="form-control kode_posyandu" maxlength="5" id="form-input-kode" placeholder="Kode Posyandu">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nama">Nama Posyandu</label>'+
                                '<input type="text" class="form-control nama_posyandu" id="form-input-nama" placeholder="Nama Posyandu">'+
                            '</div></form>';
            var title   = 'New Posyandu';
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
