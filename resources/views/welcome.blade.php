
<x-guest-layout>
    @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                @if (Route::has('register'))
                <!-- <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a> -->
            @endif
            @endauth
        </div>
    @endif


    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-3 h-24">
        <a class="navbar-brand fw-bold text-white flex items-center justify-center gap-2" href="/">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                    <path fill="white" d="M12 3c-1.27 0-2.4.8-2.82 2H3v2h1.95L2 14c-.47 2 1 3 3.5 3s4.06-1 3.5-3L6.05 7h3.12c.33.85.98 1.5 1.83 1.83V20H2v2h20v-2h-9V8.82c.85-.32 1.5-.97 1.82-1.82h3.13L15 14c-.47 2 1 3 3.5 3s4.06-1 3.5-3l-2.95-7H21V5h-6.17C14.4 3.8 13.27 3 12 3m0 2a1 1 0 0 1 1 1a1 1 0 0 1-1 1a1 1 0 0 1-1-1a1 1 0 0 1 1-1m-6.5 5.25L7 14H4zm13 0L20 14h-3z"/>
                </svg>
            </div>
            <span>
                E-Saksi
            </span>
        </a>
    </nav>

    <section class="container my-5 min-h-screen">
        <h1 class="text-center mb-2">Selamat Data Di E-Saksi</h1>
        <p class="text-center mb-8">Silahkan Pilih Agenda</p>
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 sm:gap-2 xs:gap-2 lg:gap-8 xl:gap-8 2xl:gap-8">
            <div class="shadow-xl px-4 py-4 border border-gray-200/10 rounded-md flex flex-col h-full">
                <h5 class="card-title fw-semibold text-center mb-4">Agenda Saksi Perdata</h5>
                <p class="card-text text-center mb-4 flex-grow">
                    Jadwal dan informasi terkait kehadiran saksi dalam proses perkara perdata, termasuk waktu, lokasi, serta pihak-pihak yang terlibat.
                </p>
                <div class="flex items-center justify-center mt-auto">
                    <a href="/agenda-saksi-perdata" class="btn btn-success">Detail Agenda</a>
                </div>
            </div>
            <div class="shadow-xl px-4 py-4 border border-gray-200/10 rounded-md flex flex-col h-full">
                <h5 class="card-title fw-semibold text-center mb-4">Agenda Saksi Pidana</h5>
                <p class="card-text text-center mb-4 flex-grow">
                    Jadwal dan rincian kehadiran saksi dalam proses perkara pidana, mencakup waktu, lokasi, serta pihak yang terlibat dalam persidangan atau penyelidikan.
                </p>
                <div class="flex items-center justify-center mt-auto">
                    <a href="/agenda-saksi-pidana" class="btn btn-success">Detail Agenda</a>
                </div>
            </div>
            <div class="shadow-xl px-4 py-4 border border-gray-200/10 rounded-md flex flex-col h-full">
                <h5 class="card-title fw-semibold text-center mb-4">Agenda Biasa</h5>
                <p class="card-text text-center mb-4 flex-grow">
                    Jadwal kegiatan rutin atau pertemuan yang telah direncanakan, mencakup waktu, tempat, dan agenda yang akan dibahas.
                </p>
                <div class="flex items-center justify-center mt-auto">
                    <a href="/agenda-biasa" class="btn btn-success">Detail Agenda</a>
                </div>
            </div>
        </section>
    </section>

    <footer class="bg-success text-white text-center h-24 flex items-center justify-center">
        <p class="m-0">Copyright &copy; 2025 <a target="__blank" class="hover:text-blue-800 text-inherit no-underline" href="https://e-saksi.jasakode.com">E-saksi</a>. All rights reserved.</p>
    </footer>

</x-guest-layout>