
<x-app-layout>
    <div class="py-12 px-3">
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
    </div>
</x-app-layout>
