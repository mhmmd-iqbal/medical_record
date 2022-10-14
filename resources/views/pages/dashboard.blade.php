@extends('partials.master')
@section('title', 'DASHBOARD')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }

        img {
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        #over{
            position:absolute; 
            width:100%; 
            height:100%"
        }

        .title{
            margin: auto;
            display: block;
        }

        .description {
            margin-top: auto;
            margin-bottom: auto;
            display: block;
        }

        .buy-box{
            padding: 5px;
            border: 1px solid #8fca8e;
            width: 60px;
            text-align: center;
            background: #8fca8e;
            color: white;
        }

        .dialog-box {
            border: 1px solid #8fca8e;
            border-radius: 10px;
            margin: 0 5px;
            height: 550px;
        }
    </style>
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
       
    </script>
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row m-t-25">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="title text-right" style="color: white">Rabu, 13 Oktober 2022 | 14:00 WIB</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h2>DAFTAR ANTRIAN KLINIK KONOHA</h2>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-4">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner text-center">
                                                <h3>POLIKLINIK UMUM</h3>
                                                <h1>01</h1>
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="col-4">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner text-center">
                                                <h3>POLIKLINIK GIGI</h3>
                                                <h1>01</h1>
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="col-4">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner text-center">
                                                <h3>POLIKLINIK BERSALIN</h3>
                                                <h1>01</h1>
                                            </div>
                                        </div>
                                    </div>        
                                </div>

                            </div>
                            <div class="card-footer text-center">
                                {{date('Y')}} @ Konoha Hospitally
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('modal')

@endsection
