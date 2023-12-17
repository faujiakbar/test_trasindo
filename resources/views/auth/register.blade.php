<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js "></script>
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css " rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/script.js"></script>

    <script>
        var token = store.get('login');
        if(token) goto('home');
    </script>

    <script>
        var sendData = async function(){
            var res = null,
                postData = {},
                forms = $("#form-register").serializeArray();

            if(forms.length > 0){
                forms.forEach(function(v,k){
                    postData[v.name] = v.value;
                });

                await axios.post('<?=env('API_URL')?>/auth/reg',postData).then(function(r){
                    res = r.data;
                    if(res.status == 1){
                        Swal.fire({
                            title: "Berhasil",
                            text: res.message+", password anda : "+res.data.password,
                            icon: "success",
                        }).then(function(){
                            goto('auth');
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

            // console.log(res);
        }
        
    </script>

</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-title text-center border-bottom">
                        <h2 class="p-3">Register</h2>
                    </div>
                    <div class="card-body">
                    <form id="form-register">
                        <div class="mb-4">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">No. SIM</label>
                            <input type="text" class="form-control" name="no_sim" />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control" name="no_hp" />
                        </div>
                        <div class="mb-4">
                            <label for="username" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat"></textarea>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-success text-light" onclick="sendData()">Daftar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>