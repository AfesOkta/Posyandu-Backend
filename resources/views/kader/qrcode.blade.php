@extends('layouts.backend')

@section('title', 'Data Kader')

@section('css')
<link rel="stylesheet" href="{{ asset('stisla/modules/datatables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/select2/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/modules/jquery-toast/jquery.toast.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
@endsection

@section('content')
<x-section-header heading="Generate QR Code Kader" breadcrumb="Generate QrCode" />

@include('common.status')
@include('common.errors')

<div class="card">
    <div class="card-header">
        <div class="col-12 col-sm-12">
        </div>
    </div>
    <div class="card-body">
        <div class="col-lg-12">
            <div class="d-print-block text-center">

            <h1>QR Code Generator</h1>

            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate($url)) !!} ">

            </div>
            <br/>
            <div class="text-center">
                <a href="{{url('kader/download/qr-code/'.$filename)}}" class="btn btn-primary"><i class="fas fa-download"> Download QRCode</i></a>
            </div>
        </div>
    </div>
</div>
@endsection
