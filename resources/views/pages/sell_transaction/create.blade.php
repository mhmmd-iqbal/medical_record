@extends('partials.master')
@section('title', 'TAMBAH PRODUCT')

@section('custom_styles')
<style>
    .ck-editor__editable {
        min-height: 300px;
    }

    
  
</style>
@endsection

@section('custom_scripts')
<script>
    var myEditor;
    var dataTable = []
    var productID = ''
    var quantity  = 0
    $(document).ready(function () {

        $('.select2').select2({
            minimumInputLength: 1,
            tags: [],
            placeholder: "Pilih Produk",
            ajax: {
                url: "{{route('product.index')}}",
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    };
                }
            }
        });
    });

    const submitData = (e) => {
        let consumen = $('input[name=consumen]').val()
        let address = $('#address').val()
        let err = false
        
        if(consumen === '') {
            err = true;
            toastr.error('<div>Nama consumen Tidak Boleh Kosong!</div>')
        } 

        if(address === '') {
            err = true;
            toastr.error('<div>Alamat consumen Tidak Boleh Kosong!</div>')
        }

        if(dataTable.length == 0) {
            err = true;
            toastr.error('<div>Produk Masih Kosong!</div>')
        }


        if(!err) {
            var form_data = new FormData();                  
            form_data.append('consumen', consumen);
            form_data.append('address', address);
            form_data.append('product', JSON.stringify(dataTable));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: '{{route("sell.transaction.store")}}', // <-- point to server-side PHP script 
                dataType: 'JSON',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'POST',
                beforeSend: () => {
                    var percentage = '0';
                },
                xhr: () => {
					var xhr = new XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(e) {
						if (e.lengthComputable) {
							var uploadpercent = e.loaded / e.total; 
							uploadpercent = (uploadpercent * 100); //optional Math.round(uploadpercent * 100)
							$('.progress-bar').text(uploadpercent + '%');
							$('.progress-bar').width(uploadpercent + '%');
							if (uploadpercent == 100) {
								$('.progress-bar').text('Completed');
							}
						}
					}, false);
					
					return xhr;
				},
                success: (res) => {
                    console.log(res)
                    if(res.status){
                        toastr.success("Berhasil Menambahkan Data")
                        setTimeout(() => { 
                            window.location.href = "{{route('sell.transaction')}}"
                         }, 1000);
                        
                    }else {
                        toastr.error("Gagal Menambahkan Data")
                    }
                },
                error: (xhr, status, error) => {
                    toastr.error(`Gagal: ${xhr.responseText}`)
                    
                }
            });
        }
    }

    const addProduct = () => {
        quantity = $('#quantity').val()
        $.ajax({
            type: "GET",
            url: "{{route('product.show', 'dataID')}}".replace('dataID', productID),
            dataType: "JSON",
            success: function (response) {
                if(response.id != undefined){
                    for(let i = 0; i < quantity; i++) {
                        dataTable.push(response)
                        tableList()
                    }
                }
            }
        });
    }

    $('.select2').on('change', function() {
        productID = $(".select2 option:selected").val();
    })

    const tableList = () => {
        $('#list-data').html('')
        console.log(dataTable)
        dataTable.map((data, iterasi) => {
            $('#list-data').append(`
                <tr>
                    <td>${iterasi+1}</td>
                    <td>${data.name}</td>
                    <td>${data.code}</td>
                    <td>${data.price}</td>
                    <td><i style="cursor: pointer" onclick="removeList(${iterasi})" class="fa fa-times text-danger"></i> </td>
                </tr>
            `)
        })
    }

    const removeList = (iterasi) => {
        if (iterasi > -1) {
            dataTable.splice(iterasi, 1);
        }
        tableList()
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
                                    Transaksi Penjualan
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <div class="label">Nama Konstumer</div>
                                        <input type="text" class="form-control" name="consumen">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7 form-group">
                                        <div class="label">Alamat</div>
                                        <textarea name="address" id="address" class="form-control" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <div class="label">Produk</div>
                                        <select name="category" id="category" class="form-control select2" ></select>
                                    </div>
                                    <div class="col-3 form-group">
                                        <div class="label">Jumlah Dibeli</div>
                                        <div class="input-group">
                                            <input type="number" value="0" class="form-control" name="quantity" id="quantity">
                                            <div class="input-group-append">
                                                <button class="input-group-text" onclick="addProduct()" id="basic-addon2">
                                                    Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="mb-4" for="">Detail Pembelian</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Produk</th>
                                                    <th>Code</th>
                                                    <th>Harga Perproduk</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="list-data">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-12 text-right">
                                        <button class="btn btn-success" onclick="submitData(this)">Simpan</button>
                                    </div>
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
@endsection
