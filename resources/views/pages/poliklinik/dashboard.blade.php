@extends('partials.master')
@section('title', 'DASHBOARD')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function patientRegister() {
            $('#queueModal').modal('toggle')
        }

        function checkNIK() {
            let nik = $('input[name=nik]').val()
            let url = "{{ route('patient.show', ':nik') }}".replace(':nik', nik)

            ajaxRequest('GET', url).then((result) => {
                if (result.data) {
                    notification('success', 'Data Pasien Ditemukan!')
                    $('input[name=name]').attr('readonly', true);
                    $('input[name=date_of_birth]').attr('readonly', true);
                    $('input[name=phone]').attr('readonly', true);
                    $('input[name=gender]').attr('disabled', true);
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

        function submitQueue() {
            let nik = $('input[name=nik]').val()
            let name = $('input[name=name]').val()
            let phone = $('input[name=phone]').val()
            let gender = $('input[name=gender]').val()
            let date_of_birth = $('input[name=date_of_birth]').val()
            let medical_issue = $('textarea[name=medical_issue]').val()
            let poliklinik_id = $('select[name=poliklinik_id]').val()

            if (nik && name && date_of_birth && phone && gender && medical_issue && poliklinik_id) {
                let url = "{{ route('patient.store') }}"
                let data = {
                    nik: nik,
                    name: name,
                    phone: phone,
                    gender: gender,
                    date_of_birth: date_of_birth,
                    medical_issue: medical_issue,
                    poliklinik_id: poliklinik_id
                }

                ajaxRequest('POST', url, data).then((result) => {
                    resetForm()
                }).catch((err) => {

                });
            } else {
                alert('Input tidak boleh kosong!')
            }

        }

        function resetForm() {
            $('input[name=nik]').val('')
            $('input[name=name]').val('')
            $('input[name=date_of_birth]').val('')
            $('input[name=phone]').val('')
            $('input[name=gender]').val('')
            $('textarea[name=medical_issue]').val('')
            $('select[name=poliklinik_id]').val('')

            $('input[name=name]').attr('readonly', true);
            $('input[name=date_of_birth]').attr('readonly', true);
            $('input[name=phone]').attr('readonly', true);
            $('input[name=gender]').attr('disabled', true);

            $('#queueModal').modal('toggle')
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
                                        <button class="btn btn-success" onclick="javascript:patientRegister()"> Daftarkan
                                            Peserta </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                {{ date('Y') }} @ Konoha Hospitally
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
    <div class="modal fade" id="queueModal" tabindex="-1" role="dialog" aria-labelledby="queueModalLabel"
        aria-hidden="true" data-backdrop="static">
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
                                    <input type="text" id="text-input" name="nik" placeholder=""
                                        class="form-control">
                                    <div class="input-group-btn">
                                        <button onclick="javascript:checkNIK()" class="btn btn-success">
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
                                <input type="text" readonly id="" name="name" placeholder=""
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="" class=" form-control-label">Tanggal Lahir</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="date" readonly id="" name="date_of_birth" placeholder=""
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="" class=" form-control-label">No HP</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" readonly id="" name="phone" placeholder=""
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">Jenis Kelamin</label>
                            </div>
                            <div class="col col-md-9">
                                <div class="form-check-inline form-check">
                                    <label for="inline-radio1" class="form-check-label mr-2">
                                        <input type="radio" disabled id="inline-radio1" name="gender" value="male"
                                            class="form-check-input">Pria
                                    </label>

                                    <label for="inline-radio3" class="form-check-label mr-2">
                                        <input type="radio" disabled id="inline-radio3" name="gender" value="female"
                                            class="form-check-input">Wanita
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
                                <select name="poliklinik_id" id="select" class="form-control">
                                    <option value="" selected disabled>-- Pilih Poliklinik --</option>
                                    @foreach ($poliklinik as $item)
                                        <option value="{{ $item->id }}"> {{ $item->code }} - {{ $item->name }}
                                        </option>
                                    @endforeach
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
                    <button type="button" class="btn btn-secondary" onclick="javascript:resetForm()">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="javascript:submitQueue()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endsection
