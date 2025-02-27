
<x-app-layout>
    <section class="mx-auto w-full lg:max-w-[70%] py-8 px-3" 
        x-data="{ create: false }"
    >

        <h1>Pihak Menghadirkan</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">
            Selamat data di E-Saksi Platform Penjadwalan Agenda Sidang.
        </p>

        <nav class="flex items-center justify-end mb-4 gap-2">
            <button type="button" class="btn btn-success" @click="create=true">Tambah Pihak</button>
        </nav>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <nav class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div></div>
                <div>
                    <div class="flex items-center justify-end gap-2 mb-2">
                        <a href="{{ route('pihak-menghadirkan.form') }}" class="btn btn-success">Create</a>
                    </div>
                </div>
            </nav>

        

            

            <p>Pihak Menghadirkan</p>


            @if (!isset($perkaras) || $perkaras->isEmpty())
                <div class="alert alert-warning">Not Found</div>
            @else
                <section class="flex flex-col gap-4">
                @foreach ($perkaras as $index => $perkara)

  
                
                <div class="bg-gray-200 px-4 py-4">
                    <div class="mb-4">
                        <div class="mb-2 text-[1.1rem]">No Perkara : <span class="font-bold">{{ $perkara->no }}</span></div>
                        <div class="max-w-[300px]">
                            <label for="status" class="form-label">Status Perkara</label>
                            <select class="form-select" id="status" name="status" value="{{ $perkara->status }}">
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    @if (isset($perkara->pihak_menghadirkan) && $perkara->pihak_menghadirkan)
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Penggugat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah Saksi Penggugat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tergugat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah Saksi Tergugat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Turut Penggugat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jumlah Saksi Turut Penggugat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perkara->pihak_menghadirkan as $index => $pihak)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            @if (isset($pihak['penggugat']))
                                            <span>{{ $pihak['penggugat']->nama }} (Penggugat {{ $pihak['penggugat']->index }} )</span>
                                            @endif
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            @if (isset($pihak['penggugat']))
                                            <span>
                                                {{ $pihak['penggugat']->jumlah_saksi }}
                                            </span>
                                            @endif
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            @if (isset($pihak['tergugat']))
                                            <span>{{ $pihak['tergugat']->nama }} (Tergugat {{ $pihak['tergugat']->index }} )</span>
                                            @endif
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            @if (isset($pihak['tergugat']))
                                            <span>
                                                {{ $pihak['tergugat']->jumlah_saksi }}
                                            </span>
                                            @endif
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            @if (isset($pihak['turut_tergugat']))
                                            <span>{{ $pihak['turut_tergugat']->nama }}</span>
                                            @endif
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            @if (isset($pihak['turut_tergugat']))
                                            <span>
                                                {{ $pihak['turut_tergugat']->jumlah_saksi }}
                                            </span>
                                            @endif
                                        </th>
                                        <td class="px-6 py-4">
                                            <a href="#">Edit</a>
                                            <a href="#">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach\
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div>
                        Not Found
                    </div>
                    @endif
                    

                </div>

                @endforeach
                </section>
            @endif

      


       
  
        </div>


        <!-- Create Dialog -->
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20 z-10" x-show="create" :class="{ 'hidden': !create }" x-transition>
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min" @click.outside="create=false">
                <p class="font-bold text-[1.4rem]">Tambah Pihak Baru</p>
                <form action="{{ route('pihak-menghadirkan.form') }}" method="POST"
                    x-data="{ jenis_perdata: '', pihak: '', nama: '', nomor_telepon: '', errors: {}, submitForm() { 
                        this.errors = {};
                        if (!this.jenis_perdata) this.errors.jenis_perdata = 'Silahkan Pilih Jenis Perdata Terlebih Dahulu.'; 
                        if (!this.pihak) this.errors.pihak = 'Silahkan Pilih Pihak Terlebih Dahulu.'; 
                        if (!this.nama) this.errors.nama = 'Silahkan Masukan Nama.'; 
                        if (!this.nomor_telepon) this.errors.nomor_telepon = 'Silahkan Masukan Nomor Telepon.'; 

                        if (Object.keys(this.errors).length === 0) { 
                            this.$nextTick(() => this.$el.submit()); 
                        }
                    }}" 
                    x-on:submit.prevent="submitForm()"
                >
                    @csrf
                    <section class="flex flex-col gap-3">
                        <div>
                            <label for="jenis_perdata" class="flex mb-0.5">Jenis Perdata</label>
                            <template x-if="errors?.jenis_perdata">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.jenis_perdata"></p>
                            </template>
                            <select class="custom-select w-full" id="jenis_perdata" name="jenis_perdata" x-model="jenis_perdata">
                                <option selected hidden>Pilih Jenis Perdata...</option>
                                <option value="gugatan">Gugatan</option> 
                                <option value="gugatan_sederhana">Gugatan Sederhana</option> 
                                <option value="permohonan">Permohonan</option>
                            </select>
                        </div>
                        <div>
                            <label for="pihak" class="flex mb-0.5">Pihak</label>
                            <template x-if="errors?.pihak">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.pihak"></p>
                            </template>
                            <select class="custom-select w-full" id="pihak" name="pihak" x-model="pihak">
                                <option selected hidden value="">Pilih Pihak...</option>
                                <option value="tergugat">Tergugat</option>
                                <option value="penggugat">Penggugat</option>
                                <option value="turut_tergugat">Turut Tergugat</option>
                                <option value="pemohon">Pemohon</option>
                                <option value="termohon">Termohon</option>
                            </select>
                        </div>
                        <div>
                            <label for="nama" class="flex mb-0.5">Nama</label>
                            <template x-if="errors?.nama">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.nama"></p>
                            </template>
                            <input
                                x-model="nama"
                                name="nama"
                                id="nama"
                                type="text"
                                placeholder="Nama..."
                                class="w-full p-2 rounded focus:outline-none"
                            />
                        </div>
                        <div>
                            <label for="nomor_telepon" class="flex mb-0.5">Nomor Telepon</label>
                            <template x-if="errors?.nomor_telepon">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.nomor_telepon"></p>
                            </template>
                            <input
                                name="nomor_telepon"
                                x-model="nomor_telepon"
                                id="nomor_telepon"
                                type="text"
                                placeholder="0812..."
                                class="w-full p-2 rounded focus:outline-none"
                            />
                        </div>
                        <div>
                            <label for="jumlah_saksi" class="flex mb-0.5">Jumlah Saksi/Ahli</label>
                            <input
                                name="jumlah_saksi"
                                id="jumlah_saksi"
                                type="number"
                                placeholder="0"
                                class="w-full p-2 rounded focus:outline-none"
                            />
                        </div>
                    </section>
                    <nav class="mt-4 flex flex-wrap gap-2 items-center justify-end">
                        <button type="reset" @click="create=false;errors={}" class="btn btn-outline-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </nav>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
