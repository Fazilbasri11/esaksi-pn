<x-app-layout>
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

    <section class="mx-auto w-full lg:max-w-[70%] py-8 px-3" 
        x-data="{ create: false, update: null }"
    >

        <h1>Pihak Menghadirkan</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">
            Selamat data di E-Saksi Platform Penjadwalan Agenda Sidang.
        </p>

        <nav class="flex items-center justify-end mb-4 gap-2">
            <button type="button" class="btn btn-success" @click="create=true">Tambah Pihak</button>
        </nav>

    
        <section>
            <p class="font-bold text-[1.2rem] mb-2">Data Pihak Menghadirkan</p>
            <section class="relative overflow-x-auto mb-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Jenis Perdata
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Pihak
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nomor Telepon
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Saksi
                            </th>
                            <th scope="col" class="px-6 py-3" align="right">
                                <div class="flex gap-2 items-center justify-end">
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (isset($pihaks) && count($pihaks) > 0)
                        @foreach ($pihaks as $index => $pihak)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-3">{{ ucfirst($pihak['jenis_perdata']) }}</td>
                            <td class="px-6 py-3">{{ ucfirst($pihak['pihak']) }}</td>
                            <td class="px-6 py-3">{{ $pihak['nama'] }}</td>
                            <td class="px-6 py-3">{{ $pihak['no_telp'] }}</td>
                            <td class="px-6 py-3">{{ $pihak['jumlah_saksi'] }}</td>
                            <td scope="col" class="px-6 py-3" align="right">
                                <div class="flex gap-2 items-center justify-end">
                                    <button type="button" class="btn btn-warning" @click="update={{$pihak}}">Edit</button>
                                    <form action="{{ route('pihak-menghadirkan.remove', ['id' => $pihak['id']]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th colspan="6">
                                <div class="flex flex-col items-center justify-center w-full py-10">
                                    <div class="flex items-center justify-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 1024 1024">
                                            <path fill="currentColor" d="M1022.98 509.984L905.475 102.895c-3.84-13.872-16.464-23.472-30.848-23.472H139.283c-14.496 0-27.184 9.744-30.944 23.777L.947 489.552c-1.984 7.504-1.009 15.007 1.999 21.536C1.218 516.88.003 522.912.003 529.264v351.312c0 35.343 28.656 64 64 64h896c35.343 0 64-28.657 64-64V529.264c0-1.712-.369-3.329-.496-5.008c.832-4.592.816-9.44-.527-14.272m-859.078-366.56l686.369-.001l93.12 321.84H645.055c-1.44 76.816-55.904 129.681-133.057 129.681s-130.624-52.88-132.064-129.68H74.158zm796.097 737.151H64.001V529.263h263.12c27.936 80.432 95.775 129.68 184.879 129.68s157.936-49.248 185.871-129.68h262.128z"/>
                                        </svg>
                                    </div>
                                    <div class="text-[1.1rem]">
                                        Tidak Ada Data
                                    </div>
                                </div>
                            </th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </section>

            <!-- <p class="font-bold text-[1.2rem] mb-2">Data Saksi/Ahli</p>
            <section class="relative overflow-x-auto mb-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Agenda
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jenis Pidana
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nomor Perkara
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Pihak Menghadirkan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Pihak
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nomor Telepon
                            </th>
                            <th scope="col" class="px-6 py-3" align="right">
                                <div class="flex gap-2 items-center justify-end">
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (isset($saksis) && count($saksis) > 0)
                        @foreach ($saksis as $index => $saksi)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-6 py-3">{{ ucfirst($saksi['agenda']) }}</td>
                            <td class="px-6 py-3">{{ ucfirst($saksi['jenis_pidana']) }}</td>
                            <td class="px-6 py-3">{{ $saksi['no_perkara'] }}</td>
                            <td class="px-6 py-3">{{ ucfirst($saksi['pihak_menghadirkan']) }}</td>
                            <td class="px-6 py-3">{{ $saksi['pihak'] }}</td>
                            <td class="px-6 py-3"><b>{{ $saksi['nama_badan_hukum'] }}</b> {{ $saksi['nama'] }}</td>
                            <td class="px-6 py-3">{{ $saksi['nomor_telepon'] }}</td>
                            <td scope="col" class="px-6 py-3" align="right">
                                <div class="flex gap-2 items-center justify-end">
                                    <form action="{{ route('saksi.remove', ['id' => $saksi['id']]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th colspan="8">
                                <div class="flex flex-col items-center justify-center w-full py-10">
                                    <div class="flex items-center justify-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 1024 1024">
                                            <path fill="currentColor" d="M1022.98 509.984L905.475 102.895c-3.84-13.872-16.464-23.472-30.848-23.472H139.283c-14.496 0-27.184 9.744-30.944 23.777L.947 489.552c-1.984 7.504-1.009 15.007 1.999 21.536C1.218 516.88.003 522.912.003 529.264v351.312c0 35.343 28.656 64 64 64h896c35.343 0 64-28.657 64-64V529.264c0-1.712-.369-3.329-.496-5.008c.832-4.592.816-9.44-.527-14.272m-859.078-366.56l686.369-.001l93.12 321.84H645.055c-1.44 76.816-55.904 129.681-133.057 129.681s-130.624-52.88-132.064-129.68H74.158zm796.097 737.151H64.001V529.263h263.12c27.936 80.432 95.775 129.68 184.879 129.68s157.936-49.248 185.871-129.68h262.128z"/>
                                        </svg>
                                    </div>
                                    <div class="text-[1.1rem]">
                                        Tidak Ada Data
                                    </div>
                                </div>
                            </th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </section> -->

        </section>

        
        
        <!-- Create Dialog -->
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20 z-10" x-show="create" :class="{ 'hidden': !create }" x-transition>
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min" @click.outside="create=false">
                <p class="font-bold text-[1.4rem]">Tambah Pihak Baru</p>
                <form action="{{ route('pihak-menghadirkan.form') }}" method="POST"
                    x-data="{ no_perkara: '', jenis_perdata: '', pihak: '', nama: '', nomor_telepon: '', errors: {}, submitForm() { 
                        this.errors = {};
                        if (!this.no_perkara) this.errors.no_perkara = 'Silahkan Pilih Nomor Perkara Terlebih Dahulu.'; 
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
                            <label for="no_perkara" class="flex mb-0.5">Nomor Perkara</label>
                            <template x-if="errors?.no_perkara">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.no_perkara"></p>
                            </template>
                            <select class="custom-select w-full" id="no_perkara" name="no_perkara" x-model="no_perkara">
                                <option selected hidden>Pilih Nomor Perkara...</option>
                                @if (isset($perkaras) && count($perkaras) > 0)
                                @foreach ($perkaras as $index => $perkara)
                                <option value="{{ $perkara->no }}">{{ $perkara->no }}</option> 
                                @endforeach
                                @endif
                            </select>
                        </div>
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

        <!-- Edit Dialog -->
        <div class="fixed inset-0 flex justify-center bg-gray-400/20 pt-20 z-10"
            x-show="update !== null" x-transition>
            <div class="w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min"
                @click.outside="update=null">
                <p class="font-bold text-[1.4rem]">Ubah Data Pihak</p>
                <form x-bind:action="`{{ route('pihak-menghadirkan.update', '') }}/${update?.id || 0}`" method="POST"
                    x-data="{
                        errors: {}, 
                        submitForm() { 
                            this.errors = {}; 
                            if (!update.jenis_perdata) this.errors.jenis_perdata = 'Silahkan Pilih Jenis Perdata Terlebih Dahulu.'; 
                            if (!update.pihak) this.errors.pihak = 'Silahkan Pilih Pihak Terlebih Dahulu.'; 
                            if (!update.nama) this.errors.nama = 'Silahkan Masukan Nama.'; 
                            if (!update.no_telp) this.errors.nomor_telepon = 'Silahkan Masukan Nomor Telepon.'; 

                            if (Object.keys(this.errors).length === 0) { 
                                this.$nextTick(() => this.$el.submit()); 
                            }
                        }
                    }" 
                    x-on:submit.prevent="submitForm()">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" x-model="update.id">
                    <section class="flex flex-col gap-3">
                        <div>
                            <label for="jenis_perdata" class="flex mb-0.5">Jenis Perdata</label>
                            <template x-if="errors.jenis_perdata">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.jenis_perdata"></p>
                            </template>
                            <select class="custom-select w-full" id="jenis_perdata" name="jenis_perdata" x-model="update.jenis_perdata">
                                <option selected hidden>Pilih Jenis Perdata...</option>
                                <option value="gugatan">Gugatan</option> 
                                <option value="gugatan_sederhana">Gugatan Sederhana</option> 
                                <option value="permohonan">Permohonan</option>
                            </select>
                        </div>
                        <div>
                            <label for="pihak" class="flex mb-0.5">Pihak</label>
                            <template x-if="errors.pihak">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.pihak"></p>
                            </template>
                            <select class="custom-select w-full" id="pihak" name="pihak" x-model="update.pihak">
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
                            <template x-if="errors.nama">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.nama"></p>
                            </template>
                            <input x-model="update.nama" name="nama" id="nama" type="text" placeholder="Nama..."
                                class="w-full p-2 rounded border border-gray-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label for="nomor_telepon" class="flex mb-0.5">Nomor Telepon</label>
                            <template x-if="errors.nomor_telepon">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.nomor_telepon"></p>
                            </template>
                            <input name="nomor_telepon" x-model="update.no_telp" id="nomor_telepon" type="text" placeholder="0812..."
                                class="w-full p-2 rounded border border-gray-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label for="jumlah_saksi" class="flex mb-0.5">Jumlah Saksi/Ahli</label>
                            <input x-model="update.jumlah_saksi" name="jumlah_saksi" id="jumlah_saksi" type="number" placeholder="0"
                                class="w-full p-2 rounded border border-gray-300 focus:ring focus:ring-blue-200">
                        </div>
                    </section>
                    <nav class="mt-4 flex flex-wrap gap-2 items-center justify-end">
                        <button type="reset" @click="update=null;errors={}" class="btn btn-outline-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </nav>
                </form>
            </div>
        </div>

        

    </section>
</x-app-layout>
