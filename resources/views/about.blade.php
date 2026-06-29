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
                    {!! __('about_p1') !!}
                </p>
                
                <h3 class="text-2xl font-bold mt-10 mb-6 tracking-tight">{{ __('Latar Belakang Berdirinya IMM') }}</h3>
                <p class="text-justify mb-6">
                    {!! __('about_p2') !!}
                </p>
                <p class="text-justify mb-8">
                    {!! __('about_p3') !!}
                </p>

                <h3 class="text-2xl font-bold mt-10 mb-6 tracking-tight">{{ __('Enam Penegasan IMM') }}</h3>
                <p class="mb-6">{{ __('Dalam peresmiannya, dideklarasikan "Enam Penegasan IMM" yang menjadi landasan utama perjuangan organisasi:') }}</p>
                <ol class="list-decimal pl-6 mb-8 space-y-4">
                    <li>{{ __('Menegaskan bahwa IMM adalah gerakan mahasiswa Islam.') }}</li>
                    <li>{{ __('Menegaskan bahwa kepribadian Muhammadiyah adalah landasan perjuangan IMM.') }}</li>
                    <li>{{ __('Menegaskan bahwa fungsi IMM adalah eksponen mahasiswa dalam Muhammadiyah.') }}</li>
                    <li>{{ __('Menegaskan bahwa IMM adalah organisasi yang sah dengan mengindahkan segala hukum, undang-undang, peraturan, serta dasar dan falsafah negara.') }}</li>
                    <li>{{ __('Menegaskan bahwa ilmu adalah amaliah dan amal adalah ilmiah.') }}</li>
                    <li>{{ __('Menegaskan bahwa amal IMM adalah lillahi ta\'ala dan senantiasa diabadikan untuk kepentingan rakyat.') }}</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
