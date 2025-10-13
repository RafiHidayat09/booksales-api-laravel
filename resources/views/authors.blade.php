<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Authors</title>
</head>
<body>
       <h1>Ini adalah halaman Author</h1>
         @foreach ($authors as $author)
        <div class="author-card">
            <img src="{{ asset('images/' . $author['photo']) }}" alt="{{ $author['name'] }}">
            <div class="author-info">
                <h3>{{ $author['name'] }}</h3>
                <p>{{ $author['bio'] }}</p>
            </div>
        </div>
    @endforeach
</body>
</html>