<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Cara Installasi
- copy .env.example menjadi .env
- tambahkan variabel "API_URL=.../api" pada file .env
- setting .env
- database yang di pakai saat ini adalah postgres tapi nanti di coba juga dengan mysql
- versi php yang dipakai adalah versi 8.1
- setelah setting selesai, lakukan migration dengan perintah : php artisan migrate
- setelah selesai migrate, tinggal kunjungi halaman utamanya yakni di : http://[HTTP_HOST]/auth

## Catatan
- saat ini template masih standard menggunakan native all laravel blade
- javascript menggunakan jquery, bootstrap, axios, datepicker, bootstrap-datagrid
- kemungkinan belum semua fitur ter-delivery, mohon maaf sebelumnya
