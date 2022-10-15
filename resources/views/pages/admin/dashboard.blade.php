@extends('partials.master')
@section('title', 'DASHBOARD')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        
        function time() {
            let time = $('#time');
            let d = new Date();

            let month = d.toLocaleString('default', { month: 'long' });
            let day = d.getUTCDate();
            let year = d.getUTCFullYear();

            newdate = year + "/" + month + "/" + day;
            newdate = `${day} ${month} ${year}`

            let s = d.getSeconds();
            let m = d.getMinutes();
            let h = d.getHours();
            let show = ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
            time.html(newdate +' | '+show) 
        }

        setInterval(time, 1000);

        function patientRegister()
        {
            $('#queueModal').modal('toggle')
        }

        function checkNIK()
        {
            let nik = $('input[name=nik]').val()
            let url = "{{route('patient.show', ':nik' )}}".replace(':nik', nik)

            ajaxRequest('GET', url).then((res) => {
                if (res.result) {
                    notification('success', 'Data Pasien Ditemukan!')
                    $('input[name=name]').attr('readonly', true).val(res.result.name);
                    $('input[name=date_of_birth]').attr('readonly', true).val(res.result.date_of_birth);
                    $('input[name=phone]').attr('readonly', true).val(res.result.phone);
                    $('input[name=gender]').attr('disabled', false);
                    if(res.result.gender === 'male') {
                        $('input[name=gender][value=male]').prop('checked', true);
                    } else {
                        $('input[name=gender][value=female]').prop('checked', true);
                    }
                } else {
                    notification('warning', 'Data Pasien Tidak Ditemukan!')
                    $('input[name=name]').attr('readonly', false);
                    $('input[name=date_of_birth]').attr('readonly', false);
                    $('input[name=phone]').attr('readonly', false);
                    $('input[name=gender]').attr('disabled', false);
                }
                }).catch((err) => {
                    
                });
        }

        function submitQueue()
        {
            let nik             = $('input[name=nik]').val()
            let name            = $('input[name=name]').val()
            let phone           = $('input[name=phone]').val()
            let gender          = $('input[name=gender]').val()
            let date_of_birth   = $('input[name=date_of_birth]').val()
            let medical_issue   = $('textarea[name=medical_issue]').val()
            let poliklinik_id   = $('select[name=poliklinik_id]').val()

            if(nik && name && date_of_birth && phone && gender && medical_issue && poliklinik_id) {
                let url     = "{{route('patient.store')}}"
                let data    = {
                        nik: nik,
                        name: name,
                        phone: phone,
                        gender:gender,
                        date_of_birth: date_of_birth,
                        medical_issue: medical_issue,
                        poliklinik_id: poliklinik_id
                    }

                ajaxRequest('POST', url, data).then((result) => {
                    let url = "{{route('queue.poliklinik.count', ":id")}}".replace(':id', poliklinik_id)

                    ajaxRequest('GET', url).then(res => {
                        let count = res.result
                        let test = $(`#queue-poliklinik-${poliklinik_id}`).html(String(count).padStart(2, '0'))    
                        console.log(test)
                        toastr.success(`Antrian telah diinput!`)
                        resetForm()
                    }).catch(err => {

                    })

                }).catch((err) => {
                    
                });
            } else {
                toastr.error(`Input tidak boleh kosong!`)
            }

        }

        function resetForm()
        {
            $('input[name=nik]').val('')
            $('input[name=name]').val('')
            $('input[name=date_of_birth]').val('')
            $('input[name=phone]').val('')
            $('input[name=gender]').prop('checked', false)
            $('textarea[name=medical_issue]').val('')
            $('select[name=poliklinik_id]').val('')

            $('input[name=name]').attr('readonly', true);
            $('input[name=date_of_birth]').attr('readonly', true);
            $('input[name=phone]').attr('readonly', true);
            $('input[name=gender]').attr('disabled', true);

            $('#queue-no').html(String(0).padStart(2, '0'))
            $('#queueModal').modal('toggle')
        }

        function checkPoliQueue()
        {
            let id  = $('select[name=poliklinik_id]').val()
            let url = "{{route('queue.poliklinik.count', ":id")}}".replace(':id', id)
            ajaxRequest('GET', url).then(res => {
                let next_count = res.result + 1
                $('#queue-no').html(String(next_count).padStart(2, '0'))
            }).catch(err => {

            })
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
                                <h5 class="title text-right" style="color: white" id="time">-: -:-:-</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <h3>DAFTAR ANTRIAN KLINIK KONOHA</h3>
                                    </div>
                                </div>
                                <div class="row mt-5" id="poliklinik-list">
                                    @foreach ($poliklinik as $item)
                                    <div class="col-4">
                                        <div class="au-card m-b-30">
                                            <div class="au-card-inner text-center">
                                                <h4>{{$item->name}}</h4>
                                                <h3 id="queue-poliklinik-{{$item->id}}">{{str_pad ($item->queues_count, 2, "0", STR_PAD_LEFT) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
<div class="modal fade" id="queueModal" tabindex="-1" role="dialog" aria-labelledby="queueModalLabel" aria-hidden="true"
data-backdrop="static">
   <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="queueModalLabel">Pendaftaran Peserta</h5>
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
                                <input type="text" id="text-input" name="nik" placeholder="" class="form-control">
                                <div class="input-group-btn">
                                    <button onclick="javascript:checkNIK()" class="btn btn-success" >
                                        <i class="fa fa-search"></i> Check
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="" class=" form-control-label">Nama</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" readonly id="" name="name" placeholder="" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="" class=" form-control-label">Tanggal Lahir</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" readonly id="" name="date_of_birth" placeholder="" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for=""  class=" form-control-label">No HP</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" readonly id="" name="phone" placeholder="" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Jenis Kelamin</label>
                        </div>
                        <div class="col col-md-9">
                            <div class="form-check-inline form-check">
                                <label for="inline-radio1" class="form-check-label mr-2">
                                    <input type="radio" disabled id="inline-radio1" name="gender" value="male" class="form-check-input">Pria
                                </label>
                                
                                <label for="inline-radio3" class="form-check-label mr-2">
                                    <input type="radio" disabled id="inline-radio3" name="gender" value="female" class="form-check-input">Wanita
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="textarea-input" class=" form-control-label">Keluhan Awal</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea name="medical_issue" id="" rows="2" placeholder="Keluhan..." class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="select" class="form-control-label">Poliklinik</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="poliklinik_id" onchange="javascript:checkPoliQueue()" id="select" class="form-control">
                                <option value="" selected disabled >-- Pilih Poliklinik --</option>
                                @foreach ($poliklinik as $item)
                                    <option value="{{$item->id}}" > {{$item->code}} - {{$item->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Nomer Antrian</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <b class="form-control-static" id="queue-no">00</b>
                        </div>
                    </div>

                </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" onclick="javascript:resetForm()" >Cancel</button>
               <button type="button" class="btn btn-success" onclick="javascript:submitQueue()">Confirm</button>
           </div>
       </div>
   </div>
</div>
@endsection
