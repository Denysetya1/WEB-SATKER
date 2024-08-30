<?php

namespace App\Livewire\Home;

use App\Models\Berita;
use Carbon\Carbon;
use Firefly\FilamentBlog\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class Beritalokal extends Component
{
    use WithPagination;
    public function render(Request $request)
    {
        // $ip = $request->ip();
        $ip = '162.159.24.227'; /* Static IP address */
        $currentUserInfo = Location::get($ip);
        // dd($currentUserInfo);
        if ($currentUserInfo != false) {
            $city = $currentUserInfo->cityName;
            # code...
        } else {
            $city = 'Jakarta';
            # code...
        }
        $igname = 'cabjaripagimana';
        $berita = Post::with('tags')->where('published_at', '<=', Carbon::now())->orderBy('published_at', 'ASC');
        // dd($berita);
        return view('livewire.home.beritalokal',[
            'beritas'=> $berita->paginate(6),
            'city'=> $city,
        ]);
    }

    // public function paginationView()
    // {
    //     return 'vendor/livewire/bootstrap';
    // }
}
