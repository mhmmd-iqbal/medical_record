@extends('partials.master')
@section('title', 'DASHBOARD')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                                <h5 class="title text-right" style="color: white" id="time">-: -:-:-</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h3>DAFTAR LIST ANTRIAN</h3>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    @foreach ($poliklinik as $item)
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <h5>{{$item->name}}</h5>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th align="center">Antrian</th>
                                                            <th>Pasien</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($item->queues as $queue)
                                                        <tr>
                                                            <td align="cenetr">{{str_pad ($queue->queue_no, 2, "0", STR_PAD_LEFT) }}</td>
                                                            <td>{{$queue->patient->name}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
