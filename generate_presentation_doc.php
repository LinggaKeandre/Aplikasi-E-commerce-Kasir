<?php

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\SimpleType\Jc;

$phpWord = new PhpWord();

// Set default font
$phpWord->setDefaultFontName('Calibri');
$phpWord->setDefaultFontSize(11);

// Define styles
$phpWord->addTitleStyle(1, ['size' => 20, 'bold' => true, 'color' => '2E86AB'], ['alignment' => Jc::CENTER]);
$phpWord->addTitleStyle(2, ['size' => 16, 'bold' => true, 'color' => '2E86AB']);
$phpWord->addTitleStyle(3, ['size' => 14, 'bold' => true, 'color' => '4A4A4A']);
$phpWord->addTitleStyle(4, ['size' => 12, 'bold' => true, 'color' => '666666']);

// Create section
$section = $phpWord->addSection([
    'marginTop' => 1000,
    'marginBottom' => 1000,
    'marginLeft' => 1200,
    'marginRight' => 1200,
]);

// Title
$section->addTitle('PENJELASAN FITUR UNIK APLIKASI KASIR', 1);
$section->addText('Dokumentasi Presentasi', ['italic' => true, 'color' => '666666'], ['alignment' => Jc::CENTER]);
$section->addTextBreak(2);

// ========== FITUR 1: CUSTOMER DISPLAY ==========
$section->addTitle('1. CUSTOMER DISPLAY (Layar Pelanggan Real-Time)', 2);
$section->addTextBreak(1);

$section->addTitle('Alur Kerja:', 3);
$section->addListItem('Kasir scan produk di halaman /kasir/transaksi');
$section->addListItem('Server menyimpan data keranjang ke database');
$section->addListItem('Server broadcast event ke Laravel Cache');
$section->addListItem('Customer Display di layar kedua (/kasir/customer-display) polling setiap 500ms');
$section->addListItem('Data produk tampil di layar pelanggan OTOMATIS tanpa refresh');
$section->addListItem('Pelanggan bisa lihat: nama produk, harga, varian, subtotal, total belanja');
$section->addTextBreak(1);

$section->addTitle('Q&A yang Mungkin Ditanya:', 3);

$section->addTitle('Q: Kenapa pakai 2 layar terpisah?', 4);
$section->addText('A: Supaya pelanggan bisa lihat detail belanjaan mereka sendiri, lebih transparan dan profesional. Kasir fokus di layar kasir, pelanggan fokus di layar customer display.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Bagaimana sinkronisasinya?', 4);
$section->addText('A: Customer Display melakukan polling ke server setiap 500 milidetik (setengah detik). Jadi kalau kasir scan produk, dalam waktu maksimal 0.5 detik sudah muncul di layar pelanggan.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Kalau internet lambat gimana?', 4);
$section->addText('A: Karena pakai local network (XAMPP localhost), tidak tergantung internet. Polling cepat karena server ada di komputer yang sama atau jaringan lokal toko.', ['color' => '333333']);
$section->addTextBreak(2);

// ========== FITUR 2: PRODUCT VARIANTS ==========
$section->addTitle('2. PRODUCT VARIANTS (Varian Produk)', 2);
$section->addTextBreak(1);

$section->addTitle('Alur Kerja:', 3);
$section->addListItem('Admin buat produk, centang "Has Variants"');
$section->addListItem('Isi detail varian: nama, stok, harga, barcode unik');
$section->addListItem('Data varian disimpan dalam format JSON di database (1 produk bisa punya banyak varian)');
$section->addListItem('Kasir scan barcode → sistem deteksi apakah barcode produk utama atau varian');
$section->addListItem('Jika varian, harga yang dipakai adalah harga varian (bukan harga produk utama)');
$section->addListItem('Stok varian dikurangi otomatis setelah transaksi');
$section->addTextBreak(1);

$section->addTitle('Q&A yang Mungkin Ditanya:', 3);

$section->addTitle('Q: Contoh kasusnya apa?', 4);
$section->addText('A: Misal produk "Kopi Susu" punya 3 varian: Small (Rp 10.000), Medium (Rp 15.000), Large (Rp 20.000). Masing-masing varian punya barcode sendiri dan stok terpisah.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Kenapa pakai JSON bukan tabel terpisah?', 4);
$section->addText('A: Lebih fleksibel dan simple. Varian tidak selalu punya struktur yang sama (ada varian warna, ukuran, rasa, dll). JSON memudahkan penyimpanan data yang strukturnya bervariasi.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Barcode varian bentuknya gimana?', 4);
$section->addText('A: Admin bebas input barcode manual. Bisa pakai format: [ID_PRODUK]-[KODE_VARIAN]. Misal produk ID 5 varian Small = "5-S", Medium = "5-M", Large = "5-L".', ['color' => '333333']);
$section->addTextBreak(2);

