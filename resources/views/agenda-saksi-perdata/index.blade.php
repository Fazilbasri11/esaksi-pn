
<x-user-layout>
    <section class="mx-auto w-full lg:max-w-[70%] py-8">
        
      
      @if (!isset($perkaras) || $perkaras->isEmpty())
                <div class="alert alert-warning">Not Found</div>
            @else
                <section class="flex flex-col gap-4">
                @foreach ($perkaras as $index => $perkara)              
                <div class="bg-gray-200 px-4 py-4">
                    <div class="mb-3">
                        <div class="mb-2 text-[1.1rem]">No Perkara : <span class="font-bold">{{ $perkara->no }}</span></div>
                        <div>
                            <div>Status Perkara</div>
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

    </section>
</x-user-layout>
