<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            <nav class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <a href="/pihak-menghadirkan">
                        <button type="button" class="btn btn-secondary">Back</button>
                    </a>
                </div>
                <div></div>
            </nav>

            <section class="flex flex-col gap-2 mb-4">

                <div class="max-w-sm">
                    <label for="countries" class="block mb-0.5 text-sm font-medium text-gray-900 dark:text-white">
                        Pilih No Perkara
                    </label>
                    <select id="perkaraSelect"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        onchange="updatePath(this)">
                        <option selected hidden>Pilih No Perkara</option>
                        @if(isset($perkara_options) && $perkara_options->isNotEmpty())
                            @foreach ($perkara_options as $value)
                                <option value="{{ $value->no }}" {{ request('perkara') == $value->no ? 'selected' : '' }}>
                                    {{ $value->no }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="my-2">

                @if(isset($perkara) && $perkara)
                    <div>
                        <div>
                            Status
                        </div>
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
                @endif
                    
                @if(isset($perkara) && $perkara)
                
                    <div class="mt-8">

                        @if (!isset($pihak_menghadirkan) || $pihak_menghadirkan->isEmpty())
                        <div>Null</div>
                        @else
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Jenis Perdata
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Pihak
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Nama
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            No Telepon
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Saksi/Ahli Akan Hadir
                                        </th>
                                        <th scope="col" class="px-6 py-3" align="center">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pihak_menghadirkan as $index => $pihak)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $pihak->jenis_perdata }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ ucfirst($pihak->pihak) }} 
                                        </td>
                                        <td class="px-6 py-4">
                                            <span>
                                                {{ $pihak->nama }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $pihak->no_telp }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $pihak->jumlah_saksi }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                                        Edit
                                                </button>
                                                <form action="{{ route('pihak-menghadirkan.form') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                    @csrf
                                                    @method('DELETE') 
                                                    <input type="hidden" name="id" value="{{ $pihak->id }}">
                                                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 me-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <div class="mt-4">
                            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Tambahkan Pihak
                            </button>
                        </div>
                            
                        

                    </div>
                @else
                <div>
                    Silahkan Pilih Nomor Perkara Terlebih Dahulu
                </div>
                
                @endif

                </div>
            </section>


    


            <!-- Main modal -->
            <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Sign in to our platform
                            </h3>
                            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="px-4 md:px-5 pb-4" x-data="{ pihak: null }">
                            <form class="space-y-4" action="{{ route('pihak-menghadirkan.form', $perkara ? ['perkara' => $perkara->no] : '') }}" method="post">
                                @csrf
                                @if(isset($perkara) && $perkara)
                                    <input type="text" name="no_perkara" hidden value="{{ $perkara->no }}">
                                @endif

                                <div class="max-w-sm mx-auto">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Jenis perdata
                                    </label>
                                    <select id="countries" name="jenis_perdata" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected hidden>pilih jenis perdata</option>
                                        <option value="gugatan">Gugatan</option>
                                        <option value="gugatan_sederhana">Gugatan Sederhana</option>
                                        <option value="permohonan">permohonan</option>
                                    </select>
                                </div>
                                <div class="max-w-sm mx-auto">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Silahkan Pilih Pihak
                                    </label>
                                    <select id="countries" name="pihak" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" x-model="pihak">
                                        <option selected hidden>pilih pihak</option>
                                        <option value="tergugat">Tergugat</option>
                                        <option value="penggugat">Penggugat</option>
                                        <option value="turut_tergugat">Turut Tergugat</option>
                                        <option value="pemohon">Pemohon</option>
                                        <option value="termohon">Termohon</option>
                                    </select>
                                </div>

                                <div class="max-w-sm mx-auto" x-transition x-show="pihak && pihak !== ''">
                                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="'Masuan Nomor ' + pihak.replace(/^\w/, (c) => c.toUpperCase())"
                                    ></label>
                                    <input type="number" name="index" class="w-full" placeholder="0">
                                </div>

                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Name
                                    </label>
                                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Nana" />
                                </div>
                                <div>
                                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        No Telepon
                                    </label>
                                    <input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="0812..." />
                                </div>
                                <div>
                                    <label for="jumlah_saksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Saksi/ahli akan hadir
                                    </label>
                                    <input type="number" name="jumlah_saksi" id="jumlah_saksi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="0" />
                                </div>

                                <nav class="flex items-center justify-end gap-2">
                                    <button data-modal-hide="authentication-modal" type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 me-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                        Cancel
                                    </button>
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Add
                                    </button>
                                </nav>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 




          
  
        </div>
    </div>



    <script>
        function updatePath(select) {
            const perkaraId = select.value; 
            if (perkaraId) {
                const url = new URL(window.location);
                url.searchParams.set('perkara', perkaraId); // Set query parameter
                window.location = url.toString(); // Redirect dengan query baru
            }
        }
    </script>

</x-app-layout>
