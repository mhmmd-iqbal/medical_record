@extends('partials.master')
@section('title', 'DAFTAR PASIEN')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let idPatient
        let medicalIssue
        const patientDetail = (e) => {
            idPatient = $(e).data().value
            medicalIssue = $(e).data().medical_issue
            console.log(medicalIssue)
            $('#medical_issue').html(medicalIssue)
            $('#medicalRecordModal').modal('toggle')
            getMedicalRecord(idPatient)
        }

        function getMedicalRecord(id) {
            let url = "{{ route('medical-record.show', ':id') }}".replace(':id', id)
            ajaxRequest('GET', url).then(res => {
                let data = res.result
                renderView(data)
                resetForm()
            }).catch(err => {

            })
        }

        function renderView(data) {
            var content = ''
            var subContent = ''
            data.forEach((element, index) => {
                if (element.medicine_lists == null) {
                    element.medicine_lists.forEach((elementMR, indexMR) => {
                        subContent += `
                    <tr>
                        <td>${indexMR + 1}</td>
                        <td>${elementMR.stocks_id}</td>
                        <td>${elementMR.quantity}</td>
                        <td>${elementMR.created_at}</td>
                    </tr>
                    `
                    });
                } else {
                    subContent = `
                    <tr>
                        <td colspan="4" class="text-center">Data kosong</td>
                    </tr>
                    `
                }
                content += `
                <button class="btn text-left" data-toggle="collapse"
                    data-target="#collapseChild${index + 1}" aria-expanded="true"
                    aria-controls="collapseChild${index + 1}">
                    <div class="card-header" id="headingOne${index + 1}">
                        <h5 class="text-light font-weight-bold mb-0">
                            ${index + 1}
                        </h5>
                    </div>
                </button>

                <div id="collapseChild${index + 1}" class="collapse" aria-labelledby="headingOne${index + 1}"
                    data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h3>Riwayat Penyakit</h3>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Keluhan</th>
                                                <th>Penanganan</th>
                                                <th>Dokter</th>
                                                <th>Tanggal Dirawat</th>
                                                <th>Tanggal Keluar</th>
                                            </tr>
                                        </thead>
                                        <tbod>
                                            <tr>
                                                <td>1</td>
                                                <td>${element.medical_issue != null ? element.medical_issue : '-'}</td>
                                                <td>${element.medical_handle != null ? element.medical_handle : '-'}</td>
                                                <td>${element.user.name != null ? element.user.name : '-'}</td>
                                                <td>${element.treated_at != null ? element.treated_at : '-'}</td>
                                                <td>${element.treated_to != null ? element.treated_to : '-'}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h3>Riwayat Obat</h3>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Obat</th>
                                                <th>Jumlah</th>
                                                <th>Ditebus Pada</th>
                                            </tr>
                                        </thead>
                                        <tbod>
                                            ${subContent}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `
            });

            $('#medicalRecordList').html(content);
        }

        function addMedicine() {
            let medicalHandle = $('input[name=medical_handle]').val()
            let stockID = $('select[name=stock_id]').val()
            let quantity = $('input[name=quantity]').val()


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
                    let url = "{{ route('queue.poliklinik.count', ':id') }}".replace(':id', poliklinik_id)

                    ajaxRequest('GET', url).then(res => {
                        let count = res.result
                        let test = $(`#queue-poliklinik-${poliklinik_id}`).html(String(count).padStart(2,
                            '0'))
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

        function resetForm() {
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
            $('#medicalRecordModal').modal('toggle')
        }

        const listData = $('#list-datatables').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            fixedColumns: {
                heightMatch: 'none'
            },
            ajax: {
                url: '',
                data: (req) => {

                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'patient.name',
                    name: 'name'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'medical_issue',
                    name: 'medical_issue'
                },
                {
                    data: 'createdAt',
                    name: 'createdAt'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        })
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
                                    Daftar Pasien
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive pt-2">
                                    <table class="table table-bordered table-active" id="list-datatables">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Keluhan</th>
                                                <th>Terdaftar Pada</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
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
    <div class="modal fade" id="medicalRecordModal" tabindex="-1" role="dialog" aria-labelledby="medicalRecordModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="medicalRecordModalLabel">Riwayat Penanganan dan Resep</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body card-block">
                        <div id="accordionMedicalRecord">
                            <div class="card">
                                <button class="btn text-left" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0 text-light font-weight-bold">
                                            Riwayat Penyakit dan Resep
                                        </h5>
                                    </div>
                                </button>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordionMedicalRecord">
                                    <div class="card-body">
                                        <div id="accordion">
                                            <div class="card" id="medicalRecordList">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="textarea-input" class=" form-control-label">Keluhan</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p id="medical_issue"></p>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="textarea-input" class=" form-control-label">Penanganan</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="medical_handle" id="" rows="2" placeholder="Penanganan..." class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col col-md-3">
                                        <label for="select" class="form-control-label">Obat</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="stock_id" id="select" class="form-control">
                                            <option value="" selected disabled>-- Pilih Obat --</option>
                                            @foreach ($medicines as $item)
                                                <option value="{{ $item->id }}"> {{ $item->name }} -
                                                    {{ $item->quantity }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="row">
                                    <div class="col col-md-3">
                                        <label for="" class=" form-control-label">Quantity</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="" name="quantity" placeholder=""
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-success" onclick="javascript:addMedicine()">+</button>
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
