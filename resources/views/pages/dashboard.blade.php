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
        $('#title').select2({
            placeholder: "Pilih Nama Produk...",
            allowClear: true,
            ajax: {
                url: '',
                data: function(params) {
                    var query = {
                        search: params.term,
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
            }
        });

        const openModal = () => {
            $('#staticModal').modal({
                'show': true
            })
        }

        try {
            //bar chart
            var ctx = document.getElementById("barChart");
            var label = new Array();
            var data = @json($transaction);

            for (var i = 1; i <= "{{ \Carbon\Carbon::now()->daysInMonth }}"; i++) {
                label.push(i);        
            }

            if (ctx) {
                ctx.height = 200;
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    defaultFontFamily: 'Poppins',
                    data: {
                    labels: label,
                    datasets: [
                        {
                        label: "Data penjualan bulan " + "{{ \Carbon\Carbon::now()->format('F') }}",
                        data: data,
                        borderColor: "rgba(0, 123, 255, 0.9)",
                        borderWidth: "0",
                        backgroundColor: "rgba(0, 123, 255, 0.5)",
                        fontFamily: "Poppins"
                        },
                    ]
                    },
                    options: {
                    legend: {
                        position: 'top',
                        labels: {
                        fontFamily: 'Poppins'
                        }

                    },
                    scales: {
                        xAxes: [{
                        ticks: {
                            fontFamily: "Poppins"

                        }
                        }],
                        yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontFamily: "Poppins"
                        }
                        }]
                    }
                    }
                });
            }


        } catch (error) {
            console.log(error);
        }

        try {

            //pie chart
            var ctx = document.getElementById("pieChart");
            var data = @json($productBaseOnCategory);
            var label = new Array();
            var value = new Array();
            var total = 0;

            for (var i = 0; i < data.length; i++) {
                label.push(data[i]['name']);        
                total += data[i]['value'];
            }
            for (var i = 0; i < data.length; i++) {
                value.push(data[i]['value'] / total * 100);        
            }

            if (ctx) {
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                    datasets: [{
                        data: value,
                        backgroundColor: [
                        "rgba(0, 0, 255, 0.9)",
                        "rgba(0, 255, 0, 0.7)",
                        "rgba(255, 0, 0, 0.5)",
                        "rgba(255,255,0,0.7)",
                        "rgba(255,0,255,0.7)"
                        ],
                        hoverBackgroundColor: [
                        "rgba(0, 0, 255, 0.9)",
                        "rgba(0, 255, 0, 0.7)",
                        "rgba(255, 0, 0, 0.5)",
                        "rgba(255,255,0,0.7)",
                        "rgba(255,0,255,0.7)"
                        ]

                    }],
                    labels: label
                    },
                    options: {
                    legend: {
                        position: 'top',
                        labels: {
                        fontFamily: 'Poppins'
                        }

                    },
                    responsive: true
                    }
                });
            }


        } catch (error) {
            console.log(error);
        }
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
                                <h4 class="title" style="color: white">Dashboard</h4>
                            </div>
                            <div class="card-body">
                                <h3 class="mb-3">Statistik Penjualan</h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner">
                                                <h3 class="title-2 m-b-40">Penjualan bulan - {{ \Carbon\Carbon::now()->format('F'); }}  </h3>
                                                <canvas id="barChart"></canvas>
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="col-lg-6">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner">
                                                <h3 class="title-2 m-b-40">Kategori Produk (%)</h3>
                                                <canvas id="pieChart"></canvas>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                                <h3 class="mb-3">10 Transaksi Terakhir</h3>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive pt-2">
                                            <table class="table table-bordered table-active" id="list-datatables">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Invoice</th>
                                                        <th>Pembeli</th>
                                                        <th>Total</th>
                                                        <th>Tanggal Transaksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lastTenData as $key => $value)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value->invoice }}</td>
                                                            <td>{{ $value->consumen }}</td>
                                                            <td>{{ "Rp " . number_format($value->total, 2, ',', '.') }}</td>
                                                            <td>{{ $value->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>        
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                {{date('Y')}} @ Algostudio
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
