<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>{{ config('app.name', 'FTPP') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('/storage/assets/img/Logo_Universitas_Papua.png') }}" rel="icon">
    <link href="{{ asset('/storage/assets/img/Logo_Universitas_Papua.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File from template -->
    <link href="{{ asset('/storage/assets/css/main.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="index-page">
    @inertia

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- Main JS File from template (commented out for now to avoid errors) -->
    <!-- <script src="{{ asset('/storage/assets/js/main.js') }}"></script> -->

    <!-- Main JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 1000,
                    easing: 'ease-in-out',
                    once: true
                });
            }

            // Initialize GLightbox
            if (typeof GLightbox !== 'undefined') {
                GLightbox({
                    selector: '.glightbox'
                });
            }

            // Initialize mobile nav toggle
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            if (mobileNavToggle) {
                mobileNavToggle.addEventListener('click', function() {
                    const navmenu = document.querySelector('#navmenu');
                    if (navmenu) {
                        navmenu.classList.toggle('mobile-nav-active');
                    }
                    this.classList.toggle('bi-list');
                    this.classList.toggle('bi-x');
                });
            }

            // Scroll effects
            function handleScroll() {
                const scrollTop = document.querySelector('.scroll-top');
                const header = document.querySelector('#header');

                if (window.scrollY > 100) {
                    if (scrollTop) scrollTop.classList.add('active');
                    if (header) header.classList.add('header-scrolled');
                } else {
                    if (scrollTop) scrollTop.classList.remove('active');
                    if (header) header.classList.remove('header-scrolled');
                }
            }

            window.addEventListener('scroll', handleScroll);

            // Scroll to top
            const scrollTopBtn = document.querySelector('.scroll-top');
            if (scrollTopBtn) {
                scrollTopBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const header = document.querySelector('#header');
                        const headerHeight = header ? header.offsetHeight : 0;
                        const targetPosition = target.offsetTop - headerHeight;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Remove preloader
            const preloader = document.querySelector('#preloader');
            if (preloader) {
                setTimeout(() => preloader.remove(), 1000);
            }
        });
    </script>
</body>

</html>
