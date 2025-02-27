<x-app-layout>
    <section class="mx-auto w-full lg:max-w-[70%] py-8 px-3" x-data="{ create: false, edit: null, form_pihak: false, remove: 0 }">
        <h1>Riwayat Perkara</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">
            Riwayat Perkara yang tidak aktif atau berlalu. <br>Ini menampung semua data riwayat perkara yang telah selesai atau tidak aktif.
        </p>

        <section>
            <div class="font-bold text-[1.4rem] mb-2">
                Data Perkara
            </div>
            <div>
                @if (isset($perkaras) && count($perkaras) > 0)
                <div class="flex flex-col gap-4">
                    @foreach ($perkaras as $index => $perkara)
                        <div class="shadow-lg bg-white px-3 py-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 mb-4">
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
                                                <!-- <select name="status">
                                                    <option value="1" @selected($perkara->status == 1)>Aktif</option>
                                                    <option value="0" @selected($perkara->status == 0)>Tidak Aktif</option>
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
                                    <button type="button" class="inline-flex h-10 items-center btn btn-danger" title="Delete" @click="remove={{ $perkara['id'] }}">
                                        Hapus Perkara
                                    </button>
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
                                            <!-- <th scope="col" class="px-6 py-3" align="right">
                                                <div class="flex gap-2 items-center justify-end">
                                                    Aksi
                                                </div>
                                            </th> -->
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
                                               <span>(Hadir)</span>
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
                                               <span>(Hadir)</span>
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
                                        <!-- <td scope="col" class="px-6 py-3" align="right">
                                            <div class="flex gap-2 items-center justify-end">
                                                Aksi
                                            </div>
                                        </td> -->
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


    </section>
</x-app-layout>