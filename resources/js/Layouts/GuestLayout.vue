<script setup>
// Simple guest layout without complex dependencies
</script>

<template>
    <div class="login-page">
        <slot />
    </div>
</template>
<!-- <style>
.login-page {
    margin: 0;
    padding: 0;
    font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
        sans-serif;
    background: #f8f9fa;
    min-height: 100vh;
}

.login-page * {
    box-sizing: border-box;
}

.login-page .container-fluid {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

.login-page .container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

.login-page .row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}

.login-page .col-md-6,
.login-page .col-lg-5,
.login-page .col-lg-7,
.login-page .col-sm-12 {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}

.login-page .d-flex {
    display: flex !important;
}

.login-page .align-items-center {
    align-items: center !important;
}

.login-page .justify-content-between {
    justify-content: space-between !important;
}

.login-page .justify-content-center {
    justify-content: center !important;
}

.login-page .flex-wrap {
    flex-wrap: wrap !important;
}

.login-page .text-center {
    text-align: center !important;
}

.login-page .text-primary {
    color: #007bff !important;
}

.login-page .bg-white {
    background-color: #fff !important;
}

.login-page .mb-0 {
    margin-bottom: 0 !important;
}

.login-page .mb-4 {
    margin-bottom: 1.5rem !important;
}

.login-page .w-100 {
    width: 100% !important;
}

.login-page .btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    background-color: transparent;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
        border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    text-decoration: none;
}

.login-page .btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.login-page .btn-primary:hover {
    color: #fff;
    background-color: #0069d9;
    border-color: #0062cc;
}

.login-page .btn-outline-primary {
    color: #007bff;
    border-color: #007bff;
}

.login-page .btn-outline-primary:hover {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.login-page .btn-lg {
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: 0.3rem;
}

.login-page .form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.login-page .form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.login-page .form-control-lg {
    height: calc(1.5em + 1rem + 2px);
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: 0.3rem;
}

.login-page .alert {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

.login-page .alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

@media (min-width: 768px) {
    .login-page .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .login-page .d-md-block {
        display: block !important;
    }
}

@media (min-width: 992px) {
    .login-page .col-lg-5 {
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }

    .login-page .col-lg-7 {
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }
}

@media (max-width: 767.98px) {
    .login-page .d-none {
        display: none !important;
    }
}
</style> -->
