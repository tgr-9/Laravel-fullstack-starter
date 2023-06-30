<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Kredensial tersebut tidak sesuai dengan data kami.',
    'password' => 'Password tersebut tidak sesuai.',
    'throttle' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam :seconds detik.',

    'notices' => [
        'verify-email' => 'Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email dengan klik link yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, dengan senang hati akan kami kirim kembali.',
        'verification-link-sent' => 'Link verifikasi baru saja terkirim ke alamat email yang anda cantumkan pada saat registrasi.',
        'confirm-password' => 'Silakan konfirmasi kata sandi anda sebelum melanjutkan.',
        'forgot-password' => 'Lupa kata sandi anda? Tidak masalah. Silakan tuliskan alamat email anda dan akan kami kirimkan petunjuk untuk membuat kata sandi baru untuk Anda.',
    ],

    'routes' => [
        'login' => 'Login',
        'register' => 'Register',
        'confirm-password' => 'Konfirmasi Kata Sandi',
        'forgot-password' => 'Lupa Kata Sandi',
        'reset-password' => 'Reset Kata Sandi',
        'verify-email' => 'Verifikasi Email',
    ],

    'username' => [
        'label' => 'Nama Pengguna',
        'placeholder' => 'Tuliskan nama pengguna Anda',
        // 'description' => null,
    ],

    'email' => [
        'label' => 'Email',
        'placeholder' => 'Contoh: johndoe@example.com',
        // 'description' => null,
    ],

    'password' => [
        'label' => 'Kata Sandi',
        'placeholder' => 'Tuliskan kata sandi',
        // 'description' => null,
    ],

    'new_password' => [
        'label' => 'New Kata Sandi',
        'placeholder' => 'Tuliskan kata sandi baru',
        // 'description' => null,
    ],

    'confirm_password' => [
        'label' => 'Konfirmasi Kata Sandi',
        'placeholder' => 'Tulis ulang kata sandi baru',
        // 'description' => null,
    ],

    'remember' => [
        'label' => 'Ingat saya',
    ],

    'actions' => [
        'forgot' => 'Lupa kata sandi Anda?',
        'registered' => 'Sudah terdaftar?',
        'confirm' => 'Konfirmasi',
        'login' => 'Masuk',
        'register' => 'Daftar',
        'reset' => 'Atur ulang',
        'resend' => 'Kirim Ulang Email Verifikasi',
        'request' => 'Email Password Reset Link',
        'logout' => 'Keluar',
    ],

];
