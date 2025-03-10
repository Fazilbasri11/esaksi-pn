
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


@if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-green-500 text-white p-3 rounded mb-3">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-red-500 text-white p-3 rounded mb-3">
        {{ session('error') }}
    </div>
@endif

<script>
    function submitFormData(id) {
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
            }).the(res => res.json()).then(res => {
                console.log(res)

                // if (res.status >= 200 && res.status < 300) { 
                //     console.log(res)
                //     // window.location.reload();
                //     // console.log(res);
                // } else {
                //     console.log(res)
                // }
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
            options_pihak_menghadirkan: [],
            pihaks: [],
            options_pihak_dari: [],
            opts_pihak_menghadirkan_perdata: [
                { value: "penggugat", label: "Penggugat" },
                { value: "tergugat", label: "Tergugat" },
                { value: "turut_tergugat", label: "Turut Tergugat" },
                { value: "pemohon", label: "Pemohon" },
            ],
            opts_pihak_menghadirkan_pidana: [
                { value: "jaksa", label: "Jaksa" },
                { value: "terdakwa", label: "Terdakwa" },
                { value: "jaksa_dan_terdakwa", label: "Jaksa dan Terdakwa" }
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

                        if(this.jenis === 'pidana'){
                            this.options_pihak_menghadirkan = this.opts_pihak_menghadirkan_pidana;
                            this.pihaks = [
                                { value: "saksi", label: "Saksi" },
                                { value: "saksi_anak", label: "Saksi Anak" },
                                { value: "ahli", label: "Ahli" },
                            ];
                        } else if(this.jenis === 'perdata'){
                            this.options_pihak_menghadirkan = this.opts_pihak_menghadirkan_perdata;
                            this.pihaks = [
                                { value: "saksi", label: "Saksi" },
                                { value: "ahli", label: "Ahli" },
                            ];
                        };
                    })
                    .catch(err => console.error('Gagal memuat data:', err));
            },
            fetchPihak() {
                fetch(`/api/v1/pihak?no_perkara=${this.no_perkara}&pihak=${this.pihak_menghadirkan}`)
                .then(res => res.json())
                .then(data => {
                    const countIndex = {
                        penggugat: 0,
                        tergugat: 0,
                        turut_tergugat: 0,
                        pemohon: 0,
                        jaksa: 0,
                        terdakwa: 0,
                        jaksa_dan_terdakwa: 0,
                    };

                    const pihak_dari = data.map((item, i) => {
                        countIndex[item.pihak] += 1;
                        const data = { 
                            value: item.id, 
                            label: `${item.nama} (${item.pihak} ${countIndex[item.pihak]})` 
                        };
                        return data;
                    });
                    this.options_pihak_dari = pihak_dari;
                })
                .catch(err => console.error('Gagal memuat data:', err));
            }
        };
    }

    function perkaraBiasaStore() {
        return {
            jenis_pidana: "",
            no_perkara: "",
            pihak_menghadirkan: "",
            pihak_hadir: "",
            pihaks: [],
            perkaras: [],
            pihak_detail: [],
            fetchData() {
                if(this.jenis_pidana == "pidana") {
                            this.pihaks = [
                                { value: "jaksa", label: "Jaksa" },
                                { value: "terdakwa", label: "Terdakwa" },
                                { value: "jaksa_dan_terdakwa", label: "Jaksa dan Terdakwa" }
                            ];
                        } else if(this.jenis_pidana == "perdata") {
                            this.pihaks = [
                                { value: "penggugat", label: "Penggugat" },
                                { value: "tergugat", label: "Tergugat" },
                                { value: "turut_tergugat", label: "Turut Tergugat" },
                                { value: "pemohon", label: "Pemohon" }
                            ];
                };
                fetch(`/api/v1/perkara?jenis_pidana=${this.jenis_pidana}`)
                    .then(res => res.json())
                    .then(data => {
                        this.perkaras = data;
                    })
                    .catch(err => console.error('Gagal memuat data:', err));
            },
            fetchDataPihakHadir() {
                fetch(`/api/v1/pihak?no_perkara=${this.no_perkara}&pihak=${this.pihak_menghadirkan}`)
                    .then(res => res.json())
                    .then(data => {    
                        const countIndex = {
                            penggugat: 0,
                            tergugat: 0,
                            turut_tergugat: 0,
                            pemohon: 0,
                            jaksa: 0,
                            terdakwa: 0,
                            jaksa_dan_terdakwa: 0,
                        };
                        const pihak_detail = data.map((item, i) => {
                            countIndex[item.pihak] += 1;
                            const data = { 
                                value: item.id, 
                                label: `${item.nama} (${item.pihak} ${countIndex[item.pihak]})` 
                            };
                            return data;
                        });
                        this.pihak_detail = pihak_detail;
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
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                action="{{ route('agenda-saksi.add') }}" 
                method="POST" 
                id="form-create"
                x-data="perkaraStore()"
           
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
                        <option value="pidana">Pidana</option>
                        <option value="perdata">Perdata</option>
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
                    <select class="custom-select w-full" id="pihak_menghadirkan" name="pihak_menghadirkan" x-model="pihak_menghadirkan" x-on:change="fetchPihak()">
                        <option selected hidden value="">Pilih Pihak Yang Menghadirkan...</option>
                        <template x-for="pihak_menghadirkan in options_pihak_menghadirkan" :key="pihak_menghadirkan.value">
                            <option :value="pihak_menghadirkan.value" x-text="pihak_menghadirkan.label"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label for="pihak_menghadirkan" class="flex mb-0.5">Pihak Dari</label>
                    <template x-if="errors?.pihak_menghadirkan">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.pihak_menghadirkan"></p>
                    </template>
                    <select class="custom-select w-full mt-2" id="pihak_dari" name="pihak_dari" x-model="pihak_dari">
                        <option selected hidden value="">Pilih Pihak...</option>
                        <template x-for="pihak_dari in options_pihak_dari" :key="pihak_dari.value">
                            <option :value="pihak_dari.value" x-text="pihak_dari.label"></option>
                        </template>
                    </select>
                </div>

                

                <div>
                    <label for="pihak" class="flex mb-0.5">Pihak</label>
                    <template x-if="errors?.pihak">
                        <p class="text-red-500 text-sm mb-1" x-text="errors?.pihak"></p>
                    </template>
                    <select class="custom-select w-full" id="pihak" name="pihak" x-model="pihak">
                        <option selected value="" hidden>Pilih Pihak...</option>
                        <template x-for="pihak in pihaks" :key="pihak.value">
                            <option :value="pihak.value" x-text="pihak.label"></option>
                        </template>
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
            <form action="{{ route('agenda-biasa.add') }}" method="POST" 
                id="form-agenda-biasa"
                x-data="perkaraBiasaStore()" 
                class="flex flex-col gap-3"
            >
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label for="jenis_pidana" class="flex mb-0.5">Jenis Perkara</label>
                        <select class="custom-select w-full" id="jenis_pidana" name="jenis_pidana" x-model="jenis_pidana"
                            x-on:change="fetchData()">
                            <option selected hidden value="">Pilih Jenis Pidana</option>
                            <option value="pidana">Pidana</option>
                            <option value="perdata">Perdata</option>
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
                    <div>
                        <label for="pihak_menghadirkan" class="flex mb-0.5" x-show="jenis_pidana=='perdata'">Jenis Pihak</label>
                        <label for="pihak_menghadirkan" class="flex mb-0.5" x-show="jenis_pidana=='pidana'">Pihak Yang Hadir</label>
                        <select x-on:change="fetchDataPihakHadir()" class="custom-select w-full" id="pihak_menghadirkan" name="pihak_menghadirkan" x-model="pihak_menghadirkan">
                            <option selected hidden value="">Pilih Pihak Menghadirkan</option>
                            <template x-for="option in pihaks" :key="option.value">
                                <option :value="option.value" x-text="option.label"></option>
                            </template>
                        </select>
                    </div>
                    <div x-show="jenis_pidana=='perdata'">
                        <label for="pihak_hadir" class="flex mb-0.5">Pihak Yang Hadir</label>
                        <select class="custom-select w-full" id="pihak_hadir" name="pihak_hadir" x-model="pihak_hadir">
                            <option selected hidden value="">Pilih Pihak</option>
                            <template x-for="option in pihak_detail" :key="option.value">
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


