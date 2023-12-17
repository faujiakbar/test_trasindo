<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js "></script>
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css " rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet">
    <script src="/js/script.js"></script>

    <script>
        var token = store.get('login');
        if(!token) goto('auth');
    </script>

</head>
<body>
    <div class="container">
        <ul class="menu">
            <li onclick="goto('car/manage')">
                <a href="javascript:void(0);">Manajemen Mobil</a>
            </li>
            <li onclick="goto('car/rent')">
                <a href="javascript:void(0);">Pinjaman Mobil</a>
            </li>
            <li onclick="goto('car/withdraw')">
                <a href="javascript:void(0);">Pengembalian Mobil</a>
            </li>
            <li onclick="logout()">
                <a href="javascript:void(0);">Keluar</a>
            </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>