@component('mail::message')
Hay {{$untuk}}

Klik tombol aktivasi dibawah ini.

@component('mail::button', ['url' => 'http://localhost/laravelv8/myapp/public/aktifasi?link='.$nama])
Aktivasi Akun
@endcomponent

Appku UCONBETON
@endcomponent
