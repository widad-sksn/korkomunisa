@extends('layouts.public')

@section('content')
    <!-- Sejarah Section -->
    <div id="sejarah" class="py-24 bg-theme-bg transition-colors duration-300 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-theme-text tracking-tight">{{ __('Tentang IMM') }}</h2>
                <div class="w-24 h-1 bg-theme-primary mx-auto mt-6 rounded-full"></div>
            </div>
            
            <div class="prose prose-lg dark:prose-invert mx-auto text-theme-text">
                <p class="text-lg leading-relaxed text-justify mb-8">
                    <strong>Ikatan Mahasiswa Muhammadiyah (IMM)</strong> adalah gerakan mahasiswa Islam dan salah satu organisasi otonom Muhammadiyah yang lahir di Yogyakarta pada <strong>14 Maret 1964 M</strong> atau bertepatan dengan <strong>29 Syawal 1384 H</strong>.
                </p>
                
                <h3 class="text-2xl font-bold mt-10 mb-6 tracking-tight">Latar Belakang Berdirinya IMM</h3>
                <p class="text-justify mb-6">
                    Kelahiran IMM didorong oleh kebutuhan yang mendesak untuk membina kader Muhammadiyah di tingkat perguruan tinggi. Pada masa itu, terdapat keinginan kuat untuk mencetak "Muslim Intelektual" yang mampu menyebarkan dakwah Muhammadiyah secara efektif di kalangan kampus. Selain itu, kondisi bangsa Indonesia yang tidak stabil dan maraknya persaingan ideologi pada masa 1950-1964 membuat Muhammadiyah memandang perlu adanya wadah khusus untuk membentengi mahasiswa dari paham-paham yang bertentangan dengan ajaran Islam.
                </p>
                <p class="text-justify mb-8">
                    Tokoh pelopor yang berperan sangat penting dalam pendirian IMM antara lain adalah <strong>Djazman Al-Kindi</strong>, Rosyad Sholeh, Sudibyo Markus, Amien Rais, dan beberapa tokoh mahasiswa Muhammadiyah lainnya yang mengusulkan pembentukan organisasi ini kepada Pimpinan Pusat Muhammadiyah.
                </p>

                <h3 class="text-2xl font-bold mt-10 mb-6 tracking-tight">Enam Penegasan IMM</h3>
                <p class="mb-6">Dalam peresmiannya, dideklarasikan "Enam Penegasan IMM" yang menjadi landasan utama perjuangan organisasi:</p>
                <ol class="list-decimal pl-6 mb-8 space-y-4">
                    <li>Menegaskan bahwa IMM adalah gerakan mahasiswa Islam.</li>
                    <li>Menegaskan bahwa kepribadian Muhammadiyah adalah landasan perjuangan IMM.</li>
                    <li>Menegaskan bahwa fungsi IMM adalah eksponen mahasiswa dalam Muhammadiyah.</li>
                    <li>Menegaskan bahwa IMM adalah organisasi yang sah dengan mengindahkan segala hukum, undang-undang, peraturan, serta dasar dan falsafah negara.</li>
                    <li>Menegaskan bahwa ilmu adalah amaliah dan amal adalah ilmiah.</li>
                    <li>Menegaskan bahwa amal IMM adalah <em>lillahi ta'ala</em> dan senantiasa diabadikan untuk kepentingan rakyat.</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
