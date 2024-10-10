@extends('master.main')
@section('title', 'Divisi')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 mb-4">Tabel Divisi</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Optional header content -->
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tenggat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dtDivisi as $item)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td class="text-center"><br>{{ $item->nama }}</td>
    <td class="text-left" style="width: 30%;">
        <div class="form-group">
            <input type="time" name="tenggat" id="tenggat-{{$item->id}}" class="form-control" value="{{$item->tenggat}}" placeholder="tenggat" style="width: 50%;" required>
        </div>
    </td>
    <td class="text-center" style="width: 15%;">
        <br>
        <button id="toggleButton-{{ $item->id }}" class="btn btn-sm btn-primary toggle-button" data-id="{{ $item->id }}" data-status="{{ $item->aktifasi ? 'active' : 'inactive' }}">
            <i class="fas {{ $item->aktifasi ? 'fa-check' : 'fa-times' }}"></i> {{ $item->aktifasi ? 'Aktif' : 'Nonaktif' }}
        </button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Menunggu sampai dokumen siap
    $(document).ready(function() {// Untuk setiap elemen dengan kelas .toggle-button
        $('.toggle-button').each(function() {
            var button = $(this);// Menyimpan elemen tombol saat ini
            var id = button.data('id');// Mendapatkan data id dari tombol

            // Mengirim permintaan AJAX untuk mendapatkan status saat ini dari server
            $.ajax({
                url: "{{ route('get-status') }}", // URL untuk permintaan GET status
                method: 'GET',// Metode HTTP untuk permintaan
                data: {
                    id: id// Data yang dikirim ke server (id divisi)
                },
                success: function(response) {
                    /// Mengubah tampilan tombol berdasarkan status yang diterima dari server
                    var icon = response.status === 'active' ? 'fa-check' : 'fa-times';
                    var buttonText = response.status === 'active' ? 'Aktif' : 'Nonaktif';
                    var buttonClass = response.status === 'active' ? 'btn-primary' : 'btn-danger';

                    button.data('status', response.status);// Mengatur data status tombol
                    button.html('<i class="fas ' + icon + '"></i> ' + buttonText);// Mengubah HTML tombol dengan icon dan teks baru
                    button.removeClass('btn-primary btn-danger').addClass(buttonClass);// Mengubah kelas tombol
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });
//======================================//
         // Menambahkan event listener untuk klik pada tombol dengan kelas .toggle-button
        $(document).ready(function() {
    $('.toggle-button').click(function() {
        var button = $(this);// Menyimpan elemen tombol yang diklik
        var id = button.data('id');// Mendapatkan data id dari tombol
        var currentStatus = button.data('status');// Mendapatkan status saat ini dari tombol
        var newStatus = currentStatus === 'active' ? 'inactive' : 'active';// Menentukan status baru berdasarkan status saat ini
        var icon = newStatus === 'active' ? 'fa-check' : 'fa-times';// Icon baru berdasarkan status baru
        var buttonText = newStatus === 'active' ? 'Aktif' : 'Nonaktif';// Teks tombol baru berdasarkan status baru
        var buttonClass = newStatus === 'active' ? 'btn-primary' : 'btn-danger';// Kelas tombol baru berdasarkan status baru
        var tenggatValue = $('#tenggat-' + id).val();// Kelas tombol baru berdasarkan status baru
        
        // Mengirim permintaan AJAX untuk memperbarui status di server
        $.ajax({
            url: "{{ route('toggle-status') }}",// URL untuk permintaan POST toggle status
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',// Menyertakan token CSRF untuk keamanan
                id: id,
                status: newStatus,// Status baru yang dikirim ke server
                tenggat: tenggatValue// Nilai tenggat waktu yang dikirim ke server
            },
            success: function(response) {
                // Mengubah tampilan tombol dan data berdasarkan respons server
                button.data('status', newStatus);// Mengatur data status tombol
                button.html('<i class="fas ' + icon + '"></i> ' + buttonText);// Mengubah HTML tombol dengan icon dan teks baru
                button.removeClass('btn-primary btn-danger').addClass(buttonClass);// Mengubah kelas tombol

                // Show toast message
                toastr.success(response.message);// Menampilkan pesan sukses menggunakan toastr
            },
            error: function(xhr, status, error) {
                // Menangani kesalahan
                console.error(xhr.responseText);
            }
        });
    });
});

    });
</script>

@endsection