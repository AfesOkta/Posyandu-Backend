@extends('layouts.backend')

@section('title', 'Data Posyandu')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/sweetalert/sweetalert.css') }}">
<style>
    /* .import {
        max-height: calc(37vh - 143px);
        overflow-y: auto;
    } */
</style>
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
                <a class="dropdown-item" role="presentation"
                    href="javascript:void(0)" onClick="open_container_import();" title="Import Posyandu">Import</a>
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

    @include('components.modal_import')

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
                let id = $('#form-input-id').val();
                $('.save').attr("disabled","disabled");
                if (kode == '' || kode == null || kode == undefined) {
                    $.toast({
                        heading: 'Warning',
                        text: 'Kode Posyandu harus diisi !!!',
                        showHideTransition: 'plain',
                        icon: 'warning'
                    });
                    $('.save').removeAttr("disabled");
                }else{
                    if (id == null || id == "" || id == undefined) {
                        url = "{{route('posyandu.store')}}";
                    }else{
                        url = "{{route('posyandu.update')}}";
                    }
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            _token: '{{ csrf_token() }}',
                            posyandu_kode: kode,
                            posyandu_nama: nama,
                            posyandu_id  : id,
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

            // $('body #importmodal').on('click','.process',function(e){
            //     e.preventDefault();
            //     $.ajax({
            //         type: "POST",
            //         data: {
            //                 _token: '{{ csrf_token() }}'
            //         },
            //         url: "{{route('posyandu.import')}}",
            //         success: function (data) {
            //                 if (data.status) {
            //                     $.toast({
            //                         heading: 'Success',
            //                         text: data.message,
            //                         showHideTransition: 'slide',
            //                         icon: 'success'
            //                     }),
            //                     location.reload();
            //                 } else {
            //                     $.toast({
            //                         heading: 'Error',
            //                         text: data.message,
            //                         showHideTransition: 'plain',
            //                         icon: 'error'
            //                     });
            //                     $('.save').removeAttr("disabled");
            //                 }
            //             },
            //             error: function (data) {
            //                 $.toast({
            //                     heading: 'Error',
            //                     text: data.message,
            //                     showHideTransition: 'plain',
            //                     icon: 'error'
            //                 });
            //                 $('.save').removeAttr("disabled");
            //             }
            //     });
            // })
        });

        function open_container()
        {
            // var size='standard';
            var content = '<form role="form">'+
                            '<div class="form-group">'+
                                '<label for="form-input-kode">Kode Posyandu</label>'+
                                '<input type="text" class="form-control kode_posyandu" maxlength="5" id="form-input-kode" placeholder="Kode Posyandu">'+
                                '<input type="text" class="form-control id_posyandu" maxlength="5" '+
                                    'id="form-input-id" placeholder="Id Posyandu" style="display:none">'+
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

        function open_container_import()
        {
            var content = '<form id="import-form" enctype="multipart/form-data" action="{{route('posyandu.import')}}" method="POST">'+
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
            var title   = 'Import Posyandu';
            setModalBoxImport(content, title);
            $('#importmodal').modal('show');
        }

        function setModalBox(content, title)
        {
            document.getElementById('modal-body').innerHTML=content;
            document.getElementById('composemodalTitle').innerHTML=title;
            $('#composemodal').attr('class', 'modal fade')
                .attr('aria-labelledby','myModalLabel');
            $('.modal-dialog').attr('class','modal-dialog');
        }

        function setModalBoxImport(content, title)
        {
            document.getElementById('modal-body-import').innerHTML=content;
            document.getElementById('importmodalTitle').innerHTML=title;
            $('#importmodal').attr('class', 'modal fade')
                .attr('aria-labelledby','myModalLabel');
            $('.modal-dialog').attr('class','modal-dialog');
            $('.download').attr('href','{{route('posyandu.download')}}');
        }

        var edit = function(id){
            $.ajax({
                type: "get",
                url: "{{ url('posyandu/get') }}/"+id,
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    var content = '<div class="form-group">'+
                                '<label for="form-input-kode">Kode Posyandu</label>'+
                                '<input type="text" class="form-control kode_posyandu" maxlength="5" '+
                                    'id="form-input-kode" placeholder="Kode Posyandu" value="'+data.posyandu_kode+'" disabled="disabled">'+
                                '<input type="text" class="form-control id_posyandu" maxlength="5" '+
                                    'id="form-input-id" placeholder="Id Posyandu" value="'+data.id+'" style="display:none">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="form-input-nama">Nama Posyandu</label>'+
                                '<input type="text" class="form-control nama_posyandu" '+
                                    'id="form-input-nama" placeholder="Nama Posyandu" value="'+data.posyandu_nama+'">'+
                            '</div>';
                    var title   = 'Edit Posyandu';
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

        var hapus = function(id){
            swal({
                title: "Yakin?",
                text: "Posyandu mau dihapus?",
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
                    url: "{{ route('posyandu.delete') }}",
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
                                text: "Posyandu tidak dapat dihapus",
                                showHideTransition: 'plain',
                                icon: 'error'
                            })
                        }
                    },
                    error: function (data) {
                        $.toast({
                            heading: 'Error',
                            text: "Posyandu tidak ditemukan",
                            showHideTransition: 'plain',
                            icon: 'error'
                        })
                    }
                });
            });
        }
    </script>
@endsection
