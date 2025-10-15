<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
     protected $table = 'books';

    // private $books = [
    //     //multi dimensional array
    //     [
    //         'title' => 'Pulang',
    //         'description' => 'Petualangan seorang pemuda yang kembali ke desa kelahirannya',
    //         'price' => 40000,
    //         'stock' => 15,
    //         'cover_photo' => 'pulang.jpg',
    //         'genre_id' => 1,
    //         'author_id' => 1
        
    //     ],
    //     [
    //         'title' => 'Sebuah Seni Untuk Bersikap Bodo Amat',
    //         'description' => 'Buku yang membahas tentang kehidupan dan filosofi hidup seseorang',
    //         'price' => 25000,
    //         'stock' => 5,
    //         'cover_photo' => 'sebuah_seni.jpg',
    //         'genre_id' => 2,
    //         'author_id' => 2
        
    //     ],
    //     [
    //         'title' => 'Warhammer 40k',
    //         'description' => 'Perang galaksi tanpa akhir yang penuh kengerian',
    //         'price' => 100000,
    //         'stock' => 40,
    //         'cover_photo' => 'wr40k.jpg',
    //         'genre_id' => 3,
    //         'author_id' => 3
        
    //     ],
    // ];
    // public function getBooks(){
    //     return $this->books;
    // }
       // Relasi ke Genre
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Relasi ke Author
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
