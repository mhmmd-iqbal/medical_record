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
        $('#input-form').trigger('submit')
    }

    function resetForm() {
        $('input[name=username]').val('')
        $('input[name=password]').val('')
        $('select[name=auth_level]').val('')
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
                                    User
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
                                                <th>Username</th>
                                                <th>Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $i => $item)
                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>{{$item->username}}</td>
                                                    <td>{{$item->auth_level}}</td>
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
               <h5 class="modal-title" id="formModalLabel">Pendaftaran Peserta</h5>
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
                                <label for="" class=" form-control-label">Username</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="" name="username" placeholder="" class="form-control">
                            </div>
                        </div>
    
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for=""  class=" form-control-label">Password</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="password" id="" name="password" placeholder="" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class="form-control-label">Level</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="auth_level" id="select" class="form-control">
                                    <option value="" selected disabled >-- Pilih Level --</option>
                                    <option value="admin" >Admin</option>
                                    <option value="poliklinik" >Poliklinik</option>
                                    <option value="apoteker" >Apoteker</option>
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