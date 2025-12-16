<x-guest-layout>
    
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .text-gradient {
            background: linear-gradient(135deg, #198754, #20c997);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-gradient-success {
            background: linear-gradient(135deg, #198754 0%, #0f5132 100%);
        }
        .decorative-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(25, 135, 84, 0.05);
            z-index: -1;
        }
    </style>

    <div class="container py-5 position-relative overflow-hidden">
        <div class="decorative-circle" style="width: 300px; height: 300px; top: -50px; left: -50px;"></div>
        <div class="decorative-circle" style="width: 200px; height: 200px; bottom: 50px; right: -50px;"></div>

        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-10">
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill fw-bold mb-3 shadow-sm">
                    {{ __('about.mission_badge') }}
                </span>
                <h2 class="display-4 fw-bolder mb-4 text-dark">
                    {{ __('about.hero_title_1') }}<br> {{ __('about.hero_title_2') }} <span class="text-gradient">{{ __('about.hero_title_highlight') }}</span>
                </h2>
                <p class="lead text-muted lh-lg fs-5 mx-auto" style="max-width: 800px;">
                    {!! __('about.hero_desc') !!}
                </p>
            </div>
        </div>

        <div class="row text-center mb-5 gx-4 gy-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm border border-light">
                    <h3 class="display-5 fw-bold text-success mb-0">10k+</h3>
                    <p class="text-muted mb-0">{{ __('about.stat_saved') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm border border-light">
                    <h3 class="display-5 fw-bold text-success mb-0">5k+</h3>
                    <p class="text-muted mb-0">{{ __('about.stat_users') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm border border-light">
                    <h3 class="display-5 fw-bold text-success mb-0">500+</h3>
                    <p class="text-muted mb-0">{{ __('about.stat_partners') }}</p>
                </div>
            </div>
        </div>

        <div class="card border-0 rounded-5 overflow-hidden shadow mb-5">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 p-5 bg-gradient-success text-white position-relative overflow-hidden">
                    <div class="position-relative z-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-quote mb-4 opacity-50" viewBox="0 0 16 16">
                            <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388c0-.351.021-.703.062-1.054.062-.372.166-.703.282-1.011.127-.33.294-.607.501-.831.226-.245.492-.41.798-.55l.771-.302.247.737-.771.302c-.173.078-.32.193-.442.345-.12.148-.204.32-.253.518-.049.192-.073.418-.084.675-.01.272.012.552.062.839H14a1 1 0 0 1 1 1v3.5a1 1 0 0 1-1 1h-2z"/>
                        </svg>
                        <h3 class="fw-bold mb-4">{{ __('about.quote_title') }}</h3>
                        <p class="fs-5 lh-lg opacity-90">
                            {{ __('about.quote_text') }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 p-5 bg-white">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16"><path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/></svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ __('about.feat_waste_title') }}</h5>
                            <p class="text-muted small mb-0">{{ __('about.feat_waste_desc') }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/></svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ __('about.feat_help_title') }}</h5>
                            <p class="text-muted small mb-0">{{ __('about.feat_help_desc') }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-globe-asia-australia" viewBox="0 0 16 16"><path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0ZM2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484-.08.08-.662.08-.85.038-.545-.123-1.284-.242-1.466-.274-.409-.071-.904-.094-1.156-.109-.133-.008-.344.025-.566.113l-.004-.002-.15.11a.51.51 0 0 0-.25.344c-.033.196.06.398.156.55.195.31.545.626 1.09.835.403.155.76.242 1.01.278.432.063.953.078 1.432.078.293 0 .584-.009.873-.027a18.3 18.3 0 0 1 1.764-.176c.49-.033.916-.145 1.25-.264.444-.158.746-.424.95-.732.18-.269.243-.59.27-.92.01-.13.003-.274-.019-.426a1.9 1.9 0 0 0-.083-.342c-.157-.463-.615-.815-1.15-.815-.558 0-1.045.385-1.196.877a.64.64 0 0 1-.037.098.375.375 0 0 1-.06.096l-.004.004-.005.002-.005.002-.016.002-.036.003-.09.006-.217.01-.527.01c-.134 0-.306-.002-.505-.008-.4-.012-.897-.038-1.393-.112-.99-.148-1.78-.445-2.07-.63-.377-.24-.633-.68-.588-1.125.021-.21.087-.41.19-.594.137-.244.356-.445.633-.58.332-.162.774-.246 1.258-.246.339 0 .7.042 1.07.126.37.085.748.217 1.13.395.765.356 1.57.731 2.396.731.395 0 .783-.086 1.154-.257.653-.3 1.149-.89 1.349-1.602.046-.164.08-.34.103-.524h-.005l-.034-.002-.116-.01c-.417-.035-.95-.08-1.442-.239a3.86 3.86 0 0 0-1.22-.196c-.463 0-.916.095-1.353.284-.253.11-.5.257-.74.43-.225.163-.45.352-.69.566-.48.43-.996.885-1.636 1.185-.712.333-1.458.508-2.193.508-.426 0-.846-.06-1.255-.178-.06-.017-.118-.035-.176-.054Zm11.02 5.06c.063.452.338.845.719 1.026.38.181.828.165 1.218.005.39-.16.696-.48.86-.884.164-.403.167-.852.01-1.267a2.53 2.53 0 0 0-.582-.937c-.365-.365-.845-.56-1.332-.56-.487 0-.967.195-1.332.56a2.53 2.53 0 0 0-.56 1.332v.725ZM1.192 9.53a9.96 9.96 0 0 1-.365-1.205c-.062-.267-.098-.543-.108-.824L.716 7.5h.003l.056.002.164.01c.422.025.968.057 1.546.057.402 0 .798-.016 1.19-.047.784-.062 1.54-.215 2.22-.45.68-.236 1.285-.573 1.767-1.02.482-.448.847-1.01 1.045-1.693.198-.684.186-1.433-.035-2.128-.222-.694-.65-1.285-1.22-1.706-.285-.21-.6-.38-1.004-.492-.404-.112-.863-.16-1.403-.135-.54.025-1.12.115-1.708.268-.588.153-1.18.368-1.745.642C.564 1.127.275 1.52.122 1.96c-.153.44-.194.916-.12 1.385.074.47.25.91.514 1.293.265.384.607.712 1.005.972.4.26 1.07.575 1.93.856.86.28 1.92.54 3.033.725 1.114.186 2.26.31 3.284.376 1.023.067 1.933.076 2.658.028.724-.048 1.258-.153 1.603-.314.345-.16.502-.38.56-.66.03-.138.016-.296-.04-.446a.87.87 0 0 0-.17-.26c-.347-.347-.827-.542-1.314-.542-.487 0-.967.195-1.314.542a1.86 1.86 0 0 0-.41.696c-.13.39-.148.808-.052 1.207.096.4.316.76.635 1.037.32.277.72.46 1.152.526.433.066.89-.01 1.306-.217.416-.207.77-.552 1.012-1.003.242-.45.348-.974.305-1.493-.043-.52-.228-1.01-.527-1.428-.3-.418-.707-.75-1.185-.968-.478-.218-1.02-.3-1.56-.236-.54.064-1.05.28-1.46.617-.41.337-.714.79-.87 1.31-.157.52-.143 1.076.04 1.595.183.52.518.96.945 1.296.427.336.938.544 1.48.604.542.06 1.106-.025 1.625-.246.52-.22.96-.58 1.275-1.043.315-.463.483-1.01.486-1.57.003-.56-.16-1.11-.47-1.576-.31-.466-.745-.83-1.26-1.054-.515-.224-1.08-.293-1.636-.203Z"/></svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ __('about.feat_env_title') }}</h5>
                            <p class="text-muted small mb-0">{{ __('about.feat_env_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 text-center mb-2">
                <h3 class="fw-bold">{{ __('about.pillars_title') }}</h3>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift p-4 text-center rounded-4">
                    <div class="card-body">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16"><path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/></svg>
                        </div>
                        <h5 class="fw-bold mb-3">{{ __('about.card_reduce_title') }}</h5>
                        <p class="text-muted">{{ __('about.card_reduce_desc') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift p-4 text-center rounded-4">
                    <div class="card-body">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16"><path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.2.2 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 10c-1.119 0-1.88.251-2.458.544a3.372 3.372 0 0 0-1.379.825zm1.88 1a2.055 2.055 0 0 1 1.956 1.278c.032.09.073.177.123.262H1.936c.355-.718.995-1.54 1.864-1.54Z"/></svg>
                        </div>
                        <h5 class="fw-bold mb-3">{{ __('about.card_social_title') }}</h5>
                        <p class="text-muted">{{ __('about.card_social_desc') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift p-4 text-center rounded-4">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-tree" viewBox="0 0 16 16"><path d="M8.416.223a.5.5 0 0 0-.832 0l-3 4.5A.5.5 0 0 0 5 5.5h.098L3.076 8.735A.5.5 0 0 0 3.5 9.5h.191l-1.638 3.276a.5.5 0 0 0 .447.724H7V16h2v-2.5h4.5a.5.5 0 0 0 .447-.724L12.31 9.5h.191a.5.5 0 0 0 .424-.765L10.902 5.5H11a.5.5 0 0 0 .416-.777l-3-4.5zM13.633 12.5H2.367l1.326-2.653A.5.5 0 0 0 3.5 9.5h-.5l2-3.5h-.5a.5.5 0 0 0-.434-.75L8 1.31l3.934 3.94a.5.5 0 0 0-.434.75h-.5l2 3.5h-.5a.5.5 0 0 0-.193.347l1.326 2.653z"/></svg>
                        </div>
                        <h5 class="fw-bold mb-3">{{ __('about.card_sustain_title') }}</h5>
                        <p class="text-muted">{{ __('about.card_sustain_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-guest-layout>