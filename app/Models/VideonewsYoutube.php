<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

class VideonewsYoutube
{
    private string $id;
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function save(Videonews $videonews)
    {
        //api request
        $response = Http::asJson()
        ->get(
            'https://youtube.googleapis.com/youtube/v3/search',
            // 'https://youtube.googleapis.com/youtube/v3/videos',
            // 'https://youtube.googleapis.com/youtube/v3/channels',
            // 'https://youtube.googleapis.com/youtube/v3/playlists',
            [
                // 'part'  => 'snippet,contentDetails',
                // 'part'  => 'snippet,contentDetails,statistics',
                // 'part'  => 'snippet,player,contentDetails',
                'order'     => 'date',
                'part'      => 'snippet',
                'channelId' => $this->id,
                'maxResults' => '10',
                'key'       => 'AIzaSyB8PYd08jduqr6Xt5cdzIMFKISW_UvlcFc'
            ]
        );

        dd($response->json());

        //prepare data
        // for($i = 0; $i < 10; $i++) {
        //     dd($response->json('items.'.$i.'.id.videoId'));
        //     $video = Http::asJson()
        //     ->get(
        //         'https://youtube.googleapis.com/youtube/v3/videos',
        //         [
        //             'part'  => 'snippet,player,contentDetails',
        //             'id' => $response->json('items.'.$i.'.id.videoId'),
        //             'key'       => 'AIzaSyB8PYd08jduqr6Xt5cdzIMFKISW_UvlcFc'
        //         ]
        //     );
        // }
        // dd($video->json());
        // $data = [
        //     'title' => '',
        //     'duration' => '',
        //     'embed_html' => '',
        //     'thumbnail_url' => '',
        //     'description' => '',
        //     'external_id' => '',
        //     'published_at' => '',
        //     'approved_at' => '',
        // ]

        //save
    }
}
