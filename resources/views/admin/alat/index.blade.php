@extends('home.submain')
@section('title', 'Alat')
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="mb-2 mb-4 text-gray-800 h3">Tabel Alat</h1>


        <!-- DataTales Example -->
        <div class="mb-4 shadow card">
            <div class="py-3 card-header">
                <a href="{{ route('FormAlat') }}" class="ml-auto btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                    Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Stok</th>

                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dtAlat as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_alat }}</td>
                                    <td>{{ $item->stok }}</td>

                                    <td class="text-center" style="width: 15%;">
                                        <form onsubmit="return confirm('Apakah Anda Yakin Menghapus?');"
                                            action="{{ route('hapusalat', $item->id_alat) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            @php $id_alat = Crypt::encrypt($item->id_alat); @endphp
                                            <a href="{{ route('FindId', $id_alat) }}" {{ $item->id_alat }}
                                                class="btn btn-sm btn-primary" ><i class="fas fa-edit"></i> Edit</a>

                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash-alt"></i> Hapus</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    {{-- sweet alert --}}
    @include('sweetalert::alert')

@endsection
