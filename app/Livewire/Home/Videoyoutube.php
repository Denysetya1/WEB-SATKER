<?php

namespace App\Livewire\Home;

use Illuminate\Support\Facades\Http;
use KubAT\PhpSimple\HtmlDomParser;
use Livewire\Component;

class Videoyoutube extends Component
{
    public function render()
    {
        $max = 5;
        $chId = 'UCy9IA8V2Wo2pxHHXDVVtuhA';
        $key = 'AIzaSyB8PYd08jduqr6Xt5cdzIMFKISW_UvlcFc';
        $response = Http::asJson()
        ->get(
            // 'https://youtube.googleapis.com/youtube/v3/search',
            'https://youtube.googleapis.com/youtube/v3/activities',
            [
                // 'order'     => 'date',
                'part'      => 'contentDetails',
                'channelId' => $chId,
                'maxResults' => $max,
                'key'       => $key
            ]
        );
        // dd($response->json());
        for($i = 0; $i < $max; $i++){
            $videolist = Http::asJson()
            ->get(
                'https://youtube.googleapis.com/youtube/v3/videos',
                [
                    'part'  => 'snippet',
                    'id'    => $response->json('items.'.$i.'.contentDetails.upload.videoId'),
                    'key'   => $key
                ]
            );
            $list[$i] = [
                'id'            => $response->json('items.'.$i.'.contentDetails.upload.videoId'),
                'publishedAt'   => date('d M Y',strtotime($videolist->json('items.0.snippet.publishedAt'))),
                'title'         => $videolist->json('items.0.snippet.title'),
                // 'description'   => $videolist->json('items.0.snippet.description'),
                'thumbnails'    => $videolist->json('items.0.snippet.thumbnails.standard.url'),
            ];
        }
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://www.kejaksaan.go.id/');
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $responses = curl_exec($ch);
        // curl_close($ch);
        // $dom = HtmlDomParser::str_get_html($responses);
        // foreach ($dom->find('head > title') as $key => $test) {
        //     $cek = $test->innertext;
        // }
        // if ($cek == 'Under Maintenance') {
        //     $layanan = null;
        // } else {
        //     $layanan = [
        //         ['link' => 'https://tilang.kejaksaan.go.id/', 'title' => 'E-Tilang', 'img' => "https://www.kejaksaan.go.id/uploads/layanan/fe8c439b6f92a4940b44a6daedf2980f.png"],
        //         ['link' => 'http://cms-publik.kejaksaan.go.id/', 'title' => 'Informasi Perkara (CMS Publik)', 'img' => "https://www.kejaksaan.go.id/uploads/layanan/212f2a5d9889f30e16707f58690c04c1.png"],
        //         ['link' => 'https://jdih.kejaksaan.go.id/', 'title' => 'JDIH Kejaksaan', 'img' => "https://www.kejaksaan.go.id/uploads/layanan/787b96282c98c28fbe96dac3388cdf16.png"],
        //         ['link' => 'https://www.kejaksaan.go.id/buronan', 'title' => 'Daftar Buronan', 'img' => "https://www.kejaksaan.go.id/uploads/layanan/078eb8a73b206e74df79096a88dc0966.png"],
        //         ['link' => 'https://halojpn.id/', 'title' => 'Halo JPN', 'img' => "https://www.kejaksaan.go.id/uploads/layanan/4e28d634727ec86509a281e6b49be189.png"],
        //         ['link' => 'http://ppid.kejaksaan.go.id/', 'title' => 'E-PPID', 'img' => "https://www.kejaksaan.go.id/uploads/layanan/06da1c6925b5d9c142ea4e2d9edff98d.png"],
        //         ['link' => 'https://www.kejaksaan.go.id/pengaduan', 'title' => 'Whistle Blowing System', 'img' => "https://www.kejaksaan.go.id/uploads/layanan/1a70f74461f3e1261b44b9a11ee014f5.png"],
        //     ];
        // }
        return view('livewire.home.videoyoutube', [
            'videos' => $list,
            'pelayanan' => null
        ]);
    }
}
