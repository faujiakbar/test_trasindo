<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjaman Mobil</title>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js "></script>
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css " rel="stylesheet">

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css">
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/script.js"></script>

    <script>
        var token = store.get('login');
        if(!token) goto('auth');

        var tbl = new DataTable('#datatable');

        var data = async function(){
            await axios.get('<?=env('API_URL')?>/car/rent/all').then(function(r){
                res = r.data;
                if(res.status == 1){
                    var tmp = "";
                    res.data.forEach(function(v,k){
                        tmp += "<tr>";
                        tmp += "<td>"+v.rent_start+"</td>";
                        tmp += "<td>"+v.rent_end+"</td>";
                        tmp += "<td>"+v.car.merek+" - "+v.car.model+" - "+v.car.plat_no+"</td>";
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

        var getOptionMobil = async function(){
            await axios.get('<?=env('API_URL')?>/car/ready').then(function(r){
                res = r.data;
                if(res.status == 1){
                    var tmp = "";
                    if(res.data.length > 0) {
                        res.data.forEach(function(v,k){
                            tmp += "<option value=\""+v.id+"\">"+v.merek+" - "+v.model+" - "+v.plat_no+"</td>";
                        });
                    }
                    $("[name='id_car']").html(tmp);
                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: res.message,
                        icon: "warning"
                    });
                }
            }).catch(function(e){
                console.log(e);
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

                // get data user token
                postData['hash'] = token.hash;

                var url = '<?=env('API_URL')?>/car/rent';

                await axios.post(url,postData).then(function(r){
                    res = r.data;
                    if(res.status == 1){
                        Swal.fire({
                            title: "Berhasil",
                            text: res.message,
                            icon: "success",
                        }).then(function(){
                            data();
                            getOptionMobil();
                            $("#form-car [name='id']").val('');
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
                    <label class="form-label">Mobil</label>
                    <select class="form-control" name="id_car"></select>
                </div>
                <div class="col-6">
                    <label class="form-label">Tanggal Awal Sewa</label>
                    <input type="text" class="form-control datepicker" name="rent_start" />
                </div>
                <div class="col-6">
                    <label class="form-label">Tanggal Akhir Sewa</label>
                    <input type="text" class="form-control datepicker" name="rent_end" />
                </div>
                <div class="text-end">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="id_user" value="1" />
                    <button type="button" class="btn btn-warning text-light" onclick="goto('home')">Kembali</button>
                    <button type="button" class="btn btn-success text-light" onclick="sendData()">Simpan</button>
                </div>
            </div>
        </form>
        <div class="table">
            <table id="datatable">
                <thead>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Mobil</th>
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
            getOptionMobil();

            $(".datepicker").datepicker({
                format:"yyyy-mm-dd"
            });
        });
    </script>
</body>
</html>