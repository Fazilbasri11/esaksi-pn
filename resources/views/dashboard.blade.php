<x-app-layout>
<style>
        .chip {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
            color: white;
        }
        .chip-green {
            background-color: green;
        }
        .chip-red {
            background-color: red;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="{ edit: null }">

            <div class="flex items-center justify-end gap-2 mb-2">
                <button class="btn btn-success" onclick="document.getElementById('dialog-form').showModal()">Create Perkara</button>
            </div>

            
            @if (!isset($perkaras) || $perkaras->isEmpty())
                <div class="alert alert-warning">Not Found</div>
            @else
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <td>#</td>
                            <td>Jenis</td>
                            <td>No Perkara</td>
                            <td>Status</td>
                            <td align="right" width="180px">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perkaras as $index => $perkara)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $perkara->jenis }}</td>
                            <td>{{ $perkara->no }}</td>
                            <td>
                                <div class="flex items-center">
                                    @if ($perkara->status == 1)
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                        <span class="text-green-700">Aktif</span>
                                    @else
                                        <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                        <span class="text-red-700">Tidak Aktif</span>
                                    @endif
                                </div>
                            </td>
                            <td align="right" width="180px">
                                <button type="button" class="btn btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPerkaraModal"
                                    @click="edit = {{ $perkara->toJson() }}">
                                    Edit
                                </button>
                                <form class="inline-flex" action="{{ route('perkara.remove', $perkara->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif



         <!-- Modal -->
        <div class="modal fade" id="editPerkaraModal" tabindex="-1" aria-labelledby="editPerkaraLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPerkaraLabel">Edit Perkara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" x-bind:action="edit ? ('/perkara/' + edit.id) : '#'" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Perkara</label>
                                <select name="jenis" id="" class="block w-full" x-model="edit?.jenis">
                                    <option value="perdata">Perdata</option>
                                    <option value="pidana">Pidana</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="no" class="form-label">Nomor</label>
                                <input type="text" class="form-control" id="no" name="no" x-model="edit?.no || ''" required>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" x-model="edit?.status">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



            <!-- Dialog -->
            <dialog id="dialog-form" class="p-6 bg-white rounded-lg shadow-lg w-96">
                <form method="post" action="{{ route('perkara-create') }}">
                    @csrf
                    <h2 class="text-xl font-semibold mb-4">Formulir</h2>
              
                    <label class="block mb-2">
                        <span class="text-gray-700">Jenis Pidana</span>
                        <select name="jenis" id="" class="block w-full">
                            <option value="0" style="display: none;">Pilih Jenis Perkara</option>
                            <option value="perdata">Perdata</option>
                            <option value="pidana">Pidana</option>
                        </select>
                    </label>

                    <label class="block mb-2">
                        <span class="text-gray-700">No Perkara</span>
                        <input 
                            name="no"
                            type="text" 
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300"
                            placeholder="No Perkara..."
                        >
                    </label>

                    <label class="block mb-2">
                        <span class="text-gray-700">Status Perkara</span>
                        <select name="status" id="" class="block w-full">
                            <option value="0" style="display: none;">Pilih Status Perkara</option>
                            <option value="1">Aktif</option>
                            <option value="2">Nonaktif</option>
                        </select>
                    </label>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" onclick="document.getElementById('dialog-form').close()" 
                            class="px-4 py-2 bg-gray-300 rounded-lg">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                            Kirim
                        </button>
                    </div>
                </form>
            </dialog>


        </div>
    </div>
</x-app-layout>
