
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

<section 
    x-data="{ 
        saksi_perdata: false, 
        saksi_pidana: false, 
        agenda_biasa: false,
        date_now: (() => {
            const today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const yyyy = today.getFullYear();
            return `${yyyy}-${mm}-${dd}`
        })(),
    }"
>
     





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
                    <a @click="saksi_perdata=true" class="btn btn-success">Hadiri Agenda</a>
                </div>
            </div>
            <div class="hidden shadow-xl px-4 py-4 border border-gray-200/10 rounded-md flex flex-col h-full">
                <h5 class="card-title fw-semibold text-center mb-4">Agenda Saksi Pidana</h5>
                <p class="card-text text-center mb-4 flex-grow">
                    Jadwal dan rincian kehadiran saksi dalam proses perkara pidana, mencakup waktu, lokasi, serta pihak yang terlibat dalam persidangan atau penyelidikan.
                </p>
                <div class="flex items-center justify-center mt-auto">
                    <button @click="saksi_pidana=true" class="btn btn-success">Detail Agenda</button>
                </div>
            </div>
            <div class="shadow-xl px-4 py-4 border border-gray-200/10 rounded-md flex flex-col h-full">
                <h5 class="card-title fw-semibold text-center mb-4">Agenda Biasa</h5>
                <p class="card-text text-center mb-4 flex-grow">
                    Jadwal kegiatan rutin atau pertemuan yang telah direncanakan, mencakup waktu, tempat, dan agenda yang akan dibahas.
                </p>
                <div class="flex items-center justify-center mt-auto">
                    <button @click="agenda_biasa=true" class="btn btn-success">Detail Agenda</button>
                </div>
            </div>
        </section>
    </section>

    <footer class="bg-success text-white text-center h-24 flex items-center justify-center">
        <p class="m-0">Copyright &copy; 2025 <a target="__blank" class="hover:text-blue-800 text-inherit no-underline" href="https://e-saksi.jasakode.com">E-saksi</a>. All rights reserved.</p>
    </footer>


 


    <!-- Saksi Perdata -->
    <section class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 md:pt-24 z-20 overflow-auto py-20 md:py-0" x-show="saksi_perdata" x-transition>
        <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl min-h-max md:max-h-max rounded- mb-20 md:mb-0 overflow-visible"  @click.outside="saksi_perdata=false">
            <h2 class="text-2xl font-semibold mb-4">Informasi Pihak Saksi</h2>
            <form action="{{ route('saksi-perdata.add') }}" method="POST" 
                x-data="{ 
                    jenis_pidana: '', 
                    no_perkara: '',
                    pihak_menghadirkan: '',
                    pihak: '',
                    nama: '',
                    nomor_telepon: '',
                }" 
                class="flex flex-col gap-3">
                @csrf
                <input type="text" name="agenda" value="perdata" hidden>
                <div x-data="perkaraStore()" class="flex flex-col gap-3">
                    <div>
                        <label for="jenis_pidana" class="flex mb-0.5">Jenis Pidana</label>
                        <select class="custom-select w-full" id="jenis_pidana" name="jenis_pidana" x-model="jenis_pidana"
                            x-on:change="fetchData()">
                            <option selected hidden value="">Pilih Jenis Pidana</option>
                            <option value="perdata">Perdata</option>
                            <option value="pidana">Pidana</option>
                        </select>
                    </div>
                    <div>
                        <label for="no_perkara" class="flex mb-0.5">Nomor Perkara</label>
                        <select class="custom-select w-full" id="no_perkara" name="no_perkara" x-model="no_perkara">
                            <option selected hidden>Pilih Nomor Perkara</option>
                            <template x-for="perkara in perkaras" :key="perkara.no">
                                <option :value="perkara.no" x-text="perkara.no"></option>
                            </template>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="pihak_menghadirkan" class="flex mb-0.5">Jenis Pihak Menghadirkan</label>
                    <select class="custom-select w-full" id="pihak_menghadirkan" name="pihak_menghadirkan" x-model="pihak_menghadirkan">
                        <option selected hidden value="">Pilih Pihak Menghadirkan</option>
                        <option value="tergugat">Tergugat</option>
                        <option value="penggugat">Penggugat</option>
                        <option value="turut_tergugat">Turut Tergugat</option>
                        <option value="pemohon">Pemohon</option>
                        <option value="termohon">Termohon</option>
                    </select>
                </div>
                <div>
                    <label for="pihak" class="flex mb-0.5">Pihak</label>
                    <select class="custom-select w-full" id="pihak" name="pihak" x-model="pihak">
                        <option selected value="saksi">Saksi</option>
                        <option value="ahli">Ahli</option>
                    </select>
                </div>
                <div>
                    <label for="nama">Nama</label>
                    <input
                        x-model="nama"
                        name="nama"
                        type="text"
                        placeholder="Nama"
                        class="w-full p-2 rounded focus:outline-none"
                    />
                </div>
                <div>
                    <label for="nomor_telepon" class="flex mb-0.5">Nomor Telepon</label>
                    <input
                        x-model="nomor_telepon"
                        id="nomor_telepon"
                        name="nomor_telepon"
                        type="text"
                        placeholder="Nomor Telepon..."
                        class="w-full p-2 rounded focus:outline-none"
                    />
                </div>
                <div>
                    <label for="tanggal" class="flex mb-0.5">Tanggal</label>
                    <input
                        x-model="date_now"
                        name="tanggal"
                        type="date"
                        class="w-full p-2 rounded focus:outline-none tanggal"
                    />
                </div>
                <nav class="flex flex-wrap items-center gap-2 justify-end mt-8">
                    <button 
                        @click="saksi_perdata=false" 
                        type="button" 
                        class="btn btn-outline-danger"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800"
                    >
                        Hadiri Agenda
                    </button>
                </nav>
            </form>
        </div>
    </section>

    <!-- Saksi Pidana -->
    <section class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 md:pt-24 z-20 overflow-auto py-20 md:py-0" x-show="saksi_pidana" x-transition>
        <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl min-h-max md:max-h-max rounded- mb-20 md:mb-0 overflow-visible"  @click.outside="saksi_pidana=false">
            <h2 class="text-2xl font-semibold mb-4">Informasi Pihak Saksi Pidana</h2>
            <form action="#" method="POST" x-data="{ jenis: '', pihak: '' }" class="flex flex-col gap-3">
                <div>
                    <label for="jenis_pidana" class="flex mb-0.5">Jenis Pidana</label>
                    <select class="custom-select w-full" id="jenis_pidana" x-model="jenis">
                        <option selected hidden value="">Pilih Jenis Pidana</option>
                        <option value="perdata">Perdata</option>
                        <option value="pidana">Pidana</option>
                    </select>
                </div>
                <div>
                    <label for="no_perkara" class="flex mb-0.5">Nomor Perkara</label>
                    <select class="custom-select w-full" id="no_perkara" x-model="no_perkara">
                        <option selected hidden>Pilih Nomor Perkara</option>
                            @if (isset($perkaras) && $perkaras)
                                @foreach ($perkaras as $index => $perkara)
                                    <option value="{{ $perkara['no'] }}">{{ $perkara['no'] }}</option>   
                                @endforeach
                            @endif
                    </select>
                </div>
                <div>
                    <label for="pihak_menghadirkan" class="flex mb-0.5">Jenis Pihak Menghadirkan</label>
                    <select class="custom-select w-full" id="pihak_menghadirkan" name="pihak_menghadirkan" x-model="jenis">
                        <option selected hidden value="">Pilih Pihak Menghadirkan</option>
                        <option value="tergugat">Tergugat</option>
                        <option value="penggugat">Penggugat</option>
                        <option value="turut_tergugat">Turut Tergugat</option>
                        <option value="pemohon">Pemohon</option>
                        <option value="termohon">Termohon</option>
                    </select>
                </div>
                <div>
                    <label for="pihak" class="flex mb-0.5">Pihak</label>
                    <select class="custom-select w-full" id="pihak" x-model="pihak">
                        <option selected value="saksi">Saksi</option>
                        <option value="ahli">Ahli</option>
                    </select>
                </div>
                <div>
                    <label for="badan_hukum" class="flex mb-0.5" x-text="pihak=='ahli' ? 'Nama Ahli' : 'Nama Saksi'">Nama</label>
                    <input
                        type="text"
                        placeholder="Nama"
                        class="w-full p-2 rounded focus:outline-none"
                    />
                </div>
                <div>
                    <label for="badan_hukum" class="flex mb-0.5" x-text="pihak=='ahli' ? 'Nomor Telepon Ahli' : 'Nomor Telepon Saksi'">Nama</label>
                    <input
                        type="text"
                        x-bind:placeholder="pihak=='ahli' ? 'Nomor Telepon Ahli' : 'Nomor Telepon Saksi'"
                        class="w-full p-2 rounded focus:outline-none"
                    />
                </div>
                <div>
                    <label for="tanggal" class="flex mb-0.5">Tanggal</label>
                    <input
                        x-model="(() => {
                            const today = new Date();
                            const dd = String(today.getDate()).padStart(2, '0');
                            const mm = String(today.getMonth() + 1).padStart(2, '0');
                            const yyyy = today.getFullYear();
                            return `${yyyy}-${mm}-${dd}`
                        })()"
                        name="tanggal"
                        type="date"
                        class="w-full p-2 rounded focus:outline-none tanggal"
                        disabled
                    />
                </div>

                

                <nav class="flex flex-wrap items-center gap-2 justify-end mt-8">
                    <button @click="saksi_pidana=false" type="reset" type="button" class="btn btn-outline-danger">Batal</button>
                    <button
                        type="submit"
                        class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800"
                    >
                        Hadiri Agenda
                    </button>
                </nav>
            </form>
        </div>
    </section>

    <!-- Agenda Biasa -->
    <section class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 md:pt-24 z-20 overflow-auto py-20 md:py-0" x-show="agenda_biasa" x-transition>
        <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl min-h-max md:max-h-max rounded- mb-20 md:mb-0 overflow-visible"  @click.outside="agenda_biasa=false">
            <h2 class="text-2xl font-semibold mb-4">Informasi Pihak Agenda Biasa</h2>
            <form action="{{ route('saksi-perdata.add') }}" method="POST" 
                x-data="{ 
                    jenis_pidana: '', 
                    no_perkara: '',
                    pihak_menghadirkan: '',
                    pihak: '',
                    nama: '',
                    nomor_telepon: '',
                }" 
                class="flex flex-col gap-3">
                @csrf
                <div x-data="perkaraStore()" class="flex flex-col gap-3">
                    <div>
                        <label for="jenis_pidana" class="flex mb-0.5">Jenis Pidana</label>
                        <select class="custom-select w-full" id="jenis_pidana" name="jenis_pidana" x-model="jenis_pidana"
                            x-on:change="fetchData()">
                            <option selected hidden value="">Pilih Jenis Pidana</option>
                            <option value="perdata">Perdata</option>
                            <option value="pidana">Pidana</option>
                        </select>
                    </div>
                    <div>
                        <label for="no_perkara" class="flex mb-0.5">Nomor Perkara</label>
                        <select class="custom-select w-full" id="no_perkara" name="no_perkara" x-model="no_perkara">
                            <option selected hidden>Pilih Nomor Perkara</option>
                            <template x-for="perkara in perkaras" :key="perkara.no">
                                <option :value="perkara.no" x-text="perkara.no"></option>
                            </template>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="pihak_menghadirkan" class="flex mb-0.5">Jenis Pihak Menghadirkan</label>
                    <select class="custom-select w-full" id="pihak_menghadirkan" name="pihak_menghadirkan" x-model="jenis">
                        <option selected hidden value="">Pilih Pihak Menghadirkan</option>
                        <option value="tergugat">Tergugat</option>
                        <option value="penggugat">Penggugat</option>
                        <option value="turut_tergugat">Turut Tergugat</option>
                        <option value="pemohon">Pemohon</option>
                        <option value="termohon">Termohon</option>
                    </select>
                </div>
                <div>
                    <label for="pihak" class="flex mb-0.5">Pihak</label>
                    <select class="custom-select w-full" id="pihak" x-model="pihak">
                        <option selected hidden>Pilih Pihak</option>
                        <option value="perorangan">Perorangan</option>
                        <option value="badan_hukum">Badan Hukum</option>
                        <option value="pengacara">Pengacara</option>
                    </select>
                </div>
                <div x-show="pihak=='badan_hukum'">
                    <label for="badan_hukum" class="flex mb-0.5">Nama Badan Hukum</label>
                    <input class="w-full" id="badan_hukum" name="nama_badan_hukum" type="text" placeholder="Masukan nama badan">
                </div>
                <div>
                    <label for="nama" class="flex mb-0.5">Nama</label>
                    <input
                        id="nama"
                        type="text"
                        placeholder="Nama..."
                        class="w-full p-2 rounded focus:outline-none"
                    />
                </div>
                <div>
                    <label for="nomor_telepon" class="flex mb-0.5">Nomor Telepon</label>
                    <input
                        id="nomor_telepon"
                        type="text"
                        placeholder="0812..."
                        class="w-full p-2 rounded focus:outline-none"
                    />
                </div>
                <div>
                    <label for="tanggal" class="flex mb-0.5">Tanggal</label>
                    <input
                        x-model="date_now"
                        name="tanggal"
                        type="date"
                        class="w-full p-2 rounded focus:outline-none tanggal"
                        disabled
                    />
                </div>

                

                <nav class="flex flex-wrap items-center gap-2 justify-end mt-8">
                    <button @click="agenda_biasa=false" type="reset" type="button" class="btn btn-outline-danger">Batal</button>
                    <button
                        type="submit"
                        class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800"
                    >
                        Hadiri Agenda
                    </button>
                </nav>
            </form>
        </div>
    </section>


<script>
    function perkaraStore() {
        return {
            jenis_pidana: '',
            perkaras: [],
            selectedPerkara: '',

            fetchData() {
                fetch(`/api/v1/perkara?jenis_pidana=${this.jenis_pidana}`)
                    .then(res => res.json())
                    .then(data => {
                        this.perkaras = data;
                    })
                    .catch(err => console.error('Gagal memuat data:', err));
            }
        };
    }
</script>

</section>
</x-guest-layout>