<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mobil</title>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js "></script>
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css " rel="stylesheet">

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/script.js"></script>

    <script>
        var token = store.get('login');
        if(!token) goto('auth');

        var tbl = new DataTable('#datatable');

        var data = async function(){
            await axios.get('<?=env('API_URL')?>/car/manage/all').then(function(r){
                res = r.data;
                if(res.status == 1){
                    var tmp = "";
                    res.data.forEach(function(v,k){
                        tmp += "<tr>";
                        tmp += "<td>"+v.merek+"</td>";
                        tmp += "<td>"+v.model+"</td>";
                        tmp += "<td>"+v.plat_no+"</td>";
                        tmp += "<td>"+v.harga_sewa+"</td>";
                        tmp += "<td><a href=\"javascript:void(0);\" onclick=\"getData('"+v.id+"')\"><i class=\"fa fa-edit\"></i></a>&nbsp;<a href=\"javascript:void(0);\" onclick=\"delData('"+v.id+"')\"><i class=\"fa fa-trash\"></i></a></td>";
                        tmp += "</tr>";
                    });
                    tbl.destroy();
                    $("#datatable tbody").html(tmp);
                    tbl = new DataTable('#datatable');
                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: res.message,
                        icon: "warning"
                    });
                }
            }).catch(function(e){
                Swal.fire({
                    title: "Gagal",
                    text: "Gagal mengambil data mobil",
                    icon: "warning"
                });
            });
        }

        var delData = function(id){
            Swal.fire({
                title: "Apakah anda yakin ingin menghapusnya?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Hapus"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios.post('<?=env('API_URL')?>/car/manage/del',{id:id}).then(function(r){
                        res = r.data;
                        if(res.status == 1){
                            Swal.fire({
                                title: "Berhasil",
                                text: res.message,
                                icon: "success",
                            }).then(function(){
                                data();
                            });
                        } else {
                            Swal.fire({
                                title: "Gagal",
                                text: res.message,
                                icon: "warning"
                            });
                        }
                    }).catch(function(e){
                        Swal.fire({
                            title: "Gagal",
                            text: "Gagal menghapus data mobil",
                            icon: "warning"
                        });
                    });
                }
            });
        }

        var getData = async function(id){
            await axios.post('<?=env('API_URL')?>/car/manage/get',{id:id}).then(function(r){
                var res = r.data,
                    el = null;

                if(res.status == 1){
                    var dt = Object.entries(res.data);
                    dt.forEach(function(v,k){
                        el = $("[name='"+v[0]+"']");
                        if(el.length > 0){
                            el.val(v[1]);
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: res.message,
                        icon: "warning"
                    });
                }
            }).catch(function(e){
                console.log(e)
                Swal.fire({
                    title: "Gagal",
                    text: "Gagal mengambil data mobil",
                    icon: "warning"
                });
            });
        }

        var sendData = async function(){
            var res = null,
                postData = {},
                forms = $("#form-car").serializeArray();

            if(forms.length > 0){
                forms.forEach(function(v,k){
                    postData[v.name] = v.value;
                });

                var url = ((postData['id']!='')?'<?=env('API_URL')?>/car/manage/edit':'<?=env('API_URL')?>/car/manage');

                await axios.post(url,postData).then(function(r){
                    res = r.data;
                    if(res.status == 1){
                        Swal.fire({
                            title: "Berhasil",
                            text: res.message,
                            icon: "success",
                        }).then(function(){
                            data();
                            $("#form-car [name='id']").val('');
                            $("#form-car [name='status']").val('0');
                            $("#form-car")[0].reset();
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal",
                            text: "Coba periksa kembali data anda",
                            icon: "warning"
                        });
                    }
                }).catch(function(e){
                    Swal.fire({
                        title: "Gagal",
                        text: "Coba periksa kembali data anda",
                        icon: "warning"
                    });
                });
            }
        }
    </script>

</head>
<body>
    <div class="container">
        <form id="form-car">
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Merek</label>
                    <input type="text" class="form-control" name="merek" />
                </div>
                <div class="col-6">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" name="model" />
                </div>
                <div class="col-6">
                    <label class="form-label">Nomor Plat</label>
                    <input type="text" class="form-control" name="plat_no" />
                </div>
                <div class="col-6">
                    <label class="form-label">Harga Sewa per Hari</label>
                    <input type="number" class="form-control" name="harga_sewa" />
                </div>
                <div class="text-end">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="status" value="0" />
                    <button type="button" class="btn btn-warning text-light" onclick="goto('home')">Kembali</button>
                    <button type="button" class="btn btn-success text-light" onclick="sendData()">Simpan</button>
                </div>
            </div>
        </form>
        <div class="table">
            <table id="datatable">
                <thead>
                    <tr>
                        <th>Merek</th>
                        <th>Model</th>
                        <th>Nomor Plat</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            // first load get data
            data();
        });
    </script>
</body>
</html>