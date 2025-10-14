<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Genres</title>
</head>
<body>
    <h1>Ini adalah halaman genre buku</h1>
       @foreach ($genres as $genre)
        <ul>
            <li><strong>Nama:</strong> {{ $genre['name'] }}</li>
            <li><strong>Deskripsi:</strong> {{ $genre['description'] }}</li>
            
        </ul>
    @endforeach
</body>
</html>