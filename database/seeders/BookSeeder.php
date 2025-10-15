<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           Book::create([
            'title' => 'Pulang',
            'description' => 'Petualangan seorang pemuda yang kembali ke desa kelahirannya.',
            'price' => 40000,
            'stock' => 15,
            'cover_photo' => 'pulang.jpg',
            'genre_id' => 1,
            'author_id' => 1,
        ]);

        Book::create([
            'title' => 'Sebuah Seni Untuk Bersikap Bodo Amat',
            'description' => 'Buku yang membahas tentang kehidupan dan filosofi hidup seseorang.',
            'price' => 25000,
            'stock' => 5,
            'cover_photo' => 'sebuah_seni.jpg',
            'genre_id' => 2,
            'author_id' => 2,
        ]);

        Book::create([
            'title' => 'Warhammer 40k',
            'description' => 'Perang galaksi tanpa akhir yang penuh kengerian.',
            'price' => 100000,
            'stock' => 40,
            'cover_photo' => 'wr40k.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ]);

        Book::create([
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'description' => 'Kisah legendaris penyihir muda yang memulai petualangan di Hogwarts.',
            'price' => 85000,
            'stock' => 20,
            'cover_photo' => 'harry_potter.jpg',
            'genre_id' => 3,
            'author_id' => 4,
        ]);

        Book::create([
            'title' => 'Laskar Pelangi',
            'description' => 'Perjuangan anak-anak Belitung untuk mendapatkan pendidikan yang layak.',
            'price' => 50000,
            'stock' => 25,
            'cover_photo' => 'laskar_pelangi.jpg',
            'genre_id' => 2,
            'author_id' => 5,
        ]);
    }
}
