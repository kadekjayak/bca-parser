# KlikBCA Parser
Class ini berfungsi untuk login dan mengambil data daftar mutasi rekening di KlikBCA (m.klikbca.com)

## Installation
Download class nya, kemudian include di project php mu...
	
	require 'BCAParser.php';

##Requirements
* PHP curl
* PHP openssl


## Example
fungsi kelas ini cuma 2 yaitu Login, dan mengambil tabel data transaksi berdasarkan range tanggal tertentu

### Login
ketika class ini di di buat, secara otomatis ia akan login ke klik bca melalui CURL

	$Parser = new BCAParser('username', 'password');
	
### Mengambil Mutasi Rekening
mengambil mutasi rekening dapat menggunakan method `getMutasiRekening` dengan parameter range tanggal transaksi yang diinginkan `getMutasiRekening(dari, sampai)`. Contoh :
	
	$Html = $Parser->getMutasiRekening('2016-08-1', '2016-08-12');

method ini me return element html `<table>` yang berisikan daftar transaksi

## Notes
Untuk debug atau menampilkan response CURL nya, cukup ubah value `BCA_PARSER_DEBUG` pada class ini menjadi `true`