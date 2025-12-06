<div class="d-flex align-items-center gap-3">
    
    <span class="lang-label {{ app()->getLocale() == 'id' ? 'label-active' : 'label-inactive' }}">
        ID
    </span>

    <label class="neu-switch">
        <input type="checkbox" id="language-toggle" {{ app()->getLocale() == 'en' ? 'checked' : '' }}>
        <span class="slider"></span>
    </label>

    <span class="lang-label {{ app()->getLocale() == 'en' ? 'label-active' : 'label-inactive' }}">
        EN
    </span>

</div>

<style>
    /* -- CSS Label Teks -- */
    .lang-label {
        font-weight: 800;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    /* Kalau Aktif: Warna Hijau & Jelas */
    .label-active {
        color: #198754; 
        opacity: 1;
        transform: scale(1.1); /* Sedikit membesar biar keren */
    }

    /* Kalau Tidak Aktif: Warna Abu & Samar */
    .label-inactive {
        color: #adb5bd;
        opacity: 0.5; /* Transparan biar gak ganggu mata */
    }

    /* -- CSS Switch Neumorphism -- */
    .neu-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
        margin-bottom: 0; /* Fix kadang ada margin bawaan browser */
    }

    .neu-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #f0f0f3; 
        transition: .4s;
        border-radius: 34px;
        /* Shadow Dalam (Cekung) */
        box-shadow: inset 3px 3px 5px #cbced1, 
                    inset -3px -3px 5px #ffffff;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: #f0f0f3;
        transition: .4s;
        border-radius: 50%;
        /* Shadow Luar (Timbul) */
        box-shadow: 2px 2px 4px #cbced1, 
                    -2px -2px 4px #ffffff;
    }

    input:checked + .slider:before {
        transform: translateX(22px);
        background-color: #198754; /* Hijau saat aktif */
        /* Shadow Dalam untuk efek tombol masuk */
        box-shadow: inset 2px 2px 4px #0f5132, 
                    inset -2px -2px 4px #25c97b;
    }
</style>

<script>
    document.getElementById('language-toggle').addEventListener('change', function() {
        let targetLang = this.checked ? 'en' : 'id';
        
        // Panggil Route
        let url = "{{ route('lang.switch', ':lang') }}";
        url = url.replace(':lang', targetLang);

        window.location.href = url;
    });

    // Fitur Tambahan: Bisa klik teks "ID" atau "EN" langsung
    document.querySelectorAll('.lang-label').forEach(label => {
        label.addEventListener('click', function() {
            // Cek teksnya, kalau ID redirect ke ID, kalau EN redirect ke EN
            let text = this.innerText.trim();
            let lang = (text === 'ID') ? 'id' : 'en';
            
            // Cek biar gak reload kalau klik bahasa yang sedang aktif
            let currentLang = "{{ app()->getLocale() }}";
            if(lang !== currentLang) {
                let url = "{{ route('lang.switch', ':lang') }}";
                url = url.replace(':lang', lang);
                window.location.href = url;
            }
        });
    });
</script>