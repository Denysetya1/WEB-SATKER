*Hi Pidum!*

Ada SPDP Masuk dengan nomor *{{$data['no_spdp']}}*
A.N. Tersangka :
@foreach ($data['nama'] as $key => $val)
    *{{$key+1}}. {{$val}}*
@endforeach

Pada Tanggal *{{$data['masuk_at']}}*
