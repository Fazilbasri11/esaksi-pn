@if (!isset($perkara->pihak_menghadirkan) || $perkara->pihak_menghadirkan->isEmpty())
                    <div>
                        Tidak Ada Data
                    </div>
                    @else
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
                                        Jumlah Saksi
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
                                        {{ $pihak->nama }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $pihak->jumlah_saksi }}
                                    </td>
                                    <td class="px-6 py-4">
                                        Rizki (tergugat 1) (hadir)
                                    </td>
                                    <td class="px-6 py-4">
                                        
                                    </td>
                                    <td class="px-6 py-4">
                                        Pemda Aceh Jaya (hadir)    
                                    </td>
                                    <td class="px-6 py-4">

                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#">Edit</a>
                                        <a href="#">Hapus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif