<?php

return [
    'dashboard' => 'Dasbor Donor',
    'greeting' => 'Halo, :name! 👋',
    'sub_greeting' => 'Yuk bantu kurangi food waste hari ini!',
    'btn_create' => '+ Donasi Makanan',
    'stat_active' => 'Donasi Aktif',
    'stat_active_desc' => 'Siap diambil',
    'stat_req' => 'Permintaan Masuk',
    'stat_req_desc' => 'Butuh respons',
    'stat_claim' => 'Klaim Selesai',
    'stat_claim_desc' => 'Telah disalurkan',
    'stat_complete' => 'Donasi Selesai',
    'stat_complete_desc' => 'Telah disalurkan',
    
    // Tabs
    'tab_active' => 'Sedang Aktif',
    'tab_req' => 'Permintaan',
    'tab_process' => 'Dalam Proses',
    'tab_history' => 'Riwayat Selesai',
    
    // Active Tab
    'empty_active' => 'Belum ada donasi aktif. Yuk donasi sekarang!',
    'th_food' => 'Nama Makanan',
    'th_qty' => 'Jumlah Tersedia',
    'th_time' => 'Waktu Pengambilan',
    'th_exp' => 'Tanggal Kedaluwarsa',
    'th_action' => 'Aksi',
    'status_expired' => 'Kedaluwarsa',
    'status_expired_badge' => 'Expired',
    
    // Modal Delete
    'modal_del_title' => 'Hapus Makanan',
    'modal_del_body' => 'Apakah Anda yakin ingin menghapus <strong>:name</strong>? Data yang dihapus tidak dapat dikembalikan.',
    'btn_cancel' => 'Batal',
    'btn_delete' => 'Ya, Hapus',
    
    // Requests Tab
    'empty_req' => 'Belum ada permintaan masuk saat ini.',
    'th_receiver' => 'Penerima',
    'th_req_food' => 'Makanan Diminta',
    'th_req_qty' => 'Jumlah Diminta',
    'th_msg' => 'Pesan',
    'badge_left' => 'Sisa: :count',
    'btn_accept' => 'Terima',
    'btn_reject' => 'Tolak',
    
    // Modal Reject
    'modal_rej_title' => 'Tolak Permintaan',
    'modal_rej_body' => 'Anda yakin menolak permintaan dari <strong class="text-dark">:name</strong>?',
    'label_reason' => 'Pilih Alasan Penolakan:',
    'reason_default' => '-- Pilih Alasan --',
    'reason_1' => 'Sudah diambil orang lain',
    'reason_2' => 'Jarak lokasi terlalu jauh',
    'reason_3' => 'Waktu pengambilan tidak cocok',
    'reason_4' => 'Stok makanan habis',
    'reason_5' => 'Lainnya',
    'btn_submit_reject' => 'Tolak Permintaan',
    
    // Process Tab
    'empty_process' => 'Tidak ada donasi yang sedang diproses.',
    'alert_process' => 'Item di sini sedang menunggu diambil oleh penerima. Anda tidak bisa mengedit data, tapi bisa membatalkan jika darurat.',
    'th_qty_simple' => 'Jumlah',
    'btn_confirm' => 'Konfirmasi',
    'btn_cancel_process' => 'Batalkan',
    
    // Modal Verify
    'modal_ver_title' => 'Konfirmasi Donasi Selesai',
    'modal_ver_body' => 'Masukkan kode 4 digit yang ditunjukkan oleh <strong>:name</strong>:',
    'btn_verify' => 'Konfirmasi',
    
    // Modal Cancel Process
    'modal_cancel_title' => 'Batalkan Proses',
    'modal_cancel_body' => 'Apakah Anda yakin ingin membatalkan proses donasi untuk <strong>:name</strong>?',
    'btn_yes_cancel' => 'Ya, Batalkan',
    
    // History Tab
    'subtab_claim' => 'Riwayat Klaim',
    'subtab_item' => 'Riwayat Donasi',
    'empty_hist_claim' => 'Belum ada riwayat transaksi penerima.',
    'th_date_done' => 'Tanggal Selesai',
    'th_status' => 'Status',
    'status_completed' => 'Selesai',
    'status_rejected' => 'Ditolak',
    'status_cancelled' => 'Batal',
    'empty_hist_item' => 'Belum ada riwayat stok makanan.',
    'th_final_status' => 'Status Akhir',
    'status_donated' => 'Didonasikan',
    
    // Create Page
    'create_title' => 'Buat Donasi Baru',
    'create_subtitle' => 'Isi detail makanan yang ingin Anda bagikan.',
    'form_title' => 'Form Informasi Makanan',
    'label_photo' => 'Foto Makanan',
    'label_click_upload' => 'Klik untuk upload foto',
    'label_name' => 'Nama Makanan',
    'ph_name' => 'Contoh: Roti Manis Isi Coklat',
    'label_category' => 'Kategori',
    'select_default' => '-- Pilih --',
    'label_qty' => 'Jumlah Porsi',
    'unit_qty' => 'Porsi',
    'title_pickup' => 'Detail Pengambilan',
    'label_exp' => 'Kedaluwarsa',
    'label_time' => 'Waktu Pickup',
    'ph_time' => 'Cth: 15.00 - 18.00',
    'label_loc' => 'Lokasi Pickup',
    'ph_loc' => 'Cari di peta atau ketik alamat...',
    'btn_loc_me' => 'Lokasi Saya',
    'help_map' => 'Marker otomatis mengikuti lokasi Anda. Geser marker untuk menyesuaikan.',
    'label_desc' => 'Deskripsi Tambahan',
    'label_desc_opt' => '(Opsional)',
    'ph_desc' => 'Jelaskan kondisi makanan, halal/non-halal, atau instruksi khusus...',
    'btn_back' => 'Kembali',
    'btn_upload' => 'Unggah Donasi',
    
    // JS Messages
    'js_searching' => 'Sedang mencari nama jalan...',
    'js_detecting' => 'Mendeteksi lokasi GPS...',

    // Profile Page
    'verified_donor' => 'Donor Terverifikasi',
    'label_email' => 'Email',
    'label_phone' => 'No. Telepon',
    'label_address' => 'Alamat Utama',
    'join_since' => 'Bergabung Sejak',
    'btn_edit_profile' => 'Edit Profil',
    'recent_activity' => 'Aktivitas Terakhir',
    'btn_view_all' => 'Lihat Semua',
    'activity_empty' => 'Belum ada aktivitas.',
    'status_active' => 'Aktif',
    'status_process' => 'Proses',
    
    // Profile Edit Page
    'edit_title' => 'Edit Profil',
    'edit_subtitle' => 'Perbarui informasi pribadi dan alamat Anda.',
    'form_personal_title' => 'Form Data Diri',
    'account_info' => 'Informasi Akun',
    'label_fullname' => 'Nama Lengkap',
    'label_phone_wa' => 'No. Telepon / WhatsApp',
    'title_main_loc' => 'Lokasi Utama',
    'label_full_addr' => 'Alamat Lengkap',
    'ph_addr_manual' => 'Cari di peta atau ketik manual...',
    'help_drag_map' => 'Geser marker merah di peta untuk memperbarui alamat secara otomatis.',
    'btn_save_changes' => 'Simpan Perubahan',
];