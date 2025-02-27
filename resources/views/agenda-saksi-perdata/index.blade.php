
<x-user-layout>
    <section class="mx-auto w-full lg:max-w-[70%] py-8" x-data='{ form: false }'>
        
        <h1>Agenda Saksi Perdata</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus culpa repudiandae amet tempora, nisi facere ipsum modi nostrum inventore debitis?</p>
      
        <nav class="flex items-center justify-end mb-4">
            <button type="button" class="btn btn-success font-bold" @click="form=true">Hadiri Agenda</button>
        </nav>
        

        @if (!isset($perkaras) || $perkaras->isEmpty())
            <div class="alert alert-warning">
                Tidak Ada Perkara Yang Di temukan
            </div>
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


    

        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-20" x-show="form" x-transition>
            <div class="px-4 py-8 w-[60%]" @click.outside="form=false">
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="md:col-span-2 bg-white p-6 rounded shadow">
                        <h2 class="text-2xl font-semibold mb-4">Informasi Jadwal Sidang</h2>
                        <ul class="space-y-2 mb-6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Jenis Pidana</td>
                                        <td class="pl-4">: <b>Pidana</b></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Perkara</td>
                                        <td class="pl-4">: <b>ABC/2324/uysdu</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </ul>
                        <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="font-medium">Connect with</p>
                        </div>
                        <div class="flex space-x-4">
                            <!-- Ganti '#' dengan link media sosial -->
                            <a href="#" class="text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><!-- Icon --> </svg>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><!-- Icon --> </svg>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><!-- Icon --> </svg>
                            </a>
                        </div>
                        </div>
                        <!-- Map (Placeholder) -->
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded">
                        <span class="text-gray-500">Map Goes Here</span>
                        </div>
                    </div>
                    <div class="bg-green-600 p-6 rounded shadow">
                        <h2 class="text-2xl font-semibold text-white mb-4">Book a Court Session</h2>
                        <form class="space-y-4" x-data="{ pihak: '' }">
                            <select class="custom-select w-full">
                                <option selected hidden>Pilih Jenis Pidana</option>
                                <option value="perdata">Perdata</option>
                                <option value="pidana">Pidana</option>
                            </select>
                            <select class="custom-select w-full">
                                <option selected hidden>Pilih Nomor Perkara</option>
                                <option value="perdata">Abc/123/nsmd</option>
                                <option value="pidana">YOG/67/jsdb</option>
                            </select>
                            <select class="custom-select w-full" x-model="pihak">
                                <option selected hidden>Pilih Jenis Pihak</option>
                                <option value="perorangan">Perorangan</option>
                                <option value="badan_hukum">Badan Hukum</option>
                                <option value="pengacara">Pengacara</option>
                            </select>
                            <input class="w-full" type="text" placeholder="Masukan nama badan" x-show="pihak=='badan_hukum'">
                            <input
                                type="text"
                                placeholder="Nama"
                                class="w-full p-2 rounded focus:outline-none"
                            />
                            <input
                                type="text"
                                placeholder="Nomor Telepon"
                                class="w-full p-2 rounded focus:outline-none"
                            />
                            <input
                            type="date"
                            id="myDate"
                            class="w-full p-2 rounded focus:outline-none"
                            />
                            <nav class="flex items-center gap-2 justify-end flex-wrap">
                                <button
                                    @click="form=false"
                                    type="reset"
                                    class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800"
                                >
                                    Hadiri Agenda
                                </button>
                            </nav>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const dateInput = document.getElementById('myDate');
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const yyyy = today.getFullYear();
                // Format ISO untuk input type="date"
                dateInput.value = `${yyyy}-${mm}-${dd}`;
            });
        </script>

    </section>
</x-user-layout>
