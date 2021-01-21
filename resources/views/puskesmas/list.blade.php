@extends('layouts.backend')

@section('title', 'Data Posyandu')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection('css')

@section('content')
<x-section-header heading="Posyandu" breadcrumb="posyandu" />

<div class="card">
    <div class="card-header">
        <div class="col-6 col-sm-12">
            <h4>Daftar Posyandu</h4>
        </div>
    </div>
    <div class="card-body">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="table-1" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">
                            #
                            </th>
                            <th>Kode Posyandu</th>
                            <th>Nama Posyandu</th>
                            <th>Members</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
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
@endsection

@section('js')
    var table = $('#table-1').datatables();
@endsection