// ========== FITUR 3: DISCOUNT SYSTEM ==========
$section->addTitle('3. DISCOUNT SYSTEM (Sistem Diskon Fleksibel)', 2);
$section->addTextBreak(1);

$section->addTitle('Alur Kerja:', 3);
$section->addListItem('Admin set diskon produk dalam persen (misal 20%)');
$section->addListItem('Sistem hitung harga final = harga asli - (harga asli × diskon)');
$section->addListItem('Jika produk punya varian, diskon berlaku di harga varian');
$section->addListItem('Diskon otomatis muncul di struk dan customer display');
$section->addListItem('Order items simpan 3 harga: product_price (asli), variant_price (varian), final_price (setelah diskon)');
$section->addTextBreak(1);

$section->addTitle('Q&A yang Mungkin Ditanya:', 3);

$section->addTitle('Q: Kenapa simpan 3 harga berbeda?', 4);
$section->addText('A: Untuk tracking dan transparansi. product_price = harga dasar, variant_price = harga varian (jika ada), final_price = harga yang dibayar customer setelah diskon. Jadi bisa lihat berapa besar diskon yang diberikan.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Bisa diskon per item atau harus semua produk?', 4);
$section->addText('A: Bisa per produk. Tiap produk punya field discount sendiri. Jadi bisa satu produk diskon 20%, produk lain 10%, produk lain lagi tanpa diskon.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Diskon bisa dikombinasi dengan voucher member?', 4);
$section->addText('A: Diskon produk dan voucher member adalah 2 hal terpisah. Diskon produk sudah masuk ke harga final, voucher member bisa dipakai di checkout untuk potongan tambahan.', ['color' => '333333']);
$section->addTextBreak(2);

// ========== FITUR 4: REWARDS & GAMIFICATION ==========
$section->addTitle('4. REWARDS & GAMIFICATION (Sistem Hadiah dan Gamifikasi)', 2);
$section->addTextBreak(1);

$section->addTitle('Alur Kerja:', 3);
$section->addListItem('Member belanja → dapat poin (misal Rp 10.000 = 10 poin)');
$section->addListItem('Member bisa klaim daily reward (hadiah harian) di halaman /member/rewards');
$section->addListItem('Daily reward berisi: poin gratis atau voucher diskon');
$section->addListItem('Sistem cek streak (berapa hari berturut-turut login dan klaim)');
$section->addListItem('Poin bisa ditukar voucher di halaman /member/vouchers');
$section->addListItem('Voucher bisa dipakai saat checkout online');
$section->addTextBreak(1);

$section->addTitle('Q&A yang Mungkin Ditanya:', 3);

$section->addTitle('Q: Apa bedanya poin dan voucher?', 4);
$section->addText('A: Poin = mata uang virtual hasil belanja. Voucher = potongan harga yang bisa dipakai checkout. Poin dikumpulkan, voucher langsung dipakai sekali.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Daily reward maksudnya apa?', 4);
$section->addText('A: Member bisa klaim hadiah gratis tiap hari. Kalau klaim berturut-turut (streak), hadiahnya makin besar. Misal hari ke-1 dapat 5 poin, hari ke-7 dapat 50 poin atau voucher Rp 10.000.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Streak itu apa?', 4);
$section->addText('A: Streak = jumlah hari berturut-turut member klaim daily reward. Kalau 1 hari tidak klaim, streak reset ke 0. Ini bikin member rajin buka aplikasi.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Poin bisa hangus?', 4);
$section->addText('A: Di sistem ini poin tidak hangus. Tapi bisa ditambahkan fitur expired date kalau mau bikin lebih menantang.', ['color' => '333333']);
$section->addTextBreak(2);

// ========== FITUR 5: CART DEDUPLICATION ==========
$section->addTitle('5. CART DEDUPLICATION (Penggabungan Item Keranjang Cerdas)', 2);
$section->addTextBreak(1);

$section->addTitle('Alur Kerja:', 3);
$section->addListItem('Member tambah produk ke cart (misal Produk A varian Small)');
$section->addListItem('Sistem cek: apakah produk yang sama + varian yang sama sudah ada di cart?');
$section->addListItem('Jika sudah ada → quantity ditambah (tidak bikin item baru)');
$section->addListItem('Jika belum ada → bikin item cart baru');
$section->addListItem('Berlaku juga untuk kasir saat scan barcode berkali-kali');
$section->addTextBreak(1);

