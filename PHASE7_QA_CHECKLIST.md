# LibraryGenz — Phase 7 QA Checklist
> Production Hardening & Final System Polish

---

## 1. ADMIN ROLE SCENARIOS

### Authentication & Access
- [ ] Admin dapat login dengan akun aktif
- [ ] Admin yang dinonaktifkan tidak bisa login (ditolak dengan pesan error)
- [ ] Admin logout tercatat di activity log
- [ ] Admin tidak bisa akses route member/librarian-only

### Dashboard Admin
- [ ] Stats cards menampilkan data real (total users, logs, fine rate)
- [ ] Tabel "Pengguna Terbaru" menampilkan 5 user terakhir
- [ ] Empty state muncul jika belum ada pengguna
- [ ] Quick action buttons berfungsi (Atur Denda, Laporan, Audit Logs)
- [ ] Server stats (Laravel version, PHP, DB) tampil benar

### Manajemen Pengguna (Admin)
- [ ] Halaman `/admin/users` menampilkan daftar dengan pagination
- [ ] Filter by role (admin/librarian/member) berfungsi
- [ ] Filter by status (aktif/nonaktif) berfungsi
- [ ] Search by nama/email berfungsi
- [ ] Tombol "Tambah Pengguna Baru" mengarah ke form create
- [ ] Form create: validasi nama, email unik, password min 8 char, role required
- [ ] Form create: akun berhasil dibuat dan muncul di daftar
- [ ] Form edit: data user ter-prefill dengan benar
- [ ] Form edit: update nama/email/role/status berhasil
- [ ] Toggle status: konfirmasi modal muncul sebelum eksekusi
- [ ] Toggle status: admin tidak bisa nonaktifkan akun sendiri
- [ ] Reset password: validasi confirmed berfungsi
- [ ] Reset password: password baru bisa digunakan login
- [ ] Export PDF users berfungsi dan menghasilkan file

### Katalog Buku
- [ ] Daftar buku tampil dengan pagination (15/halaman)
- [ ] Filter kategori berfungsi
- [ ] Filter ketersediaan (tersedia/habis) berfungsi
- [ ] Search judul/penulis berfungsi
- [ ] Tombol Export PDF berfungsi
- [ ] Tambah buku: validasi semua field
- [ ] Edit buku: data ter-prefill, update berhasil
- [ ] Hapus buku: konfirmasi modal muncul, buku terhapus
- [ ] Empty state muncul jika tidak ada hasil pencarian

### Peminjaman (Admin)
- [ ] Tab Pending menampilkan permintaan dengan pagination
- [ ] Tab Aktif menampilkan peminjaman aktif dengan pagination
- [ ] Tab Riwayat menampilkan log historis dengan pagination
- [ ] Filter by member name/email berfungsi
- [ ] Filter by date range berfungsi
- [ ] Export PDF peminjaman berfungsi
- [ ] Setujui: konfirmasi modal muncul, stok berkurang
- [ ] Tolak: form alasan muncul inline, status berubah
- [ ] Serahkan Buku: konfirmasi modal, status → borrowed
- [ ] Tandai Kembali: konfirmasi modal, stok bertambah, denda dibuat jika terlambat
- [ ] Empty state muncul di setiap tab jika kosong

### Denda (Admin)
- [ ] Analytics cards menampilkan total unpaid/paid/waived
- [ ] Tab Belum Dibayar dengan pagination
- [ ] Tab Riwayat dengan pagination
- [ ] Filter by member berfungsi
- [ ] Export PDF denda berfungsi
- [ ] Terima Pembayaran: konfirmasi modal, status → paid
- [ ] Bebaskan Denda: form alasan inline, status → waived
- [ ] Empty state muncul jika tidak ada denda

### Laporan & Analitik
- [ ] Halaman reports menampilkan semua data
- [ ] Export Statistik PDF berfungsi
- [ ] Export Peminjaman PDF berfungsi
- [ ] Export Denda PDF berfungsi
- [ ] Tren peminjaman 12 bulan tampil dengan bar chart

### Activity Logs
- [ ] Semua log tampil dengan pagination (20/halaman)
- [ ] Filter by user name berfungsi
- [ ] Filter by activity type berfungsi
- [ ] Login/logout/register tercatat
- [ ] Approve/reject/return/fine payment tercatat
- [ ] Export actions tercatat
- [ ] Empty state muncul jika tidak ada log

---

## 2. LIBRARIAN ROLE SCENARIOS

### Authentication & Access
- [ ] Librarian dapat login
- [ ] Librarian tidak bisa akses `/admin/users`, `/activity-logs`, `/admin/settings`
- [ ] Librarian bisa akses `/borrowings/manage`, `/fines/manage`, `/books`, `/categories`

### Dashboard Librarian
- [ ] Stats cards: total buku, pending approval, overdue, denda selesai
- [ ] Antrean verifikasi menampilkan 5 pending terlama
- [ ] Approve dari dashboard: konfirmasi modal, berhasil
- [ ] Reject dari dashboard: form alasan inline, berhasil
- [ ] Empty state muncul jika tidak ada pending
- [ ] Activity feed menampilkan 5 aktivitas terbaru
- [ ] Link "Lihat Antrean Lengkap" mengarah ke `/borrowings/manage`

### Katalog & Kategori
- [ ] Librarian bisa tambah/edit/hapus buku
- [ ] Librarian bisa tambah/edit/hapus kategori
- [ ] Konfirmasi modal muncul sebelum hapus

