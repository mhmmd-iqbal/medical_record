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

            let month = d.toLocaleString('default', {
                month: 'long'
            });
            let day = d.getUTCDate();
            let year = d.getUTCFullYear();

            newdate = year + "/" + month + "/" + day;
            newdate = `${day} ${month} ${year}`

            let s = d.getSeconds();
            let m = d.getMinutes();
            let h = d.getHours();
            let show = ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
            time.html(newdate + ' | ' + show)
        }

        setInterval(time, 1000);

        function detail(e) {
            let id = $(e).data('id')
            let url = "{{ route('medicine.list.medical', ':id') }}".replace(":id", id)

            ajaxRequest('GET', url).then((res) => {
                let html = ''
                $('#list-medicine').html(html);
                if (res.result) {
                    res.result.forEach((value) => {
                        console.log(value)
                        html = `<tr>
                                <td>${value.stock.name}</td>
                                <td>${value.quantity} pcs</td>
                                <td>${value.stock.quantity} pcs</td>
                                <td>
                                    <label class="switch switch-text switch-success">
                                        <input type="checkbox" class="switch-input status" data-quantity="${value.quantity}" data-id="${value.id}" >
                                        <span data-on="On" data-off="Off" class="switch-label"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </td>
                            </tr>`

                        $('#list-medicine').append(html);
                    });
                } else {
                    html = `<tr><td colspan="4"> -- Tidak Ada List --</td> </tr>`
                    $('#list-medicine').html(html);
                }
            }).catch((err) => {

            });

            $('button[type=submit]').attr('data-id', id);
            $('#formModal').modal('toggle')
        }

        function submitForm(el) {
            let id = $(el).data('id')
            let input = []
            let url = '{{ route('medicine.list.approve', ':id') }}'.replace(":id", id)
            document.querySelectorAll('input[type=checkbox]').forEach((element, index) => {
                input[index] = {
                    id: $(element).data('id'),
                    quantity: $(element).data('id'),
                    status: $(element).is(':checked'),
                }
            });

            let data = {
                input: input
            }

            ajaxRequest('POST', url, data).then((res) => {
                toastr.success(`Data Obat Telah di verifikasi!`)
                window.location.reload()
            }).catch((err) => {
                toastr.warning(err.responseJSON.message)
            });
        }

        function resetForm() {
            $('button[type=submit]').removeAttr('data-id');
            $('#list-medicine').html('');
            $('#formModal').modal('toggle')
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
                                        <h3>DAFTAR LIST OBAT</h3>
                                    </div>
                                </div>
                                <div class="row mt-5" id="poliklinik-list">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Pasien</th>
                                                <th>NIK</th>
                                                <th>Doktor PJ</th>
                                                <th>Poli</th>
                                                <th>List Obat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($medical_record))
                                                @foreach ($medical_record as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->patient->name }} </td>
                                                        <td>{{ $item->patient->nik }} </td>
                                                        <td>{{ $item->user->name }} </td>
                                                        <td>{{ $item->user->polikliniks[0]->name }} </td>
                                                        <td>
                                                            @foreach ($item->medicineLists as $medicine)
                                                                <div>{{ $medicine->stock->name }} </div>
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" onclick="javascript:detail(this)"
                                                                data-id="{{ $item->id }}">Detail</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7"> -- Belum Ada Data --</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
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
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Daftar Obat Yang Di Keluarkan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body card-block">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Stock Dibutuhkan</th>
                                    <th>Stock Tersisa</th>
                                    <th>Approval</th>
                                </tr>
                            </thead>
                            <tbody id="list-medicine"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" onclick="resetForm()">Cancel</button>
                    <button type="submit" class="btn btn-success" onclick="submitForm(this)">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- $('input[type=checkbox]').is(':checked') --}}
