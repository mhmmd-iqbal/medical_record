@extends('partials.master')
@section('title', 'KATEGORI PRODUK')

@section('custom_styles')
<style>
</style>
@endsection

@section('custom_scripts')
<script>
    function showDetail(e) {
        let nik     = $(e).data('nik')
        let url     = "{{route('patient.show', ':nik' )}}".replace(':nik', nik)
        $('#medical-list').html('')

        ajaxRequest('GET', url).then((res) => {
        if (res.result) {
            if(res.result.medicalrecords.length > 0) {
                $.each(res.result.medicalrecords, function (index, value) { 
                    let html = `<tr>
                        <td>${value.medical_issue}</td>
                        <td>${value.medical_handle}</td>
                        <td>${value.user.name}</td>
                        <td>${value.treated_at}</td>
                        <td>${value.treated_to}</td>
                    </tr> `
                    $('#medical-list').append(html)
                });
            } else {
                let html = `<tr>
                    <td colspan="5">-- Data Belum Ada --</td>
                </tr>`

                $('#medical-list').html(html)
            }
        } else {
        }
        }).catch((err) => {
            
        }); 
        $('#formModal').modal('toggle')
    }

</script>
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
                                    Data Pasien
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Usia</th>
                                                <th>Kelamin</th>
                                                <th>Telepon</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($patient as $i => $item)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td><a href="javascript:void(0)" onclick="javascript:showDetail(this)" data-nik="{{$item->nik}}"> {{$item->nik}}</a> </td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{date('d M Y', strtotime($item->date_of_birth))}}</td>
                                                    <td>{{$item->age}} tahun</td>
                                                    <td>{{$item->gender}}</td>
                                                    <td>{{$item->phone}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true"
data-backdrop="static">
   <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="formModalLabel">Detail Rekam Medik</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Gejala Penyakit</th>
                                <th>Penanganan</th>
                                <th>Dokter Yang Menangani</th>
                                <th>Tanggal Dirawat</th>
                                <th>Tanggal Keluar</th>
                            </tr>
                        </thead>
                        <tbody id="medical-list"></tbody>
                    </table>
                </div>
           </div>
           <div class="modal-footer">
               <button type="reset" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
           </div>
       </div>
   </div>
</div>
@endsection