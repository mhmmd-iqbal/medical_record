@extends('partials.master')
@section('title', 'TAMBAH PRODUCT')

@section('custom_styles')
<style>
    .ck-editor__editable {
        min-height: 300px;
    }

    
  
</style>
@endsection

@section('custom_scripts')

@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-uppercase">
                                    Transaksi Penjualan
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Invoice</th>
                                                <td>{{$data->invoice}}</td>
                                            </tr>
                                            <tr>
                                                <th>Customer</th>
                                                <td>{{$data->consumen}}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{$data->address}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <h4 class="mb-4" for="">Detail Pembelian</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Produk</th>
                                                    <th>Code</th>
                                                    <th>Harga Perproduk</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($data->details as $detail)
                                                    <tr>
                                                        <td>
                                                            {{$no++}}
                                                        </td>
                                                        <td>
                                                            {{$detail->product->name}}
                                                        </td>
                                                        <td>
                                                            {{$detail->product->code}}
                                                        </td>
                                                        <td>
                                                            IDR {{number_format($detail->product->price, 0, '', '.');}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3">Total</th>
                                                    <th>IDR {{number_format($data->total, 0, '', '.');}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

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
