
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

<script>
    function submitFormData(id) {
        console.clear();
        const form = document.querySelector("#"+id);
        const action = form.action || ""; 
        if (form) {
            const inputs = form.querySelectorAll("input, select, textarea");
            const csrfToken = document.querySelector('input[name="_token"]').value;
            const dataForm = {
                jenis_pidana: "",
                no_perkara: "",
                pihak_menghadirkan: "",
                pihak: "",
                tanggal: "",
                rows: [],
            };
            for (let i = 0; i < inputs.length; i++) {
                const element = inputs[i];
                const name = element.name;
                const value = element.value;
                switch (true) {
                    case name === "jenis":
                        dataForm.jenis_pidana = value;
                    break;
                    case name === "no_perkara":
                        dataForm.no_perkara = value;
                        break;
                    case name === "pihak_menghadirkan":
                        dataForm.pihak_menghadirkan = value;
                        break;
                    case name === "pihak":
                        dataForm.pihak = value;
                        break;
                    case name === "tanggal":
                        dataForm.tanggal = value;
                        break;
                    default:
                        const nameList = name.split(".").filter(Boolean);
                        if(nameList.length) {
                            if(dataForm.rows.length < Number(nameList[2])+1) {
                                dataForm.rows.push({
                                    nama: "",
                                    telepon: "",
                                })
                            }
                            switch (true) {
                                case nameList[1] == "nama":
                                    dataForm.rows[Number(nameList[2])]["nama"] = value;
                                break;
                                case nameList[1] == "telepon":
                                    dataForm.rows[Number(nameList[2])]["telepon"] = value;
                                break;
                            }
                        }
                    break;
                }
            }
            fetch(action, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken,  // Kirim CSRF Token di Header
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataForm),
                credentials: "include",
            }).then(res => {
                if (res.status >= 200 && res.status < 300) { 
                    window.location.reload();
                    // console.log(dataForm);
                }
            }).catch(error => {
                alert("Terjadi kesalahan: " + error.message);
            });
            } else {
                    throw Error("Form Not Found.")
            }
    }
    function perkaraStore() {
        return { 
            jenis: '',
            no_perkara: "",
            pihak_menghadirkan: "",
            pihak: "",
            tanggal: "",
            perkaras: [],
            rows: [],
            optionsPidana: [
                { value: 'jaksa', label: 'Jaksa' },
                { value: 'terdakwa', label: 'Terdakwa' },
                { value: 'pengacara', label: 'Pengacara' },
                { value: 'jaksa_dan_terdakwa', label: 'Jaksa dan Terdakwa' }
            ],
            optionsPerdata: [
                { value: 'penggugat', label: 'Penggugat' },
                { value: 'tergugat', label: 'Tergugat' },
                { value: 'turut_tergugat', label: 'Turut Tergugat' },
                { value: 'pemohon', label: 'Pemohon' }
            ],
            errors: {},
            submitForm() {
                this.errors = {}; 
                if (!this.jenis) this.errors.jenis = 'Silahkan Jenis Perkara Terlebih Dahulu.'; 
                if (!this.no_perkara) this.errors.no_perkara = 'Silahkan Pilih Nomor Perkara Terlebih Dahulu.';
                if (!this.pihak_menghadirkan) this.errors.pihak_menghadirkan = 'Silahkan Pilih Pihak Yang Menghadirkan Terlebih Dahulu.';
                if (!this.pihak) this.errors.pihak = 'Silahkan Pilih Pihak Terlebih Dahulu.';
                if (this.rows.length == 0) this.errors.rows = 'Tambahkan Minimal satu data';
                if (Object.keys(this.errors).length === 0) { 
                    submitFormData('form-create')
                }
            },
            fetchData() {
                fetch(`/api/v1/perkara?jenis_pidana=${this.jenis}`)
                    .then(res => res.json())
                    .then(data => {
                        this.perkaras = data;
                    })
                    .catch(err => console.error('Gagal memuat data:', err));
            },
            // Fungsi untuk mendapatkan opsi berdasarkan jenis_pidana
            getOptions() {
                if(this.jenis_pidana === 'pidana'){
                    return this.optionsPidana;
                } else if(this.jenis_pidana === 'perdata'){
                    return this.optionsPerdata;
                }
                return [];
            },
        };
    }

    function perkaraBiasaStore() {
        return {
            jenis_pidana: "",
            perkaras: [],
            no_perkara: "",
            pihaks: [],
            fetchData() {
                fetch(`/api/v1/perkara?jenis_pidana=${this.jenis_pidana}`)
                    .then(res => res.json())
                    .then(data => {
                        this.perkaras = data;
                    })
                    .catch(err => console.error('Gagal memuat data:', err));
            },
            fetchDataPihak() {
                fetch(`/api/v1/pihak?jenis_perkara=${this.jenis_pidana}&no_perkara=${this.no_perkara}`)
                    .then(res => res.json())
                    .then(data => {
                        if(data && data.length >0) {
                            this.pihaks = data.map(item => ({
                                label: `${item.pihak.charAt(0).toUpperCase() + item.pihak.slice(1)} (${item.nama} ${item.no_telp})`,
                                value: item.id.toString(),
                            }))
                        }
                    })
                    .catch(err => console.error('Gagal memuat data:', err));
            },
        }
    }

    function hadiriAgendaBiasa(id) {
        const form = document.getElementById("form-agenda-biasa");
        if(form) {
            const selected = form.querySelector("select[name='pihak_menghadirkan']");
            const csrfToken = document.querySelector('input[name="_token"]').value;
            fetch(`/agenda-biasa/hadir/${selected.value}`, {
                method: "PATCH",
                headers: {
                    'X-CSRF-TOKEN': csrfToken,  // Kirim CSRF Token di Header
                    'Content-Type': 'application/json'
                },
                body: null,
                credentials: "include",
            }).then(res => {
                if (res.status >= 200 && res.status < 300) { 
                    window.location.reload();
                }
            }).catch(error => {
                alert("Terjadi kesalahan: " + error.message);
            });
        }
    }
