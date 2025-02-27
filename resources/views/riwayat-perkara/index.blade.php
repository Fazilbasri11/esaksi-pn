<x-app-layout>
    <div class="py-12 px-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-col gap-2 px-2">
                <div class="text-[1.6rem] font-bold">Riwayat Perkara</div>
                <div>Riwayat Perkara yang telah ada atau berlalu. <br>Ini menampung semua data riwayat perkara yang telah selesai atau tidak aktif.</div>
            </div>

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
                            <div class="flex items-center">
                                @if ($perkara->status == 1)
                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                    <span class="text-green-700">Aktif</span>
                                @else
                                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                    <span class="text-red-700">Tidak Aktif</span>
                                @endif
                            </div>
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
                                    <!-- <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th> -->
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
                                        <!-- <td class="px-6 py-4">
                                            <a href="#">Edit</a>
                                            <a href="#">Hapus</a>
                                        </td> -->
                                    </tr>
                                @endforeach
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
    </div>
</x-app-layout>