## Panduan Fitur Aplikasi

Aplikasi ini adalah sistem perpustakaan berbasis web yang menyediakan berbagai fitur untuk pengguna umum dan admin. Berikut adalah daftar fitur yang tersedia:

### Fitur untuk Pengguna Umum
1. **Beranda (Home)**  
   - Menampilkan informasi umum tentang perpustakaan.
   - Akses melalui URL: `/`.

2. **Bookstore**  
   - Menampilkan daftar buku yang tersedia di perpustakaan.  
   - Akses melalui URL: `/bookstore`.

3. **Detail Buku**  
   - Melihat detail informasi buku tertentu.  
   - Akses melalui URL: `/book/{id}`.

4. **Peminjaman Buku**  
   - Melihat daftar buku yang sedang dipinjam.  
   - Akses melalui URL: `/borrowed` (autentikasi diperlukan).  
   - Meminjam buku baru melalui form peminjaman.

5. **Pengembalian Buku**  
   - Mengembalikan buku yang telah dipinjam.  
   - Akses melalui URL: `/borrowed/{id}/return`.

6. **Profil Pengguna**  
   - Mengedit informasi profil pengguna.  
   - Akses melalui URL: `/profile`.

### Fitur untuk Admin
1. **Dashboard Admin**  
   - Menampilkan statistik dan laporan perpustakaan.  
   - Akses melalui URL: `/dashboard` (autentikasi dan peran admin diperlukan).

2. **Manajemen Buku**  
   - Menambahkan buku baru ke perpustakaan.  
   - Mengedit, memperbarui, atau menghapus buku yang ada.  
   - Akses melalui URL: `/dashboard/books-list` dan `/dashboard/books/addbooks`.

3. **Manajemen Peminjaman**  
   - Melihat daftar permintaan peminjaman buku.  
   - Menyetujui atau menolak permintaan peminjaman.  
   - Akses melalui URL: `/dashboard/admin/borrowed` dan `/borrow-requests`.

4. **Laporan Peminjaman**  
   - Menampilkan laporan peminjaman buku.  
   - Mengekspor laporan ke dalam format PDF.  
   - Akses melalui URL: `/reports` dan `/reports/export-pdf`.

### Fitur Tambahan
1. **Pencarian Buku**  
   - Fitur pencarian cepat untuk menemukan buku berdasarkan kata kunci.  
   - Dapat diakses melalui input pencarian di bagian header.

2. **Pengujian Data**  
   - Route khusus untuk pengujian data status peminjaman.  
   - Akses melalui URL: `/test-dikembalikan`.

### Teknologi yang Digunakan
- **Frontend**: Tailwind CSS, Alpine.js
- **Backend**: Laravel Framework
- **Database**: MySQL
- **Build Tools**: Vite

### Cara Menjalankan Aplikasi
1. Clone repository ini ke komputer lokal Anda.
2. Jalankan perintah berikut untuk menginstal dependensi:
   ```sh
   composer install
   npm install