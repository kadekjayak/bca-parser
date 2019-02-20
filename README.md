# KlikBCA Parser
Class ini berfungsi untuk mengambil data mutasi rekening dan saldo di KlikBCA (m.klikbca.com)

## Installation
Install dengan composer:

	composer require kadekjayak/bca-parser:dev-master

## Requirements
* PHP curl
* PHP openssl


## Example

### Login
ketika class ini di di buat, secara otomatis ia akan login ke klik bca melalui CURL
	
	use BCAParser\BCAParser;
	$Parser = new BCAParser('username', 'password');
	

### Mengambil Mutasi Rekening
mengambil mutasi rekening dapat menggunakan method `getMutasiRekening` dengan parameter range tanggal transaksi yang diinginkan `getMutasiRekening(dari, sampai)`. Contoh :
	
	$Html = $Parser->getMutasiRekening('2016-08-1', '2016-08-12');

method ini me return element html `<table>` yang berisikan daftar transaksi

jika ingin hasil dalam format array gunakan method `getListTransaksi(dari, sampai)`, lihat source nya langsung.


### Mengambil Mutasi Rekening Credit
Untuk mengambil histori transaksi uang yang masuk ke dalam rekening (kredit) dapat menggunakan method `getTransaksiCredit` dengan parameter range tanggal transaksi yang diinginkan `getTransaksiCredit(dari, sampai)`. Contoh :
	
	$Html = $Parser->getTransaksiCredit('2016-11-20', '2016-11-27');

Struktur Array yang dihasilkan kurang lebih seperti berikut, perhatikan ada perbedaan value antara transaksi Antar Rekening dan transaksi Antar Bank :
	
	Array
	(
	    [3] => Array
	        (
	            [date] => 2016-11-22
	            [description] => Array
	                (
	                	//Transaksi Antar Rekening
	                    [0] => TRSF E-BANKING CR 
	                    [1] => 11/22 33223       
	                    [2] => Komentar              
	                    [3] => Kadek Jayak
	                    [4] => 0000
	                    [5] => 20,000.00 //Jumlah Transfer
	                )

	            [flows] => CR
	        )

	    [4] => Array
	        (
	            [date] => 2016-11-25
	            [description] => Array
	                (
	                	//Transaksi Antar BANK
	                    [0] => SWITCHING CR      
	                    [1] => TRANSFER   DR 013 
	                    [2] => Kadek Jayak
	                    [3] => Nama BANK
	                    [4] => 0999
	                    [5] => 200,000.00
	                )

	            [flows] => CR
	        )

	)

### Mengambil Mutasi Rekening Debet
Untuk mengambil histori transaksi uang yang keluar dari rekening (debet) dapat menggunakan method `getTransaksiDebit` dengan parameter range tanggal transaksi yang diinginkan `getTransaksiDebit(dari, sampai)`. Contoh :
	
	$Html = $Parser->getTransaksiDebit('2016-11-20', '2016-11-27');

Struktur Array yang dihasilkan kurang lebih seperti berikut, perhatikan ada perbedaan value di tiap jenis transaksi :
	
	Array
	(
		[0] => Array
			(
				[date] => 2019-02-18
				[description] => Array
					(
						[0] => SWITCHING DB
						[1] => TANGGAL :16/02
						[2] => TRANSFER   KE 000
						[3] => KADEK JAYAK
						[4] => M-BCA
						[5] => 0000
						[6] => 2,275,000.00
					)

				[flows] => DB
			)

		[1] => Array
			(
				[date] => 2019-02-18
				[description] => Array
					(
						[0] => TARIKAN ATM 16/02
						[1] => 0000
						[2] => 200,000.00
					)

				[flows] => DB
			)

		[2] => Array
			(
				[date] => 2019-02-18
				[description] => Array
					(
						[0] => BYR VIA E-BANKING
						[1] => 18/02  WSID000000
						[2] => 00000 MERCHANT
						[3] => 55100000000
						[4] => KADEK JAYAK
						[5] => 0000
						[6] => 850,272.00
					)

				[flows] => DB
			)

		[3] => Array
			(
				[date] => 2019-02-19
				[description] => Array
					(
						[0] => TRSF E-BANKING DB
						[1] => 00000/FTFVA/WS00000
						[2] => 00000/MERCHANT
						[3] => -
						[4] => -
						[5] => 0105000000
						[6] => 0000
						[7] => 125,987.00
					)

				[flows] => DB
			)

	)

### Cek Saldo
Mengambil informasi saldo thanks to @jojoarianto
	
	$Parser->getSaldo();
	
struktur array yang dihasilkan seperti dibawah ini:
	
	Array
	(
		[0] => Array
			(
				[rekening] => 6110000000	// Nomor Rekening
				[saldo] => 12,123,551.15	// Saldo
			)

	)


### Logout
Logout dapat dilakukan dengan memanggil method `logout()`, pastikan anda logout setelah mengambil data transaksi, jika tidak kemungkinan anda harus menunggu 10 menit untuk dapat login melalui web KlikBca.


## Notes
Untuk debug atau menampilkan response CURL nya, cukup ubah value `BCA_PARSER_DEBUG` pada class ini menjadi `true`.
Aktivitas login dibatasi setiap 10 menit oleh bank, jika ingin membuat script "autocheck" pastikan waktu interval pengecekan nya diatas 10 menit !.

Update: 
- Lakukan Logout setelah mengambil data transaksi dari KlikBCA dengan begitu anda tidak perlu menunggu 10 menit untuk proses berikutnya *Perlu di Test
