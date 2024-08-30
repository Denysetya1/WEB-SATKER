<?php

namespace App\Livewire\Home;

use KubAT\PhpSimple\HtmlDomParser;
use Livewire\Component;

class Beritapusat extends Component
{
    public function render()
    {
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://www.kejaksaan.go.id/berita');
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $dom = HtmlDomParser::str_get_html($response);

        // foreach ($dom->find('head > title') as $key => $test) {
        //     $cek = $test->innertext;
        // }
        // if ($cek == 'Under Maintenance'){
        //     $pusat = null;
        // } else {
        //     foreach ($dom->find('div.card-body > div.row > div.col-md-6 > a.post-preview') as $key => $test) {
        //         $pusat[$key]['link'] = $test->attr['href'];
        //     }
        //     foreach ($dom->find('div.card-body > div.row > div.col-md-6 > a.post-preview > img.card-img-top') as $key => $test) {
        //         // $tes[] = $test;
        //         $pusat[$key]['img'] = $test->attr['src'];
        //     }
        //     foreach ($dom->find('div.card-body > div.row > div.col-md-6 > a.post-preview > div.card-body > h5.card-title') as $key => $test) {
        //         // $tes[] = $test->innertext;
        //         $pusat[$key]['title'] = $test->innertext;
        //     }
        //     foreach ($dom->find('div.card-body > div.row > div.col-md-6 > a.post-preview > div.card-body > p.card-text') as $key => $test) {
        //         // $tes[] = $test->innertext;
        //         $pusat[$key]['text'] = $test->innertext;
        //     }
        //     foreach ($dom->find('div.card-body > div.row > div.col-md-6 > a.post-preview > div.card-footer > div.post-preview-meta > div.post-preview-meta-details > small') as $key => $test) {
        //         // $tes[] = $test->innertext;
        //         $pusat[$key]['published'] = $test->innertext;
        //     }
        // }
        return view('livewire.home.beritapusat', [
            'pusatnews'=> null
        ]);
    }
}
