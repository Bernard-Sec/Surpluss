<x-guest-layout>

    <style>
        .step-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
            z-index: 2; position: relative; background: white;
        }
        .step-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(25, 135, 84, 0.15) !important;
            border-color: #198754;
        }
        .icon-box {
            width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;
            border-radius: 50%; margin: 0 auto 20px; transition: all 0.3s ease;
        }
        .step-card:hover .icon-box {
            background-color: #198754 !important; color: white !important; transform: scale(1.1);
        }
        .arrow-connector {
            position: absolute; top: 30%; right: -25px; font-size: 2rem; color: #dee2e6; z-index: 1;
        }
        .text-gradient {
            background: linear-gradient(45deg, #198754, #20c997);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .pro-tip {
            font-size: 0.85rem; background-color: #f8f9fa; border-left: 3px solid #ffc107;
            padding: 8px 12px; margin-top: 15px; text-align: left; border-radius: 0 8px 8px 0;
        }

        .value-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            border: 1px solid rgba(25, 135, 84, 0.1);
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }
        .value-card:hover {
            transform: translateY(-5px);
            background: white;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            border-color: #198754;
        }

        .value-deco {
            position: absolute; top: -20px; right: -20px;
            width: 100px; height: 100px;
            background: radial-gradient(circle, rgba(25,135,84,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
    </style>

    <div class="container py-5">
        
        <div class="text-center mb-5">
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold mb-3">
                Proses Simpel
            </span>
            <h2 class="display-5 fw-bold mb-2">Cara Kerja <span class="text-gradient">Surplus</span></h2>
            <p class="text-muted fs-5 mb-4" style="max-width: 600px; margin: 0 auto;">
                Tiga langkah mudah untuk menyelamatkan makanan dan dompetmu sekaligus.
            </p>
            
            <div class="d-inline-flex gap-4 p-3 bg-white rounded-pill shadow-sm border">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-check text-success fs-5"></i>
                    <span class="fw-bold text-dark small">Zero Waste</span>
                </div>
                <div class="vr opacity-25"></div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-lightning-charge-fill text-warning fs-5"></i>
                    <span class="fw-bold text-dark small">Zero Hungry</span>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center position-relative mb-5 pb-4">
            
            <div class="col-md-4 position-relative">
                <div class="card step-card h-100 bg-white shadow-sm rounded-4 p-4 text-center">
                    <div class="card-body">
                        <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-success border border-4 border-white shadow-sm" style="font-size: 1rem; width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">1</span>
                        
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zM9 9.886a.5.5 0 0 1-.5-.5 3.32 3.32 0 0 0-.693-2.023.5.5 0 0 1 .863-.5c.618.995.73 2.148.23 3.023z"/>
                            </svg>
                        </div>

                        <h4 class="fw-bold mb-3">Donor Upload</h4>
                        <p class="text-muted mb-3">
                            Mitra seperti toko, restoran, atau katering mengunggah makanan berlebih yang masih layak konsumsi ke platform Surplus.
                        </p>
                        <div class="pro-tip">
                            <strong>💡 Tips:</strong> Pastikan makanan masih segar dan belum kedaluwarsa.
                        </div>
                    </div>
                </div>
                <div class="arrow-connector d-none d-md-block">
                    <i class="bi bi-chevron-right"></i> 
                </div>
            </div>

            <div class="col-md-4 position-relative">
                <div class="card step-card h-100 bg-white shadow-sm rounded-4 p-4 text-center">
                    <div class="card-body">
                        <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-success border border-4 border-white shadow-sm" style="font-size: 1rem; width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">2</span>

                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                            </svg>
                        </div>

                        <h4 class="fw-bold mb-3">Receiver Menerima</h4>
                        <p class="text-muted mb-3">
                            Pengguna melihat daftar makanan tersedia di sekitar mereka, lalu memilih dan melakukan pemesanan sesuai kebutuhan.
                        </p>
                        <div class="pro-tip">
                            <strong>💡 Tips:</strong> Perhatikan lokasi dan batas waktu pengambilan.
                        </div>
                    </div>
                </div>
                <div class="arrow-connector d-none d-md-block">
                    <i class="bi bi-chevron-right"></i> 
                </div>
            </div>

            <div class="col-md-4 position-relative">
                <div class="card step-card h-100 bg-white shadow-sm rounded-4 p-4 text-center">
                    <div class="card-body">
                        <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-success border border-4 border-white shadow-sm" style="font-size: 1rem; width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">3</span>

                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bag-heart-fill" viewBox="0 0 16 16">
                                <path d="M11.5 4v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5ZM8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1Zm0 6.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
                            </svg>
                        </div>

                        <h4 class="fw-bold mb-3">Ambil Makanan</h4>
                        <p class="text-muted mb-3">
                            Datang ke lokasi mitra sesuai waktu yang telah disepakati untuk mengambil makanan yang telah dipesan.
                        </p>
                        <div class="pro-tip">
                            <strong>💡 Tips:</strong> Tunjukkan bukti pemesanan kepada mitra.
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold">Manfaat Bergabung di Ekosistem Ini</h3>
                <p class="text-muted">Satu aplikasi, sejuta dampak positif.</p>
            </div>

            <div class="col-md-4 mb-3">
                <div class="value-card text-start">
                    <div class="value-deco"></div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-inline-flex p-3 mb-3">
                        <i class="bi bi-wallet2 fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Tanpa Biaya</h5>
                    <p class="text-secondary mb-0">Surplus dapat digunakan sepenuhnya gratis oleh mitra dan penerima tanpa biaya layanan, komisi, atau potongan apa pun.</p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="value-card text-start">
                    <div class="value-deco"></div>
                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-inline-flex p-3 mb-3">
                        <i class="bi bi-tree-fill fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Selamatkan Bumi</h5>
                    <p class="text-secondary mb-0">Setiap kg makanan yang kamu selamatkan mencegah 2.5kg emisi CO2 yang merusak lapisan ozon.</p>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="value-card text-start">
                    <div class="value-deco"></div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-inline-flex p-3 mb-3">
                        <i class="bi bi-shop fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Proses Transparan</h5>
                    <p class="text-secondary mb-0">Setiap tahap distribusi dapat dipantau secara jelas oleh mitra dan penerima.</p>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-3 text-center">
            <div class="col-12">
                <div class="bg-success bg-opacity-10 p-5 rounded-5 d-inline-block w-100 border border-success border-opacity-10" style="max-width: 900px;">
                    <h2 class="fw-bold text-success mb-3 display-6">Siap Menjadi Pahlawan Pangan?</h2>
                    <p class="fs-5 text-dark opacity-75 mb-4">
                        Bergabunglah dengan ribuan pengguna lain yang telah membuat perubahan nyata.
                    </p>
                    <a href="/register" class="btn btn-success btn-lg px-5 rounded-pill fw-bold shadow hover-scale">
                        Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

</x-guest-layout>