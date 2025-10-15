<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
   
   protected $table = 'genres';
 
   //  private $genres = [
   //      [
   //          'name' => 'Fiksi',
   //          'description' => 'Karya sastra yang berisi cerita hasil imajinasi dan tidak sepenuhnya berdasarkan fakta.'
   //      ],
   //      [
   //          'name' => 'Motivasi',
   //          'description' => 'Buku yang memberikan dorongan semangat dan panduan dalam menghadapi kehidupan.'
   //      ],
   //      [
   //          'name' => 'Fantasi',
   //          'description' => 'Genre yang menampilkan dunia imajinatif dengan unsur sihir, makhluk mitos, dan petualangan epik.'
   //      ],
   //      [
   //          'name' => 'Sejarah',
   //          'description' => 'Buku yang membahas peristiwa masa lalu berdasarkan fakta dan penelitian.'
   //      ],
   //      [
   //          'name' => 'Sains Fiksi',
   //          'description' => 'Cerita yang menggabungkan teknologi futuristik, penemuan ilmiah, dan eksplorasi luar angkasa.'
   //      ],
   //  ];

   //  // Fungsi untuk mengembalikan seluruh data genre
   //  public function getGenres()
   //  {
   //      return $this->genres;
   //  }
 
}
