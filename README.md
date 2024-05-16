<div align="center">
    <p>
        <a href="https://github.com/404NotFoundIndonesia/" target="_blank">
            <img src="https://avatars.githubusercontent.com/u/87377917?s=200&v=4" width="200" alt="404NFID Logo">
        </a>
    </p>

 [![GitHub Stars](https://img.shields.io/github/stars/iqbaleff214/hour-meter-tracking-system.svg)](https://github.com/iqbaleff214/hour-meter-tracking-system/stargazers)
 [![GitHub license](https://img.shields.io/github/license/iqbaleff214/hour-meter-tracking-system)](https://github.com/iqbaleff214/hour-meter-tracking-system/blob/main/LICENSE)
 
</div>

# Hour Meter Tracking System

Pengelolaan unit alat berat, khususnya dalam industri perkebunan kelapa sawit seperti yang dilakukan oleh PT Eshan Agro Sentosa, membutuhkan sistem yang efisien dan terpadu. Dengan menerapkan sistem informasi yang terintegrasi, dapat membantu dalam proses penginputan data jam operasional (_hour meter_) unit di setiap anak perusahaan PT EAS.

Beberapa tantangan yang dihadapi oleh PT Eshan Agro Sentosa adalah:
1. Penggunaan sistem debit cast oleh PT Eshan Agro Sentosa.
2. Ketidaksempurnaan dalam operasional: Proses manual memerlukan banyak waktu dan tenaga. Pengelola harus memeriksa ketersediaan suku cadang untuk setiap unit sebelum melakukan servis berkala.

Untuk meningkatkan kualitas layanan dan efisiensi operasional, diperlukan pengembangan sistem informasi manajemen untuk memasukkan data jam operasional. Sistem ini akan membantu PT EAS dan anak perusahaannya. Lokasi penelitian berada di Jalan Kodeco No 09, Gunung Antasari, Kecamatan Simpang Empat, Kabupaten Tanah Bumbu, Kalimantan Selatan 72211.

Penelitian ini diharapkan dapat memberikan kontribusi positif bagi PT Eshan Agro Sentosa dan industri perkebunan secara keseluruhan. Dengan sistem informasi yang terintegrasi, pengelolaan jam operasional akan lebih efisien, kesalahan dapat diminimalkan, dan periode servis dapat ditingkatkan. Dengan demikian, penelitian ini akan difokuskan pada "Pembuatan _Hour Meter Tracking System_ Berbasis Web Menggunakan Laravel Pada PT EAS".

## Memulai

### Prasyarat

- Anda memerlukan [PHP](https://www.php.net/downloads) untuk menjalankannya, dengan versi yang terinstal minimal **PHP 8.3.4**. Pastikan Anda juga dapat mengakses PHP melalui command line dengan menambahkannya ke [environment variable path](https://rgrahardi.medium.com/pengaturan-path-php-dan-composer-di-environment-variables-windows-10-e1e22a637618).
- Pastikan [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) juga terinstal dan dapat diakses melalui command line.
- Pastikan Anda juga telah menginstall [MySQL](https://dev.mysql.com/downloads/mysql/).
- Direkomendasikan untuk menginstall [Git](https://git-scm.com/downloads) untuk manajemen kode yang lebih baik.

### Mengunduh _Source Code_
Anda perlu mengunduh atau menggunakan Git untuk mendapatkan _source code_ ini di komputer Anda. Ada dua cara untuk melakukannya, silakan pilih salah satu.

1. **Unduh File Zip Proyek**

    Anda dapat klik [tautan ini](https://github.com/iqbaleff214/hour-meter-tracking-system/archive/refs/heads/main.zip) untuk mengunduh file zip dari proyek ini.

2. **Git Clone**

    Pastikan Anda telah menginstall git. Buka direktori di terminal tempat Anda ingin menaruh _source code_. Kemudian, jalankan perintah berikut:
    ```shell
    git clone git@github.com:iqbaleff214/hour-meter-tracking-system.git
    ```

### Instal Dependensi

Pastikan proyek ini sudah terbuka di command line Anda. Untuk memastikan direktori aktif sekarang Anda di terminal, gunakan perintah berikut:
```shell
pwd
```

Untuk menginstall dependensi backend, gunakan perintah berikut:
```shell
composer setup
```

Perintah di atas cukup dijalankan __satu kali__ saja!

### Cara Menjalankan
Anda harus membuka dua buah command line untuk menjalankan proyek ini. Masing-masing digunakan untuk bagian backend dan frontend.

Untuk menjalankan server backend, gunakan perintah berikut:
```shell
php artisan serve
```

Buka http://localhost:8000 di web browser Anda untuk mengakses _Hour Meter Tracking System_.


## License

__Hour Meter Tracking System__ adalah perangkat lunak _open-source_ yang dilisensikan di bawah lisensi [MIT license](https://github.com/iqbaleff214/hour-meter-tracking-system?tab=MIT-1-ov-file).