$section->addTitle('Q&A yang Mungkin Ditanya:', 3);

$section->addTitle('Q: Kenapa tidak bikin item baru saja?', 4);
$section->addText('A: Supaya keranjang tidak berantakan. Lebih rapi 1 item dengan quantity 5 daripada 5 item yang sama. Juga mempermudah checkout dan perhitungan.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Bagaimana sistem tahu item "sama"?', 4);
$section->addText('A: Sistem cek kombinasi: product_id + selected_variant (jika ada). Kalau keduanya sama, berarti item yang sama.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Kalau produk sama tapi varian beda gimana?', 4);
$section->addText('A: Dianggap item berbeda. Misal Kopi Small dan Kopi Large = 2 item terpisah di cart. Tapi kalau scan Kopi Small 2x = 1 item quantity 2.', ['color' => '333333']);
$section->addTextBreak(2);

// ========== FITUR 6: MEMBER VERIFICATION ==========
$section->addTitle('6. MEMBER VERIFICATION (Verifikasi Member Transaksi Offline)', 2);
$section->addTextBreak(1);

$section->addTitle('Alur Kerja:', 3);
$section->addListItem('Member datang ke toko, kasir mau kasih poin');
$section->addListItem('Kasir klik "Verifikasi Member" di halaman transaksi');
$section->addListItem('Kasir input nomor HP member atau scan QR member');
$section->addListItem('Sistem cari member berdasarkan nomor HP');
$section->addListItem('Jika ketemu, nama member tampil, kasir konfirmasi');
$section->addListItem('Setelah bayar, poin otomatis masuk ke akun member (meski transaksi offline)');
$section->addTextBreak(1);

$section->addTitle('Q&A yang Mungkin Ditanya:', 3);

$section->addTitle('Q: Kenapa perlu verifikasi?', 4);
$section->addText('A: Supaya transaksi offline tetap dapat poin. Normalnya transaksi kasir tidak terhubung dengan akun member, tapi dengan verifikasi bisa.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Kalau member tidak bawa HP gimana?', 4);
$section->addText('A: Member cukup sebut nomor HP-nya, kasir input manual. Atau bisa login dari HP kasir, tunjukkan QR code member.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Poin langsung masuk atau nunggu?', 4);
$section->addText('A: Langsung masuk setelah transaksi selesai. Member bisa cek di halaman /member/points.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Data order disimpan dimana?', 4);
$section->addText('A: Tabel orders dengan user_id = kasir yang input, member_id = member yang diverifikasi. Jadi bisa tracking siapa kasirnya dan siapa membernya.', ['color' => '333333']);
$section->addTextBreak(2);

// ========== FITUR 7: MULTI-ROLE SYSTEM ==========
$section->addTitle('7. MULTI-ROLE SYSTEM (Sistem Multi Peran)', 2);
$section->addTextBreak(1);

$section->addTitle('Alur Kerja:', 3);
$section->addListItem('User login dengan email dan password');
$section->addListItem('Sistem cek role user: admin / kasir / member');
$section->addListItem('Redirect ke dashboard sesuai role:');
$section->addListItem('   → Admin → /admin (kelola produk, kategori, user, laporan)', 1);
$section->addListItem('   → Kasir → /kasir/transaksi (transaksi offline, customer display)', 1);
$section->addListItem('   → Member → / (katalog, cart, checkout online, voucher, rewards)', 1);
$section->addListItem('Middleware melindungi route berdasarkan role (admin tidak bisa akses kasir, dll)');
$section->addTextBreak(1);

$section->addTitle('Q&A yang Mungkin Ditanya:', 3);

$section->addTitle('Q: Kenapa tidak pakai 1 dashboard untuk semua?', 4);
$section->addText('A: Supaya setiap role fokus pada tugasnya. Admin fokus manage data, kasir fokus transaksi, member fokus belanja. Lebih aman dan tidak membingungkan.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Apa yang terjadi kalau admin coba akses route member?', 4);
$section->addText('A: Middleware akan tolak dengan error 403 Forbidden. Tapi route universal seperti /profile bisa diakses semua role.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Bagaimana keamanannya?', 4);
$section->addText('A: Pakai Laravel middleware. Setiap request dicek rolenya. Kalau tidak sesuai, langsung ditolak sebelum controller dijalankan. Session juga di-monitor, kalau role berubah otomatis logout.', ['color' => '333333']);
$section->addTextBreak(1);

