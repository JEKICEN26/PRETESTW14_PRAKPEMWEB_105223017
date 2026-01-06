<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('LabLoan Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi -->
            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-4 mb-4 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-200 text-red-800 p-4 mb-4 rounded">{{ session('error') }}</div>
            @endif

            <!-- Daftar Barang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Inventaris</h3>
                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Nama Barang</th>
                            <th class="p-2 border">Deskripsi</th>
                            <th class="p-2 border">Kategori</th> <!-- Header Kategori -->
                            <th class="p-2 border">Stok</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr class="text-center">
                            <!-- Nama -->
                            <td class="p-2 border">{{ $item->name }}</td>
                            
                            <!-- Deskripsi -->
                            <td class="p-2 border">{{ $item->description }}</td>
                            
                            <!-- Kategori (Menggunakan Null Coalescing ?? jika kategori dihapus/null) -->
                            <td class="p-2 border">{{ $item->category->name ?? '-' }}</td>
                            
                            <!-- Stok -->
                            <td class="p-2 border font-bold">{{ $item->stock }}</td>
                            
                            <!-- Tombol Aksi -->
                            <td class="p-2 border">
                                @if($item->stock > 0)
                                    <form action="{{ route('loan.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                            Pinjam
                                        </button>
                                    </form>
                                @else
                                    <span class="text-red-500 font-bold text-sm">Habis</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Daftar Peminjaman Saya -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Peminjaman Saya</h3>
                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Barang</th>
                            <th class="p-2 border">Tgl Pinjam</th>
                            <th class="p-2 border">Tgl Kembali</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myLoans as $loan)
                        <tr class="text-center">
                            <td class="p-2 border">{{ $loan->item->name }}</td>
                            <td class="p-2 border">{{ $loan->borrow_date }}</td>
                            <td class="p-2 border">{{ $loan->return_date ?? '-' }}</td>
                            <td class="p-2 border">
                                <span class="{{ $loan->status == 'returned' ? 'text-green-600' : 'text-yellow-600' }} font-bold">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="p-2 border">
                                @if($loan->status == 'borrowed')
                                    <form action="{{ route('loan.return', $loan->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Kembalikan</button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-sm">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>