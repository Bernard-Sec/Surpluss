<x-guest-layout>

    <style>
        html, body {
            margin: 0; padding: 0; width: 100%; height: 100%;
            background-color: transparent !important; 
            /* font-family: 'Inter', sans-serif; */
        }
        div[class*="min-h-screen"], div[class*="bg-gray-100"] {
            background-color: transparent !important;
        }

        .aurora-fixed-bg {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: -50;
            background: linear-gradient(-45deg, #e6fcf5, #c3fae8, #ffffff, #d3f9d8);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, #0ca678 0%, #087f5b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800; letter-spacing: -0.5px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
            border-radius: 24px;
        }
        
        .mockup-container { position: relative; height: 500px; perspective: 1000px; }
        .float-item {
            position: absolute; transition: all 0.5s ease;
            animation: floating 6s ease-in-out infinite;
            cursor: default;
        }
        .float-item:hover { transform: scale(1.05) !important; z-index: 100; background: white; }
        @keyframes floating {
            0%, 100% { transform: translateY(0) rotate(var(--r, 0deg)); }
            50% { transform: translateY(-15px) rotate(var(--r, 0deg)); }
        }
        .icon-box {
            width: 50px; height: 50px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.5rem; flex-shrink: 0;
        }

        .impact-strip {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .impact-strip:hover { transform: translateY(-5px); }
        .stat-number { font-size: 2.5rem; font-weight: 800; color: #087f5b; line-height: 1; }
        .stat-label { font-size: 0.9rem; color: #868e96; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

        .bento-box {
            height: 100%; border-radius: 30px; padding: 40px;
            transition: all 0.4s ease; position: relative; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.5);
        }
        .bento-box:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(12, 166, 120, 0.15); }
        
        .logo-scroller { overflow: hidden; white-space: nowrap; position: relative; }
        .logo-scroller::before, .logo-scroller::after {
            content: ""; position: absolute; top: 0; width: 100px; height: 100%; z-index: 2;
        }
        .logo-scroller::before { left: 0; background: linear-gradient(to right, rgba(255,255,255,0) 0%, transparent 100%); }
        .logo-scroller::after { right: 0; background: linear-gradient(to left, rgba(255,255,255,0) 0%, transparent 100%); }
        .partner-logo {
            display: inline-block; font-weight: 700; color: #adb5bd; font-size: 1.5rem; margin: 0 30px;
            opacity: 0.6; transition: all 0.3s; cursor: pointer;
        }
        .partner-logo:hover { color: #0ca678; opacity: 1; transform: scale(1.1); }

        .btn-primary-custom {
            background: #0ca678; border: none; padding: 12px 35px; border-radius: 50px;
            color: white; font-weight: 700; font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(12, 166, 120, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover { background: #099268; transform: translateY(-2px); box-shadow: 0 15px 30px rgba(12, 166, 120, 0.4); }
        
        .btn-outline-custom {
            background: white; border: 2px solid rgba(12, 166, 120, 0.1); padding: 12px 35px; border-radius: 50px;
            color: #0ca678; font-weight: 700; font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover { border-color: #0ca678; color: #087f5b; background: #f8f9fa; }

        .cat-card {
            background: white;
            border-radius: 24px;     
            padding: 30px 20px;       
            text-align: center;       
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;            
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01);
        }

        .cat-card:hover {
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px -5px rgba(16, 185, 129, 0.15);
            border-color: #10b981;      
        }

        .cat-card:hover .cat-icon {
            background: #10b981;  
            color: white;           
            transform: scale(1.1) rotate(-5deg);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .cat-card h5 {
            color: #1e293b;           
            letter-spacing: -0.5px;
        }
    </style>

    <div class="aurora-fixed-bg"></div>

    <div class="position-relative w-100" style="overflow-x: hidden;">
        
        <div class="container py-5">
            
            <div class="row align-items-center mb-5 pb-5" style="min-height: 85vh;">
                
                <div class="col-lg-6 z-2">
                    <div class="pe-lg-5">
                        <div class="d-inline-flex align-items-center bg-white border border-success border-opacity-10 rounded-pill px-3 py-2 mb-4 shadow-sm">
                            <span class="badge bg-success rounded-pill me-2">BARU</span>
                            <span class="text-success fw-bold small ls-1" style="font-size: 0.75rem;">REVOLUSI PANGAN INDONESIA</span>
                        </div>

                        <h1 class="display-3 fw-bold mb-4 text-dark lh-sm">
                            Selamatkan Makanan, <br>
                            <span class="text-gradient-primary">Selamatkan Bumi.</span>
                        </h1>
                        
                        <p class="lead text-secondary mb-5 lh-lg">
                            Bergabunglah dengan gerakan <strong>#ZeroFoodWaste</strong>. Beli makanan berlebih dari restoran favoritmu dengan harga hemat, atau donasikan surplusmu kepada yang membutuhkan.
                        </p>

                        <div class="d-flex flex-wrap gap-3 mb-5">
                            <a href="{{ route('register') }}" class="btn-primary-custom text-decoration-none">
                                Gabung Sekarang
                            </a>
                            <a href="{{ route('how') }}" class="btn-outline-custom text-decoration-none">
                                <i class="bi bi-play-circle me-2"></i> Cara Kerja
                            </a>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex">
                                <div class="bg-secondary rounded-circle border border-2 border-white" style="width:35px; height:35px; margin-right:-10px; background-image: url('#'); background-size:cover;"></div>
                                <div class="bg-secondary rounded-circle border border-2 border-white" style="width:35px; height:35px; margin-right:-10px; background-image: url('#'); background-size:cover;"></div>
                                <div class="bg-secondary rounded-circle border border-2 border-white" style="width:35px; height:35px; margin-right:-10px; background-image: url('#'); background-size:cover;"></div>
                                <div class="bg-success rounded-circle border border-2 border-white d-flex align-items-center justify-content-center text-white small fw-bold" style="width:35px; height:35px; font-size: 0.7rem;">+2k</div>
                            </div>
                            <span class="text-muted small fw-semibold">Pahlawan Pangan Bergabung Hari Ini</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block">
                    <div class="mockup-container">
                        <div class="position-absolute bg-success rounded-circle opacity-10" 
                             style="width: 500px; height: 500px; top: 5%; right: 5%; filter: blur(80px);"></div>

                        <div class="glass-card float-item" style="top: 10%; right: 10%; width: 280px; --r: -5deg; z-index: 2;">
                            <div class="d-flex align-items-center p-3">
                                <div class="icon-box bg-success shadow-sm me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bag-check" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Pesanan Diambil!</div>
                                    <div class="small text-muted">5 Paket Bakery Hemat</div>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card float-item" style="top: 40%; right: 0%; width: 300px; --r: 5deg; z-index: 3; animation-delay: 1s;">
                            <div class="d-flex align-items-center p-3">
                                <div class="icon-box bg-warning shadow-sm me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Martabak Spesial</div>
                                    <div class="d-flex align-items-center mt-1">
                                        <span class="badge bg-danger bg-opacity-10 text-danger me-2">Diskon 50%</span>
                                        <small class="text-muted fw-bold">Rp 25.000</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card float-item" style="top: 70%; right: 15%; width: 260px; --r: -3deg; z-index: 4; animation-delay: 2s;">
                            <div class="d-flex align-items-center p-3">
                                <div class="icon-box bg-primary shadow-sm me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Donasi Diterima</div>
                                    <div class="small text-muted">Yayasan Peduli Kasih</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-12">
                    <div class="impact-strip d-flex flex-wrap justify-content-around align-items-center text-center">
                        <div class="p-3">
                            <div class="stat-number mb-2">15 Ton+</div>
                            <div class="stat-label">Makanan Diselamatkan</div>
                        </div>
                        <div class="d-none d-md-block vr opacity-25" style="height: 50px;"></div>
                        <div class="p-3">
                            <div class="stat-number mb-2">Rp 5 M+</div>
                            <div class="stat-label">Penghematan Pengguna</div>
                        </div>
                        <div class="d-none d-md-block vr opacity-25" style="height: 50px;"></div>
                        <div class="p-3">
                            <div class="stat-number mb-2">25 Ton</div>
                            <div class="stat-label">CO2 Dicegah</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5 py-4">
                <div class="col-12 text-center">
                    <p class="text-uppercase text-muted fw-bold small ls-2 mb-4">Dipercaya oleh Mitra & Komunitas</p>
                    <div class="logo-scroller">
                        <span class="partner-logo"><i class="bi bi-cup-hot-fill me-2"></i>KopiKenangan</span>
                        <span class="partner-logo"><i class="bi bi-shop me-2"></i>HollandBakery</span>
                        <span class="partner-logo"><i class="bi bi-basket2-fill me-2"></i>GrandLucky</span>
                        <span class="partner-logo"><i class="bi bi-egg-fried me-2"></i>RestoSederhana</span>
                        <span class="partner-logo"><i class="bi bi-cup-straw me-2"></i>JanjiJiwa</span>
                    </div>
                </div>
            </div>

            <div id="cara-kerja" class="row g-4 mb-5">
                
                <div class="col-lg-7">
                    <div class="bento-box glass-card bg-white">
                        <div class="position-absolute bg-success bg-opacity-10 rounded-circle" style="width: 200px; height: 200px; top: -50px; right: -50px;"></div>
                        
                        <div class="position-relative z-1">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-box bg-success rounded-circle me-3 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-tree-fill" viewBox="0 0 16 16"><path d="M8.416.223a.5.5 0 0 0-.832 0l-3 4.5A.5.5 0 0 0 5 5.5h.098L3.076 8.735A.5.5 0 0 0 3.5 9.5h.191l-1.638 3.276a.5.5 0 0 0 .447.724H7V16h2v-2.5h4.5a.5.5 0 0 0 .447-.724L12.31 9.5h.191a.5.5 0 0 0 .424-.765L10.902 5.5H11a.5.5 0 0 0 .416-.777l-3-4.5z"/></svg>
                                </div>
                                <h3 class="fw-bold text-dark m-0">Kenapa Harus Surplus?</h3>
                            </div>
                            <p class="text-secondary fs-5 mb-0 lh-base">
                                Setiap makanan yang terbuang menghasilkan gas metana yang berbahaya. Dengan Surplus, Anda tidak hanya <strong>hemat pengeluaran</strong>, tapi juga menjadi pahlawan lingkungan.
                                <br><br>
                                <span class="d-flex align-items-center gap-2">
                                    <i class="bi bi-check-circle-fill text-success"></i> Dukung SDG 12
                                    <i class="bi bi-check-circle-fill text-success ms-3"></i> Kurangi Limbah
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="bento-box border-0 d-flex flex-column justify-content-center text-white" 
                         style="background: linear-gradient(135deg, #0ca678, #087f5b);">
                        
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" 
                             style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
                        
                        <div class="position-relative z-1 text-center text-lg-start">
                            <h3 class="fw-bold mb-3">Siap Membuat Perubahan?</h3>
                            <p class="opacity-90 mb-4 lh-base fs-5">
                                Jangan biarkan makanan enak terbuang sia-sia. Jadilah bagian dari solusi sekarang juga.
                            </p>
                            
                            <a href="{{ route('register') }}" class="btn bg-white text-success fw-bold rounded-pill px-4 py-3 w-100 shadow-sm" style="font-size: 1.1rem; transition: transform 0.2s;">
                                Daftar Gratis <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 pb-5 mb-5">
                <div class="col-12 text-center mb-4">
                    <span class="text-success fw-bold ls-1 text-uppercase small">Surplus</span>
                    <h2 class="fw-bold mt-2">Apa yang Bisa Kamu Selamatkan?</h2>
                </div>

                <div class="col-md-3 col-6">
                    <div class="cat-card">
                        <div class="cat-icon"><i class="bi bi-cup-hot-fill"></i></div>
                        <h5 class="fw-bold mb-2">Roti & Kue</h5>
                        <p class="text-muted small mb-0">Croissant, donat, dan roti segar harian.</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="cat-card">
                        <div class="cat-icon"><i class="bi bi-box-seam-fill"></i></div>
                        <h5 class="fw-bold mb-2">Nasi Box</h5>
                        <p class="text-muted small mb-0">Menu makan siang & malam yang lezat.</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="cat-card">
                        <div class="cat-icon"><i class="bi bi-basket3-fill"></i></div>
                        <h5 class="fw-bold mb-2">Bahan Segar</h5>
                        <p class="text-muted small mb-0">Sayuran, buah, dan bahan masak lainnya.</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="cat-card">
                        <div class="cat-icon"><i class="bi bi-cookie"></i></div>
                        <h5 class="fw-bold mb-2">Cemilan</h5>
                        <p class="text-muted small mb-0">Jajanan pasar dan snack penutup hari.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-guest-layout>