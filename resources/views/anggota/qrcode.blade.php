@extends('layouts.backend')

@section('title', 'Data Anggota')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection

@section('content')
<x-section-header heading="Generate QR Code Anggota" breadcrumb="Anggota Posyandu QrCode" />

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
        </div>
    </div>
    <div class="card-body">
        <div class="col-lg-12">
            <div class="d-print-block text-center">

            <h1>QR Code Generator</h1>

            {!! $qrcode !!}

            </div>

        </div>
    </div>
</div>
@endsection
