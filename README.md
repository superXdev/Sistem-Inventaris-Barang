# Intro
Sistem inventaris berbasis website, bebas digunakan untuk kebutuhan apa saja

![App Screenshot](https://github.com/superXdev/Sistem-Inventaris-Barang/raw/master/ss.png)

## Admin credentials
**username:** admin
**password:** admin123

## Tech Stack

**Client:** [ruangAdmin](https://github.com/indrijunanda/RuangAdmin), Bootstrap, Jquery, filePond

**Server:** PHP 7.4.x, Laravel 8.x

  
## Menu

- Dashboard
- Daftar petugas (admin, staff gudang/barang)
- Daftar barang
- Daftar gudang
- Daftar supplier
- Barang masuk
- Barang keluar
- Laporan
- Profile (ganti pp & password)
  
## Installation 

You can fork or clone this project

```
composer install
cp .env.example .env <-- edit db config
php artisan install
```

## Running Tests

To run tests, run the following command

```
php artisan test
```

```
Tests:  44 passed
Time:   20.30s
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). 
