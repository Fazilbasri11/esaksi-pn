<x-app-layout>
<style>
    .chip {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 14px;
        font-weight: bold;
        color: white;
    }
    .chip-green {
        background-color: green;
    }
    .chip-red {
        background-color: red;
    }
</style>

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

@error('no')
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-red-500 text-white p-3 rounded mb-3">
        {{ $message }}
    </div>
@enderror


    <section class="mx-auto w-full lg:max-w-[70%] py-8 px-3" x-data="{ create: false, edit: null, form_pihak: false, remove: 0, show_detail: false, detail: 0 }">


        <h1>Dashboard</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">
            Selamat data di E-Saksi Platform Penjadwalan Agenda Sidang.
        </p>

        <nav class="flex items-center justify-end mb-4 gap-2">
            <!-- <button type="button" class="btn btn-info" @click="form_pihak=true">Tambah Pihak</button> -->
            <button type="button" class="btn btn-success" @click="create=true">Buat Perkara</button>
        </nav>


        

        <!-- DATA -->
        <section>
            <div class="font-bold text-[1.4rem] mb-2">
                Data Perkara
            </div>
            <div>
                @if (isset($perkaras) && count($perkaras) > 0)
                <div class="flex flex-col gap-4">
                    @foreach ($perkaras as $index => $perkara)
                        <div class="shadow-lg bg-white px-3 py-3">
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <table class="mb-4">
                                    <tbody>
                                        <tr>
                                            <td>Nomor Perkara</td>
                                            <td class="pl-3">
                                                <span>:</span>
                                                <b>{{ $perkara["no"] }}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td class="pl-3">
                                                <span>:</span>
                                                <!-- <select name="" id="" value="$perkara->status == 1">
                                                    <option value="true" selected>Active</option>
                                                    <option value="false">NonActive</option>
                                                </select> -->
                                                @if($perkara->status == 1)
                                                <div class="inline-flex items-center ms-2">
                                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2 inline-flex"></div>
                                                    <span class="text-green-700">Aktif</span>
                                                </div>
                                                @else
                                                <div class="inline-flex items-center ms-2">
                                                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2 inline-flex"></div>
                                                    <span class="text-red-700">Tidak Aktif</span>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <nav class="flex md:justify-end gap-2">
                                    <div class="inline-flex h-11 items-center justify-center">
                                        <button type="button" @click="edit={{$perkara}}" class="btn btn-warning" title="Delete">Edit</button>
                                    </div>
                                    <div class="inline-flex h-11 items-center justify-center">
                                        <button type="button" class="btn btn-danger" title="Delete" @click="remove={{ $perkara['id'] }}">
                                            Hapus Perkara
                                        </button>
                                    </div>
                                </nav>
                            </div>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                                                Turut Tergugat
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Jumlah Saksi Turut Tergugat
                                            </th>
                                            <th scope="col" class="px-6 py-3" align="right">
                                                <div class="flex gap-2 items-center justify-end">
                                                    Aksi
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($perkara['pihak']) && count($perkara['pihak']) > 0)
                                    @foreach ($perkara['pihak'] as $index => $pihak)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <td class="px-6 py-3">
                                            @if (isset($pihak['penggugat']) && $pihak['penggugat'])
                                                <span>{{ $pihak["penggugat"]["nama"] }}</span>
                                               <span>(Penggugat {{ $index + 1 }})</span>
                                               @if ($pihak['penggugat']['hadir'])
                                                <span>(Hadir)</span>
                                               @else
                                                <span>(Belum Hadir)</span>
                                               @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">
                                            @if (isset($pihak['penggugat']) && $pihak['penggugat'])
                                                <span>{{ count($pihak["penggugat"]["saksi"]) }}</span>
                                                <span>dari {{ $pihak["penggugat"]["jumlah_saksi"] }} akan hadir</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">
                                            @if (isset($pihak['tergugat']) && $pihak['tergugat'])
                                                <span>{{ $pihak["tergugat"]["nama"] }}</span>
                                               <span>(Tergugat {{ $index + 1 }})</span>
                                               @if ($pihak['tergugat']['hadir'])
                                                <span>(Hadir)</span>
                                               @else
                                                <span>(Belum Hadir)</span>
                                               @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">
                                            @if (isset($pihak['tergugat']) && $pihak['tergugat'])
                                                <span>{{ count($pihak["tergugat"]["saksi"]) }}</span>
                                                <span>dari {{ $pihak["tergugat"]["jumlah_saksi"] }} akan hadir</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">
                                            @if (isset($pihak['turut_tergugat']) && $pihak['turut_tergugat'])
                                                <span>{{ $pihak["turut_tergugat"]["nama"] }}</span>
                                               <span>(Turut Tergugat {{ $index + 1 }})</span>
                                               <span>(Hadir)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3">
                                            @if (isset($pihak['turut_tergugat']) && $pihak['turut_tergugat'])
                                                <span>{{ count($pihak["turut_tergugat"]["saksi"]) }}</span>
                                                <span>dari {{ $pihak["turut_tergugat"]["jumlah_saksi"] }} akan hadir</span>
                                            @endif
                                        </td>
                                        <td scope="col" class="px-6 py-3" align="right">
                                            <div class="flex gap-2 items-center justify-end">
                                                <button type="button"  @click="detail = JSON.parse(atob('{{ base64_encode(json_encode($pihak)) }}'))" class="btn btn-outline-primary">Detail</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                            <th colspan="7">
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
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center justify-center w-full py-10">
                    <div class="flex items-center justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 1024 1024">
                            <path fill="currentColor" d="M1022.98 509.984L905.475 102.895c-3.84-13.872-16.464-23.472-30.848-23.472H139.283c-14.496 0-27.184 9.744-30.944 23.777L.947 489.552c-1.984 7.504-1.009 15.007 1.999 21.536C1.218 516.88.003 522.912.003 529.264v351.312c0 35.343 28.656 64 64 64h896c35.343 0 64-28.657 64-64V529.264c0-1.712-.369-3.329-.496-5.008c.832-4.592.816-9.44-.527-14.272m-859.078-366.56l686.369-.001l93.12 321.84H645.055c-1.44 76.816-55.904 129.681-133.057 129.681s-130.624-52.88-132.064-129.68H74.158zm796.097 737.151H64.001V529.263h263.12c27.936 80.432 95.775 129.68 184.879 129.68s157.936-49.248 185.871-129.68h262.128z"/>
                        </svg>
                    </div>
                    <div class="text-[1.1rem]">
                        Tidak Ada Perkara
                    </div>
                </div>
                @endif
            </div>
        </section>


        <!-- Create Dialog -->
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20 z-10" x-show="create" :class="{ 'hidden': !create }" x-transition>
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min" @click.outside="create=false">
                <p class="font-bold text-[1.4rem]">Buat Perkara Baru</p>
                <form action="/perkara" method="POST" 
                x-data="{ jenis: '', no: '', errors: {}, submitForm() { 
                    this.errors = {}; 
                    if (!this.jenis) this.errors.jenis = 'Jenis perkara harus dipilih'; 
                    if (!this.no) this.errors.no = 'Nomor perkara harus diisi'; 
                    if (Object.keys(this.errors).length === 0) { 
                        this.$nextTick(() => this.$el.submit()); 
                    } 
                }}" 
                x-on:submit.prevent="submitForm()">
                    @csrf
                    <section>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Perkara</label>
                            <template x-if="errors.jenis">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.jenis"></p>
                            </template>
                            <select name="jenis" x-model="jenis" class="block w-full border p-2 rounded">
                                <option value="" selected hidden>Silahkan Pilih Jenis Perkara...</option>
                                <option value="perdata">Perdata</option>
                                <option value="pidana">Pidana</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no" class="form-label">Nomor Perkara</label>
                            <template x-if="errors.no">
                                <p class="text-red-500 text-sm mb-1" x-text="errors.no"></p>
                            </template>
                            <input type="text" class="form-control border p-2 rounded w-full" id="no" name="no" x-model="no" value="{{ old('no') }}" placeholder="Nomor Perkara...">
                        </div>
                    </section>
                    <nav class="mt-4 flex flex-wrap gap-2 items-center justify-end">
                        <button type="reset" @click="create=false" class="btn btn-outline-danger">Cancel</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </nav>
                </form>
            </div>
        </div>

        <!-- Edit Dialog -->
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20 z-10" 
             x-show="edit" :class="{ 'hidden': !edit }" x-transition>
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min" 
                @click.outside="edit=null">
                <p class="font-bold text-[1.4rem]">Edit Perkara</p>
                <form x-bind:action="'{{ route('perkara.disable', '') }}' + `/${edit?.id || 0}`" method="POST" x-ref="disableForm">
                    @csrf
                    @method('PATCH')
                </form>
                <form x-bind:action="`{{ route('perkara.update', '') }}/${edit?.id || 0}`" method="POST">
                    @csrf
                    @method('PATCH')
                    <section class="mb-4">
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Perkara</label>
                            <select name="jenis" id="jenis" x-model="edit?.jenis" class="block w-full">
                                <option value="" selected hidden>Silahkan Pilih Jenis Perkara...</option>
                                <option value="perdata">Perdata</option>
                                <option value="pidana">Pidana</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="no" class="form-label">Nomor Perkara</label>
                            <input type="text" x-model="edit?.no" class="form-control" id="no" name="no" placeholder="Nomor Perkara...">
                        </div>
                        <div>
                        <div>Status Perkara</div>
                        <div class="flex items-center gap-2 mb-2">
                            <div x-show="edit?.status">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2 inline-flex"></div>
                                <span class="text-green-700">Aktif</span>
                            </div>
                            <div x-show="!edit?.status">
                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2 inline-flex"></div>
                                <span class="text-red-700">Tidak Aktif</span>
                            </div>
                        </div>
                        </div>
                    </section>
                    <nav class="mt-4 flex flex-wrap gap-2 items-center justify-between">
                        <button type="button" class="btn btn-outline-warning" @click="$refs.disableForm.submit()">Nonaktifkan Perkara</button>
                        <div class="flex flex-wrap items-center justify-end gap-2">
                            <button type="reset" @click="edit=null" class="btn btn-outline-danger">Cancel</button>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </nav>
                </form>
            </div>
        </div>

        <!-- Delete Dialog -->
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20 z-10" 
             x-show="remove > 0" :class="{ 'hidden': remove == 0 }" x-transition>
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min" 
                @click.outside="remove=0">
                <p class="font-bold text-[1.4rem]">Hapus Perkara</p>
                <form x-bind:action="`{{ route('perkara.remove', '') }}/${remove || 0}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <section class="mb-4">
                        Apakah Kamu Yakin ingin menghapus Perkara?
                        <br>
                        Perkara Yang telah di hapus secara permanen tidak dapat di kembalikan lagi.
                    </section>
                    <nav class="mt-4 flex flex-wrap gap-2 items-center justify-end">
                        <button type="reset" @click="remove=0" class="btn btn-outline-success">Cancel</button>
                        <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                    </nav>
                </form>
            </div>
        </div>

      
        <!-- Detail Dialog -->
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20 z-10" 
             x-show="detail && detail !== null" :class="{ 'hidden': !detail }" x-transition>
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min" 
                @click.outside="detail=null">
                <p class="font-bold text-[1.4rem]">Detail Kehadiran</p>
                <section>
                    <div>
                        <section class="mb-4" x-show="detail.penggugat">
                            <div class="mb-2 text-[1.1rem]">Saski/Ahli Penggugat <b x-text="detail.penggugat.nama"></b></div>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    </thead>
                                    <tbody>
                                        <template x-for="item in detail.penggugat.saksi">
                                            <tr>
                                                <td class="px-6 py-3" x-text="item.pihak_menghadirkan"></td>
                                                <td class="px-6 py-3" x-text="item.pihak"></td>
                                                <td class="px-6 py-3" x-text="item.nama_badan_hukum || item.nama"></td>
                                                <td class="px-6 py-3" x-text="item.nomor_telepon"></td>
                                                <td scope="col" class="px-6 py-3" align="right">
                                                    <div class="flex gap-2 items-center justify-end">
                                                        <form :action="'/saksi/' + item.id" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" @click="confirm('Yakin ingin menghapus?') || event.preventDefault()">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section class="mb-4" x-show="detail.tergugat">
                            <div class="mb-2 text-[1.1rem]">Saski/Ahli Tergugat <b x-text="detail.tergugat.nama"></b></div>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    </thead>
                                    <tbody>
                                        <template x-for="item in detail.tergugat.saksi">
                                            <tr>
                                                <td class="px-6 py-3" x-text="item.pihak_menghadirkan"></td>
                                                <td class="px-6 py-3" x-text="item.pihak"></td>
                                                <td class="px-6 py-3" x-text="item.nama_badan_hukum || item.nama"></td>
                                                <td class="px-6 py-3" x-text="item.nomor_telepon"></td>
                                                <td scope="col" class="px-6 py-3" align="right">
                                                    <div class="flex gap-2 items-center justify-end">
                                                        <form :action="'/saksi/' + item.id" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" @click="confirm('Yakin ingin menghapus?') || event.preventDefault()">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section class="mb-4" x-show="detail.turut_tergugat">
                            <div class="mb-2 text-[1.1rem]">Saski/Ahli Turut Tergugat <b x-text="detail.turut_tergugat.nama"></b></div>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    </thead>
                                    <tbody>
                                        <template x-for="item in detail.turut_tergugat.saksi">
                                            <tr>
                                                <td class="px-6 py-3" x-text="item.pihak_menghadirkan"></td>
                                                <td class="px-6 py-3" x-text="item.pihak"></td>
                                                <td class="px-6 py-3" x-text="item.nama_badan_hukum || item.nama"></td>
                                                <td class="px-6 py-3" x-text="item.nomor_telepon"></td>
                                                <td scope="col" class="px-6 py-3" align="right">
                                                    <div class="flex gap-2 items-center justify-end">
                                                        <form :action="'/saksi/' + item.id" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" @click="confirm('Yakin ingin menghapus?') || event.preventDefault()">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section class="mb-4" x-show="detail.pemohon">
                            <div class="mb-2 text-[1.1rem]">Saski/Ahli Turut Tergugat <b x-text="detail.pemohon.nama"></b></div>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    </thead>
                                    <tbody>
                                        <template x-for="item in detail.pemohon.saksi">
                                            <tr>
                                                <td class="px-6 py-3" x-text="item.pihak_menghadirkan"></td>
                                                <td class="px-6 py-3" x-text="item.pihak"></td>
                                                <td class="px-6 py-3" x-text="item.nama_badan_hukum || item.nama"></td>
                                                <td class="px-6 py-3" x-text="item.nomor_telepon"></td>
                                                <td scope="col" class="px-6 py-3" align="right">
                                                    <div class="flex gap-2 items-center justify-end">
                                                        <form :action="'/saksi/' + item.id" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" @click="confirm('Yakin ingin menghapus?') || event.preventDefault()">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <section class="mb-4" x-show="detail.termohon">
                            <div class="mb-2 text-[1.1rem]">Saski/Ahli Turut Tergugat <b x-text="detail.termohon.nama"></b></div>
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    </thead>
                                    <tbody>
                                        <template x-for="item in detail.termohon.saksi">
                                            <tr>
                                                <td class="px-6 py-3" x-text="item.pihak_menghadirkan"></td>
                                                <td class="px-6 py-3" x-text="item.pihak"></td>
                                                <td class="px-6 py-3" x-text="item.nama_badan_hukum || item.nama"></td>
                                                <td class="px-6 py-3" x-text="item.nomor_telepon"></td>
                                                <td scope="col" class="px-6 py-3" align="right">
                                                    <div class="flex gap-2 items-center justify-end">
                                                        <form :action="'/saksi/' + item.id" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" @click="confirm('Yakin ingin menghapus?') || event.preventDefault()">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </section>
                <nav class="mt-4 flex flex-wrap gap-2 items-center justify-end">
                    <button type="reset" @click="detail=null" class="btn btn-outline-danger">Close</button>
                </nav>
            </div>
        </div>


        <!-- Form Pihak -->
        <!-- <section class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 md:pt-24 z-20 overflow-auto py-20 md:py-0" x-show="form_pihak" :class="{ 'hidden': !form_pihak }" x-transition>
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl min-h-max md:max-h-max rounded- mb-20 md:mb-0 overflow-visible"  @click.outside="form_pihak=false">
                <h2 class="text-2xl font-semibold mb-4">Tambah Pihak Menghadirkan</h2>
                <form action="#" method="POST" x-data="{ jenis: '', pihak: '', jenis_perdata: '' }" class="flex flex-col gap-3">
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
                        <label for="jenis_perdata" class="flex mb-0.5">Jenis Jenis Perdata</label>
                        <select class="custom-select w-full" id="jenis_perdata" x-model="jenis_perdata">
                            <option selected hidden value="">Pilih Jenis Perdata</option>
                            <option value="gugatan">Gugatan</option>
                            <option value="gugatan_sederhana">Gugatan Sederhana</option>
                            <option value="permohonan">Permohonan</option>
                        </select>
                    </div>
                    <div>
                        <label for="pihak" class="flex mb-0.5">Jenis Pihak</label>
                        <select class="custom-select w-full" id="pihak" name="pihak" x-model="pihak">
                            <option selected hidden value="">Pilih Pihak Menghadirkan</option>
                            <option value="tergugat">Tergugat</option>
                            <option value="penggugat">Penggugat</option>
                            <option value="turut_tergugat">Turut Tergugat</option>
                            <option value="pemohon">Pemohon</option>
                            <option value="termohon">Termohon</option>
                        </select>
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
                        <label for="jumlah_saksi_ahli" class="flex mb-0.5">Jumlah Saksi/Ahli</label>
                        <input
                            id="jumlah_saksi_ahli"
                            type="number"
                            placeholder="0"
                            class="w-full p-2 rounded focus:outline-none"
                        />
                    </div>
                    <nav class="flex flex-wrap items-center gap-2 justify-end mt-8">
                        <button @click="form_pihak=false" type="reset" type="button" class="btn btn-outline-danger">Batal</button>
                        <button
                            type="submit"
                            class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800"
                        >
                            Simapan
                        </button>
                    </nav>
                </form>
            </div>
        </section> -->



    </section>
</x-app-layout>
