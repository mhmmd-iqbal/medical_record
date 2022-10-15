@extends('partials.master')
@section('title', 'KATEGORI PRODUK')

@section('custom_styles')
<style>
</style>
@endsection

@section('custom_scripts')
<script>
    function openModal() {
        $('#formModal').modal('toggle')
    }

    function submitForm()
    {
        let code        = $('input[name=code]').val()
        let user_id     = $('select[name=user_id]').val()
        let name        = $('input[name=name]').val()

        if(code && user_id && name) {
            let url     = "{{route('master.poliklinik.check')}}"
            let data    = {
                code: code,
                user_id: user_id,
                name: name
            }
            ajaxRequest('POST', url, data).then((result) => {
                $('#input-form').trigger('submit')
            }).catch(err => {
                toastr.warning(err.responseJSON.message)
            })
            
        } else {
            toastr.warning(`Input tidak boleh kosong!`)
        }

    }

    function resetForm() {
        $('input[name=name]').val('')
        $('input[name=code]').val('')
        $('select[name=user_id]').val('')
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
                                    Klinik
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-success" onclick="openModal()" >
                                            Tambah Data
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Klinik</th>
                                                <th>Nama Klinik</th>
                                                <th>Nama Petugas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($poliklinik as $i => $item)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->code}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->user->name}}</td>
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
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="formModalLabel">Tambah Data Klinik</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
                <div class="card-body card-block">
                    <form method="POST" id="input-form" >
                        @csrf
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="" class=" form-control-label">Kode</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="" name="code" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="" class=" form-control-label">Klinik</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="" name="name" placeholder="" class="form-control">
                            </div>
                        </div>
                            
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Petugas</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="user_id" id="select" class="form-control">
                                    <option value="" selected disabled >-- Pilih Dokter --</option>
                                    @foreach ($user as $item)
                                        <option value="{{$item->id}}">{{$item->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
           </div>
           <div class="modal-footer">
               <button type="reset" class="btn btn-secondary" onclick="resetForm()" >Cancel</button>
               <button type="submit" class="btn btn-success" onclick="submitForm()">Confirm</button>
           </div>
       </div>
   </div>
</div>
@endsection