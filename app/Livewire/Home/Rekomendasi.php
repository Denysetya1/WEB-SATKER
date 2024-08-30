<?php

namespace App\Livewire\Home;

use App\Models\Berita;
use Firefly\FilamentBlog\Models\Post;
use Livewire\Component;

use function PHPUnit\Framework\isNull;

class Rekomendasi extends Component
{
    public function render()
    {
        $rekomendasi = Post::where('featured', true)->get();
        // dd($rekomendasi);
        // if (isNull($rekomendasi)) {
        //     $rekomendasi = Berita::where('featured', true)->get();
        // } else {
        //     $rekomendasi = Post::where('featured', true)->get();
        // }
        return view('livewire.home.rekomendasi', ['rekomsnews'=> $rekomendasi,]);
    }
}
