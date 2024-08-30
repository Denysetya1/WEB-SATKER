<?php

namespace App\Livewire\Home;

use KubAT\PhpSimple\HtmlDomParser;
use Livewire\Component;

class Majalah extends Component
{
    public function render()
    {
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://www.kejaksaan.go.id/');
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $dom = HtmlDomParser::str_get_html($response);
        // foreach ($dom->find('head > title') as $key => $test) {
        //     $cek = $test->innertext;
        // }
        // if ($cek == 'Under Maintenance') {
        //     $majalah = null;
        // } else {
        //     foreach ($dom->find('section.overlay-success > div.container > div.row > div.col-lg-2') as $key => $test) {
        //         $majalah[$key]['link'] = $test->children[0]->attr['href'];
        //         $majalah[$key]['img'] = $test->children[0]->children[0]->attr['src'];
        //         $majalah[$key]['title'] = $test->children[1]->innertext;
        //     }
        // }
        return view('livewire.home.majalah', [
            'magazines' => null
        ]);
    }
}
