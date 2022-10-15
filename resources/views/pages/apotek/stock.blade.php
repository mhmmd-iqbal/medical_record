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
        $('#input-form').attr("method", "POST");
        $('#input-form').attr("action", "{{route('stock.create')}}");

        $('input[name=name]').val('').attr('readonly', false)
        $('input[name=quantity]').val(0)
    }

    function submitForm()
    {
        let name        = $('input[name=name]').val()
        let quantity    = $('input[name=quantity]').val()

        if (name && quantity) {
            $('#input-form').trigger('submit')
        } else {
            toastr.warning('Input tidak boleh kosong!')
        }
    }

    function updateData(el) {
        let id      = $(el).data('id')
        let name    = $(el).data('name')

        $('#formModal').modal('toggle')
        $('#input-form').attr("action", "{{route('stock.update', ':id')}}".replace(':id', id));

        $('input[name=name]').val(name).attr('readonly', true)
    }

    function resetForm() {
        $('#formModal').modal('toggle')
        $('#input-form').attr("action", "{{route('stock.create')}}");
        $('input[name=name]').attr('readonly', false)
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
                                    Data Stock
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
                                                <th>Nama Stock</th>
                                                <th>Quantity Tersedia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stock as $i => $item)
                                                <tr>
                                                    <td>
                                                        {{$loop->iteration}}
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="javascript:updateData(this)" data-name="{{$item->name}}" data-id="{{$item->id}}">
                                                            {{$item->name}}
                                                        </a>
                                                    </td>
                                                    <td>{{$item->quantity}} PCS</td>
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
               <h5 class="modal-title" id="formModalLabel">Tambah Data Stock</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
                <div class="card-body card-block">
                    <form method="POST" id="input-form" >
                        @csrf
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <label for="" class=" form-control-label">Nama Stock</label>
                            </div>
                            <div class="col-12 col-md-12">
                                <input type="text" id="" name="name" placeholder="" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <label for="" class=" form-control-label">Jumlah Stock</label>
                            </div>
                            <div class="col-12 col-md-12">
                                <input type="number" id="" name="quantity" value="0" placeholder="" class="form-control"  min="0" oninput="this.value = Math.abs(this.value)">
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