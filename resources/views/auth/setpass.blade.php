<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setel Kata Sandi</title>
</head>
<body>
    <h1>Buat Kata Sandi Baru</h1>
    <form method="POST" action="{{ route('anggota.setPassword', ['token' => $token, 'email' => $email]) }}">
        @csrf
        <label for="password">Kata Sandi Baru</label>
        <input type="password" name="password" id="password" required>
        
        <label for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
        
        <button type="submit">Setel Kata Sandi</button>
    </form>
</body>
</html>
