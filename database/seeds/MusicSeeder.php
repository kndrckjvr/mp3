<?php

use App\Album;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++) {
            $name = Str::random(10);
            $artist = Str::random(10);
            $data[] =[
                'name' => $name,
                'artist' => $artist,
                'download_link' => date('Y-m-d_H:i:s') . '_' . $artist . '-' . $name . '.mp3',
                'album_image' => 'default-album.png',
                'downloads' => rand(0, 20),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('musics')->insert($data);
    }
}
