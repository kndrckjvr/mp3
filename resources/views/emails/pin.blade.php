@component('mail::message')
# Check My Downloads Pin

You can check your downloads here.

@component('mail::button', ['url' => url("/check-my-downloads?token=$token&pin=$pin")])
My Downloads
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
