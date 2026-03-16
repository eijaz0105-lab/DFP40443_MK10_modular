# DFP40443 MK10 – Modular PHP Project<br><br>

## Pengenalan<br>
Projek ini merupakan sistem tempahan biskut yang dibina menggunakan PHP tanpa pangkalan data.<br>
Projek asal telah distruktur semula supaya menjadi lebih modular dan mudah diselenggara.<br><br>

Sistem ini membolehkan pengguna:<br>
- Melihat katalog produk<br>
- Membuat tempahan biskut<br>
- Mengira jumlah harga secara automatik<br>
- Menjana invois tempahan<br>
- Mencetak invois<br><br>

---

# Struktur Projek<br>

DFP40443_MK10_modular<br><br>

index.php<br>
includes/<br>
&nbsp;&nbsp;&nbsp;&nbsp;header.php<br>
&nbsp;&nbsp;&nbsp;&nbsp;nav.php<br>
&nbsp;&nbsp;&nbsp;&nbsp;footer.php<br><br>

data/<br>
&nbsp;&nbsp;&nbsp;&nbsp;products.php<br><br>

processes/<br>
&nbsp;&nbsp;&nbsp;&nbsp;functions.php<br><br>

css/<br>
&nbsp;&nbsp;&nbsp;&nbsp;style.css<br><br>

gambar/<br>
&nbsp;&nbsp;&nbsp;&nbsp;gambar produk<br><br>

---

# Modul yang Dipecahkan<br>

Projek asal hanya menggunakan satu fail utama.<br>
Struktur projek telah dipecahkan kepada beberapa modul untuk memudahkan pengurusan kod.<br><br>

### 1. includes<br>

Folder ini mengandungi komponen paparan (view) yang digunakan berulang.<br><br>

header.php – Bahagian kepala laman<br>
nav.php – Navigasi menu<br>
footer.php – Bahagian bawah laman<br><br>

Ini mengelakkan pengulangan kod HTML pada setiap halaman.<br><br>

---

### 2. data<br>

Fail ini menyimpan data produk.<br><br>

products.php mengandungi senarai produk seperti:<br>
- nama produk<br>
- gambar produk<br>
- harga mengikut saiz<br><br>

Dengan cara ini data boleh diurus di satu tempat sahaja.<br><br>

---

### 3. processes<br>

Folder ini mengandungi semua logik pemprosesan sistem.<br><br>

functions.php mengandungi function seperti:<br>
- getMenu()<br>
- processOrder()<br>
- generateInvoice()<br>
- findProductById()<br><br>

Semua proses logik dipisahkan daripada paparan.<br><br>

---

### 4. css<br>

style.css mengandungi semua gaya CSS untuk laman web.<br><br>

Ini memastikan kod CSS tidak bercampur dengan kod HTML atau PHP.<br><br>

---

# Perbezaan View dan Process<br>

## View<br>

View digunakan untuk memaparkan maklumat kepada pengguna.<br><br>

Contoh:<br>
- HTML untuk paparkan produk<br>
- HTML untuk paparkan borang tempahan<br>
- HTML untuk paparkan invois<br><br>

Fail berkaitan:<br>
- index.php<br>
- includes/header.php<br>
- includes/nav.php<br>
- includes/footer.php<br><br>

---

## Process<br>

Process mengandungi logik program.<br><br>

Contoh:<br>
- mengira jumlah harga tempahan<br>
- membaca data produk<br>
- menjana nombor invois<br>
- memproses tempahan pengguna<br><br>

Fail berkaitan:<br>
- processes/functions.php<br><br>

---

# Kelebihan Struktur Modular<br>

Struktur ini lebih baik kerana:<br><br>

1. Kod lebih tersusun<br>
2. Mudah diselenggara<br>
3. Mengurangkan pengulangan kod<br>
4. Mudah menambah fungsi baharu<br>
5. Memisahkan paparan (view) dan logik sistem (process)<br><br>

Ini juga merupakan amalan yang biasa digunakan dalam pembangunan sistem sebenar.<br><br>

---

# Cara Menjalankan Projek<br>

1. Letakkan folder projek di dalam:<br>

laragon/www<br><br>

2. Jalankan Laragon<br><br>

3. Buka browser dan akses:<br>

http://localhost/DFP40443_MK10_modular<br><br>

---

# Teknologi Digunakan<br>

PHP<br>
HTML<br>
CSS<br>
JavaScript<br>
Session<br><br>

---

# Author<br>

Nama Pelajar:<br>
Kursus: DFP40443 – Web Programming<br>