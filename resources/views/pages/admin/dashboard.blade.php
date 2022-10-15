@extends('partials.master')
@section('title', 'DASHBOARD')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        function patientRegister()
        {
            $('#staticModal').modal('toggle')
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
                                <h5 class="title text-right" style="color: white">Rabu, 13 Oktober 2022 | 14:00 WIB</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h3>DAFTAR ANTRIAN KLINIK KONOHA</h3>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-4">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner text-center">
                                                <h4>POLIKLINIK UMUM</h4>
                                                <h3>01</h3>
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="col-4">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner text-center">
                                                <h4>POLIKLINIK GIGI</h4>
                                                <h3>01</h3>
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="col-4">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner text-center">
                                                <h4>POLIKLINIK BERSALIN</h4>
                                                <h3>01</h3>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                                <div class="row mt-5">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" onclick="javascript:patientRegister()"> Daftarkan Peserta </button>
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
<div class="modal fade" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true"
data-backdrop="static">
   <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="staticModalLabel">Pendaftaran Peserta</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">NIK</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <div class="input-group">
                                <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                {{-- <small class="form-text text-muted">This is a help text</small> --}}
                                <div class="input-group-btn">
                                    <button onclick="javascript:void(0)" class="btn btn-success" >
                                        <i class="fa fa-search"></i> Check
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="email-input" class=" form-control-label">Nama</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="email-input" name="email-input" placeholder="Enter Email" class="form-control">
                            {{-- <small class="help-block form-text">Please enter your email</small> --}}
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="email-input" class=" form-control-label">Tanggal Lahir</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="email-input" name="email-input" placeholder="Enter Email" class="form-control">
                            {{-- <small class="help-block form-text">Please enter your email</small> --}}
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="email-input" class=" form-control-label">No HP</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="email-input" name="email-input" placeholder="Enter Email" class="form-control">
                            {{-- <small class="help-block form-text">Please enter your email</small> --}}
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Jenis Kelamin</label>
                        </div>
                        <div class="col col-md-9">
                            <div class="form-check-inline form-check">
                                <label for="inline-radio1" class="form-check-label mr-2">
                                    <input type="radio" id="inline-radio1" name="inline-radios" value="option1" class="form-check-input">Pria
                                </label>
                                
                                <label for="inline-radio3" class="form-check-label mr-2">
                                    <input type="radio" id="inline-radio3" name="inline-radios" value="option3" class="form-check-input">Wanita
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="textarea-input" class=" form-control-label">Keluhan Awal</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea name="textarea-input" id="textarea-input" rows="2" placeholder="Content..." class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="select" class="form-control-label">Poliklinik</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="select" id="select" class="form-control">
                                <option value="0">Please select</option>
                                <option value="1">Option #1</option>
                                <option value="2">Option #2</option>
                                <option value="3">Option #3</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Nomer Antrian</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <b class="form-control-static">00</b>
                        </div>
                    </div>

                </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               <button type="button" class="btn btn-success">Confirm</button>
           </div>
       </div>
   </div>
</div>
@endsection
