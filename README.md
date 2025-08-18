## E-Nilai Web Application

### Tujuan pembuatan aplikasi:

- Mempermudah guru dalam menginput nilai siswa.
- Mempercepat proses rekap nilai.
- Menyediakan data nilai yang terorganisir dan bisa diakses oleh walikelas maupun pihak sekolah secara cepat.
- Mengurangi kesalahan dalam perhitungan dan penyalinan nilai.

### Software Requirement:
1. **[UC-001] - Login dan Hak Akses**, yaitu fitur yang diperuntukan untuk admin, guru, dan wali kelas
2. **[UC-002] - Manajemen Data Siswa**, yaitu fitur yang digunakan untuk mengolah (Input dan Update) data siswa berdasarkan kelas.
3. **[UC-003] - Input Nilai**, yaitu fitur yang digunakan untuk mengolah data nilai siswa, seperti Nilai Tugas, UTS dan UAS.
4. **[UC-004] - Perhitungan Otomatis**, yaitu fitur yang berguna untuk melakukan kalkulasi Nilai Akhir secara otomatis.
5. **[UC-005] - Laporan Nilai**, yaitu fitur yang berguna untuk mencetak nilai persiswa dan rekap perkelas.
6. **[UC-006] - Export Data**, yaitu fitur yang digunakan untuk mencetak laporan dalam bentuk Excel atau PDF.
7. **[UC-007] - Riwayat Penginputan**, yaitu fitur yang digunakan untuk mencatat dan mengelola log aktivitas pengguna.

## Teknologi (Stack) yang digunakan
- **[Laravel Framework 12.21.0](https://laravel.com/)**
- **[Filament v3.3.34](https://filamentphp.com/)**
- **[MariaDB](https://mariadb.org/)**
- **[Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)**

## Instalasi Dependency (Linux Debian/Ubuntu)
### 1. Apache ###
- Install Apache weh server
```
sudo apt install apache2
```

- Cek instalasi:
```
sudo systemctl status apache2
```

### 2. Php 8.3 ###

- Install php
```
sudo apt install software-properties-common ca-certificates lsb-release apt-transport-https

sudo add-apt-repository ppa:ondrej/php

sudo apt install php8.3 libapache2-mod-php8.3 php8.3-intl php8.3-mysql php8.3-zip php8.3-xml php8.3-mbstring

```

- Cek instalasi:
```
php -v
```

### 3. Composer ###


### 4. NVM ###
- Install NVM
```
sudo apt install curl

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash

source ~/.bashrc

```

- Cek nvm version:
```
nvm --version
```

- Cek nvm remote repository:
```
nvm ls-remote
```

- Install NodeJs
```
nvm install 20.18.2  
```
- Cek Instalasi
```
node -v  
```


## Running Apps
- Copy file konfigurasi
```
cp .env.example .env
```
- update koneksi database
```

```
- Install Dependency laravel dan yang lainnya
```
composer install
```
