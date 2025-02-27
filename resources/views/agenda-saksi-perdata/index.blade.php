
<x-user-layout>
    <section class="mx-auto w-full lg:max-w-[70%] py-8 px-3" x-data='{ form: false }'>
        
        <h1>Agenda Saksi Perdata</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus culpa repudiandae amet tempora, nisi facere ipsum modi nostrum inventore debitis?</p>
      
        <nav class="flex items-center justify-between mb-4">
            <a type="button" class="btn btn-secondary font-bold" href="/">Home</a>
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


      

    

        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center bg-gray-400/20 pt-24 z-20" x-show="form" x-transition x-data="{ no_perkara: '', jenis:'' }">
            <div class="w-[90%] sm:w-[90%] md:w-[70%] lg:w-[50%] xl:w-[40%] min-w-[300px] px-4 py-4 bg-white shadow-xl max-h-min rounded-md"  @click.outside="form=false"> 
                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <div>
                        <h2 class="text-2xl font-semibold mb-4">Informasi Perkara</h2>

                        <div class="flex flex-col items-center justify-center w-full py-10" x-show="!no_perkara && !jenis">
                            <div class="flex items-center justify-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 1024 1024">
                                    <path fill="currentColor" d="M1022.98 509.984L905.475 102.895c-3.84-13.872-16.464-23.472-30.848-23.472H139.283c-14.496 0-27.184 9.744-30.944 23.777L.947 489.552c-1.984 7.504-1.009 15.007 1.999 21.536C1.218 516.88.003 522.912.003 529.264v351.312c0 35.343 28.656 64 64 64h896c35.343 0 64-28.657 64-64V529.264c0-1.712-.369-3.329-.496-5.008c.832-4.592.816-9.44-.527-14.272m-859.078-366.56l686.369-.001l93.12 321.84H645.055c-1.44 76.816-55.904 129.681-133.057 129.681s-130.624-52.88-132.064-129.68H74.158zm796.097 737.151H64.001V529.263h263.12c27.936 80.432 95.775 129.68 184.879 129.68s157.936-49.248 185.871-129.68h262.128z"/>
                                </svg>
                            </div>
                            <div class="text-[1.1rem]">
                                Data Not Found
                            </div>
                        </div>
                        <table x-show="no_perkara !== '' || jenis !== ''">
                            <tbody>
                                <tr>
                                    <td>Jenis Pidana</td>
                                    <td class="pl-4">: <b class="ms-2" x-text="jenis"></b></td>
                                </tr>
                                <tr>
                                    <td>Nomor Perkara</td>
                                    <td class="pl-4">: <b class="ms-2" x-text="no_perkara"></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <form class="space-y-4" x-data="{ pihak: '' }">
                            <select class="custom-select w-full" x-model="jenis">
                                <option selected hidden value="">Pilih Jenis Pidana</option>
                                <option value="perdata">Perdata</option>
                                <option value="pidana">Pidana</option>
                            </select>
                            <select class="custom-select w-full" x-model="no_perkara">
                                <option selected hidden>Pilih Nomor Perkara</option>
                                @if (isset($perkaras) && $perkaras)
                                    @foreach ($perkaras as $index => $perkara)
                                        <option value="{{ $perkara['no'] }}">{{ $perkara['no'] }}</option>   
                                    @endforeach
                                @endif
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
                        </form>
                    </div>
                </div>
                <nav class="flex flex-wrap items-center gap-2 justify-end mt-8">
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
