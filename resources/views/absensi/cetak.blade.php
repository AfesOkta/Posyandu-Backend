<!DOCTYPE html>
<html>
    <head>
        <title>Reconsile List</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        table{
            width: 100%;
            margin: 0 auto;
            border: 1px solid;
            border-collapse: collapse;
        }
        th, td{
            border: 1px solid;
            padding-left: 5px;
        }
        h4{
            margin-bottom: 5px;
            width: 60%;
            margin: 0 auto;
            font-size: 14px;
        }
        img {
            float: left;
            width: 5%;
            height: 5%
        }
        </style>
    </head>
    <body>
        <!-- Reconcile List Header -->
        <center>
            <h4 class="card-title">Report Absensi {{$data_posyandu[0]->posyandu_nama}}</h4>
            <h5> Periode {{$tglAwal}} s.d {{$tglAkhir}}</h5>
            <hr/>
        </center>
        <!-- Reconcile List Body-->
        <br/>

        <div class="row">
            <table class="table zero-configuration">
                <thead>
                    <tr>
                        <th style="width: 55%">Nama Anggota</th>
                        <th style="width: 15%; text-align:left">Tanggal</th>
                        <th style="width: 15%; text-align:left">Jam Masuk</th>
                        <th style="width: 15%; text-align:left">Jam Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td>{{$data->nama}}</td>
                            <td style="text-align:left">{{date("d-m-Y", strtotime($data->tanggal))}}</td>
                            <td style="text-align:left">{{date("h:i", strtotime($data->jam_msk))}}</td>
                            <td style="text-align:left">{{date("h:i", strtotime($data->jam_plg))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br/>
    </body>
</html>
