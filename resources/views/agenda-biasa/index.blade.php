
<x-user-layout>
    <section class="mx-auto w-full lg:max-w-[70%] py-8">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Jenis Perkara
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No Perkara
                    </th>
                    <th scope="col" class="px-6 py-3" align="right">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
            @if (isset($perkaras) && $perkaras)
            @foreach ($perkaras as $index => $perkara)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                <td class="px-6 py-4">
                    {{ ucfirst($perkara["jenis"]) }}
                </td>
                <td class="px-6 py-4 font-bold">
                    <span class="font-bold">{{ $perkara["no"] }}</span>
                </td>
                <td class="px-6 py-4" align="right" width="250px">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Pilih Perkara
                    </button>
                </td>
            </tr>
            @endforeach
            @else
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                <td colspan="3">
                <div>
                    Not Found
                </div>
                </td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
    </section>
</x-user-layout>