### Peminjaman & Denda
- [ ] Semua workflow peminjaman berfungsi sama seperti admin
- [ ] Export PDF tersedia

---

## 3. MEMBER ROLE SCENARIOS

### Authentication & Access
- [ ] Member dapat login dan register
- [ ] Member tidak bisa akses route admin/librarian
- [ ] Member yang dinonaktifkan tidak bisa login

### Dashboard Member
- [ ] Stats: katalog tersedia, sedang dipinjam, riwayat selesai, tagihan denda
- [ ] Tabel buku aktif dipinjam dengan sisa hari / status terlambat
- [ ] Empty state muncul jika tidak ada peminjaman aktif
- [ ] Link "Lihat Semua Riwayat" berfungsi
- [ ] Aturan pinjam buku tampil di panel kanan

### Katalog Buku (Member)
- [ ] Card grid tampil dengan pagination (12/halaman)
- [ ] Filter kategori dan ketersediaan berfungsi
- [ ] Search berfungsi
- [ ] Tombol "Ajukan Pinjam": konfirmasi modal muncul
- [ ] Buku stok habis: tombol disabled
- [ ] Empty state muncul jika tidak ada hasil

### Riwayat Peminjaman
- [ ] Semua peminjaman tampil dengan pagination
- [ ] Filter by status berfungsi
- [ ] Tombol "Batalkan": konfirmasi modal, hanya untuk status 'requested'
- [ ] Empty state muncul jika belum ada peminjaman

### Denda Member
- [ ] Tab Denda Aktif menampilkan unpaid fines
- [ ] Tab Riwayat menampilkan paid/waived fines
- [ ] Empty state muncul di kedua tab jika kosong
- [ ] Kebijakan denda tampil di info card

---

## 4. BORROW WORKFLOW END-TO-END

- [ ] Member ajukan pinjam → status 'requested'
- [ ] Librarian setujui → status 'approved', stok -1
- [ ] Librarian serahkan buku → status 'borrowed', borrow_date & due_date diset
- [ ] Setelah 7 hari → status otomatis 'overdue'
- [ ] Librarian proses kembali (tepat waktu) → status 'returned', stok +1, tidak ada denda
- [ ] Librarian proses kembali (terlambat) → status 'returned', stok +1, fine dibuat otomatis
- [ ] Member tidak bisa ajukan buku yang sama jika masih aktif
- [ ] Member bisa batalkan jika masih 'requested'

---

## 5. FINE WORKFLOW END-TO-END

- [ ] Denda dibuat otomatis saat return terlambat (Rp2.000/hari)
- [ ] Denda muncul di fines.manage (unpaid tab)
- [ ] Denda muncul di fines.history member (unpaid tab)
- [ ] Librarian terima pembayaran → status 'paid', paid_at diset
- [ ] Librarian bebaskan denda → status 'waived', notes tersimpan
- [ ] Analytics cards update setelah transaksi

---

## 6. EXPORT WORKFLOW

- [ ] Export Peminjaman PDF: file terdownload, data lengkap
- [ ] Export Denda PDF: file terdownload, summary stats benar
- [ ] Export Users PDF: file terdownload, semua user tercantum
- [ ] Export Buku PDF: file terdownload, katalog lengkap
- [ ] Export Statistik PDF: file terdownload, most borrowed & recent borrowings
- [ ] Setiap export tercatat di activity log
- [ ] Member tidak bisa akses export routes (403)

---

## 7. ACCESS CONTROL

- [ ] Guest tidak bisa akses `/dashboard`, `/books`, `/borrowings`, `/fines`
- [ ] Guest diarahkan ke `/login`
- [ ] Authenticated user di `/` diarahkan ke dashboard sesuai role
- [ ] Admin tidak bisa akses `/dashboard/librarian` atau `/dashboard/member`
- [ ] Member tidak bisa akses `/borrowings/manage`, `/fines/manage`
- [ ] Member tidak bisa akses `/books/create`, `/books/{id}/edit`
- [ ] Inactive user tidak bisa login (pesan error spesifik)

---

## 8. FLASH NOTIFICATIONS & UX

- [ ] Toast notification muncul setelah setiap action (success/error)
- [ ] Toast auto-dismiss setelah 5 detik
- [ ] Toast bisa di-dismiss manual
- [ ] Confirmation modal muncul sebelum semua destructive actions
- [ ] Confirmation modal bisa dibatalkan
- [ ] Pagination berfungsi di semua halaman yang memilikinya
- [ ] Pagination mempertahankan query string (filter tidak hilang)
- [ ] Empty states tampil dengan icon dan pesan yang relevan

---

## 9. RESPONSIVE

- [ ] Landing page tampil baik di mobile (320px+)
- [ ] Sidebar mobile (hamburger) buka/tutup dengan smooth
- [ ] Dashboard cards stack di mobile
- [ ] Tabel scroll horizontal di mobile
- [ ] Form inputs full-width di mobile
- [ ] Tombol aksi tidak terpotong di mobile

---

## 10. PERFORMANCE

- [ ] Tidak ada N+1 query di halaman index (eager loading aktif)
- [ ] Pagination membatasi query (tidak load semua data)
- [ ] Database indexes aktif (migration sudah dijalankan)
- [ ] Build assets ter-minify (npm run build sukses)
