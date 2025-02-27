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


    <section class="mx-auto w-full lg:max-w-[70%] py-8 px-3" x-data="{ create: false, edit: null }">


        <h1>Dashboard</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">
            Selamat data di E-Saksi Platform Penjadwalan Agenda Sidang.
        </p>

        <nav class="flex items-center justify-end mb-4">
            <button type="button" class="btn btn-success" @click="create=true">Buat Perkara</button>
        </nav>

        <!-- Create Dialog -->
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20 z-10" x-show="create" x-transition>
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
            x-show="edit" x-transition>
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
        
        <section>
            <div class="font-bold text-[1.4rem] mb-2"> 
                Perkara
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Jenis Perkara
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nomor Perkara
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status Perkara
                            </th>
                            <th scope="col" class="px-6 py-3" align="right">
                                <div class="flex gap-2 items-center justify-end">
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($perkaras) && $perkaras)
                            @foreach ($perkaras as $index => $perkara)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ ucfirst($perkara["jenis"]) }}
                                </th>
                                <td class="px-6 py-4">
                                    <b>{{ $perkara["no"] }}</b>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($perkara->status == 1)
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                            <span class="text-green-700">Aktif</span>
                                        @else
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                            <span class="text-red-700">Tidak Aktif</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4" align="right" width="270px">
                                    <div class="flex gap-2 items-center justify-end">
                                        <button type="button" @click="edit={{$perkara}}" class="btn btn-success" title="Delete">Edit</button>
                                        <form class="inline-flex" action="{{ route('perkara.remove', $perkara->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th colspan="4">
                                <div class="flex flex-col items-center justify-center w-full py-10">
                                    <div class="flex items-center justify-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 1024 1024">
                                            <path fill="currentColor" d="M1022.98 509.984L905.475 102.895c-3.84-13.872-16.464-23.472-30.848-23.472H139.283c-14.496 0-27.184 9.744-30.944 23.777L.947 489.552c-1.984 7.504-1.009 15.007 1.999 21.536C1.218 516.88.003 522.912.003 529.264v351.312c0 35.343 28.656 64 64 64h896c35.343 0 64-28.657 64-64V529.264c0-1.712-.369-3.329-.496-5.008c.832-4.592.816-9.44-.527-14.272m-859.078-366.56l686.369-.001l93.12 321.84H645.055c-1.44 76.816-55.904 129.681-133.057 129.681s-130.624-52.88-132.064-129.68H74.158zm796.097 737.151H64.001V529.263h263.12c27.936 80.432 95.775 129.68 184.879 129.68s157.936-49.248 185.871-129.68h262.128z"/>
                                        </svg>
                                    </div>
                                    <div class="text-[1.1rem]">
                                        Data Not Found
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

    </section>
</x-app-layout>
