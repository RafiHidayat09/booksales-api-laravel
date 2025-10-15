<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Author::create([
            'name' => 'Tere Liye',
            'photo' => 'tere_liye.jpg',
            'bio' => 'Penulis novel populer asal Indonesia dengan gaya bahasa yang ringan namun penuh makna.'
        ]);

        Author::create([
            'name' => 'Mark Manson',
            'photo' => 'mark_manson.jpg',
            'bio' => 'Penulis asal Amerika Serikat yang dikenal lewat buku pengembangan diri yang realistis dan jujur.'
        ]);

        Author::create([
            'name' => 'Games Workshop',
            'photo' => 'games_workshop.jpg',
            'bio' => 'Perusahaan dan tim kreatif di balik dunia fiksi sains Warhammer 40k yang epik.'
        ]);

        Author::create([
            'name' => 'J.K. Rowling',
            'photo' => 'jk_rowling.jpg',
            'bio' => 'Penulis Inggris yang menciptakan seri legendaris Harry Potter dan menginspirasi jutaan pembaca.'
        ]);

        Author::create([
            'name' => 'Andrea Hirata',
            'photo' => 'andrea_hirata.jpg',
            'bio' => 'Penulis Indonesia yang terkenal melalui novel Laskar Pelangi, mengangkat kisah nyata dari Belitung.'
        ]);
    
    }
}