$section->addTitle('Q: Bisa 1 user punya 2 role?', 4);
$section->addText('A: Tidak, 1 user hanya 1 role. Kalau mau akses 2 role, harus bikin 2 akun berbeda. Ini untuk mencegah konflik permission.', ['color' => '333333']);
$section->addTextBreak(2);

// ========== RANGKUMAN ==========
$section->addPageBreak();
$section->addTitle('RANGKUMAN FITUR UNIK', 2);
$section->addTextBreak(1);

// Create table
$tableStyle = [
    'borderSize' => 6,
    'borderColor' => 'CCCCCC',
    'cellMargin' => 80,
    'alignment' => Jc::CENTER,
];
$phpWord->addTableStyle('FeaturesTable', $tableStyle);

$table = $section->addTable('FeaturesTable');

// Header row
$table->addRow(500);
$table->addCell(3000, ['bgColor' => '2E86AB'])->addText('Fitur', ['bold' => true, 'color' => 'FFFFFF'], ['alignment' => Jc::CENTER]);
$table->addCell(4000, ['bgColor' => '2E86AB'])->addText('Keunikan', ['bold' => true, 'color' => 'FFFFFF'], ['alignment' => Jc::CENTER]);
$table->addCell(3000, ['bgColor' => '2E86AB'])->addText('Wow Factor', ['bold' => true, 'color' => 'FFFFFF'], ['alignment' => Jc::CENTER]);

// Data rows
$features = [
    ['Customer Display', 'Sinkronisasi 2 layar real-time tanpa refresh', 'Profesional & transparan'],
    ['Product Variants', '1 produk, banyak varian dengan barcode terpisah', 'Fleksibel untuk berbagai jenis produk'],
    ['Discount System', 'Tracking 3 jenis harga untuk transparansi', 'Laporan detail diskon'],
    ['Rewards System', 'Gamifikasi dengan poin, streak, voucher', 'Member rajin belanja & loyal'],
    ['Cart Deduplication', 'Penggabungan otomatis item sama', 'Keranjang rapi, checkout cepat'],
    ['Member Verification', 'Transaksi offline tetap dapat poin online', 'Bridging online-offline'],
    ['Multi-Role System', 'Pemisahan ketat admin/kasir/member', 'Aman & fokus sesuai tugas'],
];

foreach ($features as $feature) {
    $table->addRow();
    $table->addCell(3000)->addText($feature[0], ['bold' => true]);
    $table->addCell(4000)->addText($feature[1]);
    $table->addCell(3000)->addText($feature[2], ['color' => '2E86AB']);
}

$section->addTextBreak(2);

// ========== TIPS PRESENTASI ==========
$section->addTitle('TIPS PRESENTASI', 2);
$section->addTextBreak(1);

$section->addTitle('1. Demo Langsung', 3);
$section->addText('Siapkan 2 browser/tab untuk demo Customer Display. Buka /kasir/transaksi di tab 1, /kasir/customer-display di tab 2. Scan produk, tunjukkan sinkronisasi real-time.');
$section->addTextBreak(1);

$section->addTitle('2. Contoh Kasus Nyata', 3);
$section->addText('Ceritakan skenario: "Misalnya Toko Kopi punya produk Kopi Susu dengan 3 ukuran. Dengan sistem varian, tidak perlu bikin 3 produk terpisah, cukup 1 produk dengan 3 varian."');
$section->addTextBreak(1);

$section->addTitle('3. Tekankan Nilai Bisnis', 3);
$section->addText('Jangan hanya bicara teknis. Tekankan manfaat untuk bisnis: "Rewards system bikin member loyal dan rajin belanja", "Customer Display meningkatkan kepercayaan pelanggan", dll.');
$section->addTextBreak(1);

$section->addTitle('4. Siap Jawab Pertanyaan Teknis Sederhana', 3);
$section->addText('Kalau ditanya database/kode, jawab singkat dan kembali ke alur bisnis. Misal: "Kami pakai Laravel framework dengan MySQL database, tapi yang penting sistemnya bisa handle transaksi real-time dengan akurat."');
$section->addTextBreak(1);

$section->addTitle('5. Highlight Integrasi Antar Fitur', 3);
$section->addText('Tunjukkan bahwa fitur-fitur saling terhubung: "Member verifikasi → dapat poin → tukar voucher → pakai di checkout online. Ini menciptakan ekosistem lengkap."');

// Save document
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('Penjelasan_Fitur_Unik_Aplikasi_Kasir.docx');

echo "✅ File DOCX berhasil dibuat: Penjelasan_Fitur_Unik_Aplikasi_Kasir.docx\n";