</script>

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
                <h5 class="card-title fw-semibold text-center mb-4">Agenda Saksi</h5>
                <p class="card-text text-center mb-4 flex-grow">
                    Jadwal dan informasi terkait kehadiran saksi dalam proses perkara perdata, termasuk waktu, lokasi, serta pihak-pihak yang terlibat.
                </p>
                <div class="flex items-center justify-center mt-auto">
                    <a @click="saksi_perdata=true" class="btn btn-success">Hadiri Agenda</a>
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
            <h2 class="text-2xl font-semibold mb-4">Informasi Pihak</h2>
            <form 
                class="flex flex-col gap-2"
                action="{{ route('saksi-perdata.add') }}" 
                method="POST" 
                id="form-create"
                x-data="perkaraStore()"
                x-on:submit.prevent="submitForm()"
            >
                @csrf
                <input type="text" name="agenda" value="perdata" hidden>
                <div>
                    <label for="jenis" class="flex mb-0.5">Jenis Perkara</label>
                    <template x-if="errors?.jenis">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.jenis"></p>
                    </template>
                    <select class="custom-select w-full" id="jenis" name="jenis" x-model="jenis"
                        x-on:change="fetchData()">
                        <option selected hidden value="">Pilih Jenis Perkara</option>
                        <option value="perdata">Perdata</option>
                        <option value="pidana">Pidana</option>
                    </select>
                </div>
                <div>
                    <label for="no_perkara" class="flex mb-0.5">Nomor Perkara</label>
                    <template x-if="errors?.no_perkara">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.no_perkara"></p>
                    </template>
                    <select class="custom-select w-full" id="no_perkara" name="no_perkara" x-model="no_perkara">
                        <option selected hidden>Pilih Nomor Perkara</option>
                        <template x-for="perkara in perkaras" :key="perkara.no">
                            <option :value="perkara.no" x-text="perkara.no"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label for="pihak_menghadirkan" class="flex mb-0.5">Pihak Yang Menghadirkan</label>
                    <template x-if="errors?.pihak_menghadirkan">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.pihak_menghadirkan"></p>
                    </template>
                    <select class="custom-select w-full" id="pihak_menghadirkan" name="pihak_menghadirkan" x-model="pihak_menghadirkan">
                        <option selected hidden value="">Pilih Pihak Yang Menghadirkan...</option>
                        <option value="penggugat">Penggugat</option>
                        <option value="tergugat">Tergugat</option>
                        <option value="turut_tergugat">Turut Tergugat</option>
                        <option value="pemohon">Pemohon</option>
                    </select>
                </div>
                <div>
                    <label for="pihak" class="flex mb-0.5">Pihak</label>
                    <template x-if="errors?.pihak">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.pihak"></p>
                    </template>
                    <select class="custom-select w-full" id="pihak" name="pihak" x-model="pihak">
                        <option selected value="" hidden>Pilih Pihak...</option>
                        <option value="saksi">Saksi</option>
                        <option value="saksi_anak">Saksi Anak</option>
                        <option selected value="ahli">Ahli</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal" class="flex mb-0.5">Tanggal</label>
                    <template x-if="errors?.tanggal">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.tanggal"></p>
                    </template>
                    <input
                        x-model="date_now"
                        name="tanggal"
                        type="date"
                        class="w-full p-2 rounded focus:outline-none tanggal"
                    />
                </div>
                <div>
                    <div>Data Pihak</div>
                    <template x-if="errors?.rows">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.rows"></p>
                    </template>
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-300">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-3 py-3 border">Nama</th>
                                <th class="px-3 py-3 border">Nomor Telepon</th>
                                <th class="px-3 py-3 border text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, index) in rows" :key="index">
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                    <td class="px-3 py-3 border">
                                        <input 
                                            :name="`row.nama.${index}`" 
                                            type="text" 
                                            x-model="row.nama" 
                                            class="w-full bg-transparent outline-none" 
                                            placeholder="Nama Pihak...">
                                    </td>
                                    <td class="px-3 py-3 border">
                                        <input type="text" 
                                            :name="`row.telepon.${index}`" 
                                            x-model="row.telepon" 
                                            class="w-full bg-transparent outline-none" 
                                            placeholder="Nomor Telepon...">
                                    </td>
                                    <td class="px-3 py-3 border text-right">
                                        <button @click="rows.splice(index, 1)" class="p-2 bg-red-500 text-white rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 11v6m-4-6v6M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M4 7h16M7 7l2-4h6l2 4"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td colspan="4">
                                    <button type="button" @click="rows.push({ nama: '', telepon: '' })" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M20 14h-6v6h-4v-6H4v-4h6V4h4v6h6z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

    <!-- Agenda Biasa -->
    <section class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 md:pt-24 z-20 overflow-auto py-20 md:py-0" x-show="agenda_biasa" x-transition>
        <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl min-h-max md:max-h-max rounded- mb-20 md:mb-0 overflow-visible"  @click.outside="agenda_biasa=false">
            <h2 class="text-2xl font-semibold mb-4">Informasi Pihak Agenda Biasa</h2>
            <form action="{{ route('saksi-perdata.add') }}" method="POST" 
                id="form-agenda-biasa"
                x-data="perkaraBiasaStore()" 
                class="flex flex-col gap-3"
                x-on:submit.prevent="hadiriAgendaBiasa('form-agenda-biasa')">
                @csrf
                <div x-data="perkaraBiasaStore()" class="flex flex-col gap-3">
                    <div>
                        <label for="jenis_pidana" class="flex mb-0.5">Jenis Perkara</label>
                        <select class="custom-select w-full" id="jenis_pidana" name="jenis_pidana" x-model="jenis_pidana"
                            x-on:change="fetchData()">
                            <option selected hidden value="">Pilih Jenis Pidana</option>
                            <option value="perdata">Perdata</option>
                            <option value="pidana">Pidana</option>
                        </select>
                    </div>
                    <div>
                        <label for="no_perkara" class="flex mb-0.5">Nomor Perkara</label>
                        <select class="custom-select w-full" id="no_perkara" name="no_perkara" x-model="no_perkara"
                        x-on:change="fetchDataPihak()">
                            <option selected hidden>Pilih Nomor Perkara</option>
                            <template x-for="perkara in perkaras" :key="perkara.no">
                                <option :value="perkara.no" x-text="perkara.no"></option>
                            </template>
                        </select>
                    </div>

                    
                    <div>
                        <label for="pihak_menghadirkan" class="flex mb-0.5">Pihak Yang Hadir</label>
                        <select class="custom-select w-full" id="pihak_menghadirkan" name="pihak_menghadirkan" x-model="jenis">
                            <option selected hidden value="">Pilih Pihak Menghadirkan</option>
                            <template x-for="option in pihaks" :key="option.value">
                                <option :value="option.value" x-text="option.label"></option>
                            </template>
                        </select>
                    </div>
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
</section>
</x-guest-layout>


