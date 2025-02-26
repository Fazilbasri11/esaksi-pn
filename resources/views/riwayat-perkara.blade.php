<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section>
           

            <div class="bg-gray-200 px-4 py-4">
            <div class="mb-4">
                <p>No Perkara : <span>123abc</span></p>
                <div class="flex items-center">
                    <span class="ms-2">Status</span>
                    <div class="h-2.5 w-2.5 ms-2 rounded-full bg-green-500 me-2"></div>
                    <span class="text-green-700">Aktif</span>
                </div>
            </div>
         

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
                            <!-- <th scope="col" class="px-6 py-3">
                                Aksi
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                Amanda (Penggugat 1) (hadir)
                            </th>
                            <td class="px-6 py-4">
                                1 hadir, dari 3 akan hadir
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
                            <!-- <td class="px-6 py-4">
                                <a href="#">Edit</a>
                                <a href="#">Hapus</a>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
            
            </section>
        </div>
    </div>
</x-app-layout>