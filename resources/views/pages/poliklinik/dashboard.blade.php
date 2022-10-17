@extends('partials.master')
@section('title', 'DAFTAR PASIEN')

@section('custom_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var itemsMedicines = []
        var indexMedicine = 0

        let idPatient
        var medicalIssue
        const patientDetail = (e) => {
            idPatient = $(e).data().value
            medicalIssue = $(e).data().medical_issue
            $('#medical_issue').html(medicalIssue)
            $('#medicalRecordModal').modal('toggle')
            getMedicalRecord(idPatient)
        }

        function addMedicineList() {
            let medicalHandle = $('input[name=medical_handle]').val()
            let stockID = $('select[name=stock_id]').val()
            let stockName = $('select[name=stock_id] option:selected').text()
            let quantity = $('input[name=quantity]').val()

            if (stockID == '' || quantity == '') {
                return alert('Isi semua data terlebih dahulu')
            }

            indexMedicine = indexMedicine + 1;
            idItem = 'medicine' + indexMedicine;

            itemsMedicines.push({
                idItem: idItem,
                stockID: stockID,
                stockName: stockName,
                quantity: quantity,
            });

            $("#stock_id option[value=0]").attr("selected", "selected");
            $('input[name=quantity]').val('');

            $("#dummy_data_medicine").remove();
            $("#list_medicine").append(`
                <tr id="${idItem}">
                    <td>${indexMedicine}</td>
                    <td>${stockName}</td>
                    <td>${quantity}</td>
                    <td><button type="button" onClick="removeListMedicine('${idItem}');" class="btn btn-icon btn-danger btn-relief-danger rounded-circle mb-1 waves-effect waves-light">X</button></td>
                </tr>
            `);

            $('input[name=quantity]').focus();
            var listItemMedicine = JSON.stringify(itemsMedicines);
            // $("#pengalamanKerja").val(listItemPengalamanKerja);

            console.table(itemsMedicines);
            return false;
        }

        function removeListMedicine(id) {
            var idItem = id.substr(id.length - 1);

            $("#" + id).remove();

            const deleteIndex = itemsMedicines.findIndex(item => item.idItem === id);
            itemsMedicines.splice(deleteIndex, 1);
            $("#bahasa").focus();

            if (itemsMedicines.length == 0) {
                $("#list_medicine").append(`
                    <tr id="dummy_data_medicine">
                        <td colspan="6">Isi minimal 1 data</td>
                    </tr>
                `);
            }
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

        function submitMedicalRecord() {
            let userID = "{{ Auth::user()->id }}"
            let medicalHandle = $('textarea[name=medical_handle]').val()
            console.log(idPatient, userID, medicalHandle, medicalIssue)
            if (idPatient && userID && medicalHandle && medicalIssue) {
                let url = "{{ route('medical-record.store') }}"
                let data = {
                    patient_id: idPatient,
                    user_id: userID,
                    medical_hanlde: medicalHandle,
                    medical_issue: medicalIssue,
                    medicine_list: itemsMedicines
                }

                ajaxRequest('POST', url, data).then((result) => {
                    toastr.success(`Data berhasil disimpan`)
                    resetForm()
                }).catch((err) => {

                });
            } else {
                toastr.error(`Input tidak boleh kosong!`)
            }
        }

        function resetForm() {
            $('textarea[name=medical_handle]').val('')
            $("#stock_id option[value=0]").attr("selected", "selected")
            $('#medicalRecordModal').modal('toggle')
            $('input[name=quantity]').val('')
            itemsMedicines = []

            $("#list_medicine").empty()
            $("#list_medicine").append(`
                <tr id="dummy_data_medicine">
                    <td colspan="4">Tambah data terlebih dahulu</td>
                </tr>
            `);
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
                                        <select name="stock_id" id="stock_id" class="form-control">
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
                                <button type="button" class="btn btn-success"
                                    onclick="javascript:addMedicineList()">+</button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <table id="datatable"
                                    class="table zero-configuration table-striped table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Obat</th>
                                            <th>Quantity</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_medicine">
                                        <tr id="dummy_data_medicine">
                                            <td colspan="4">Tambah data terlebih dahulu</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="javascript:resetForm()">Cancel</button>
                    <button type="button" class="btn btn-success"
                        onclick="javascript:submitMedicalRecord()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endsection
