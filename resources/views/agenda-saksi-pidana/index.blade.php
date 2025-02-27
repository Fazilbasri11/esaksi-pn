<x-user-layout>
    <section class="mx-auto w-full lg:max-w-[70%] py-8 px-3" x-data='{ form: false }'>

        <h1>Agenda Saksi Pidana</h1>
        <p class="text-[1.1rem] lg:max-w-[700px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus culpa repudiandae amet tempora, nisi facere ipsum modi nostrum inventore debitis?</p>

        <nav class="flex items-center justify-between mb-4">
            <a type="button" class="btn btn-secondary font-bold" href="/">Home</a>
            <button type="button" class="btn btn-success font-bold" @click="form=true">Hadiri Agenda</button>
        </nav>
            
    
        <div class="alert alert-warning">
            Tidak Ada Agenda Yang Di temukan
        </div>


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