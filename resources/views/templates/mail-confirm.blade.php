@component('mail::message')
Welcome to {{ config('app.name') }} <br/>
This is a sample generate mail message and still in development <br/>
Username: [your-email] <br/>
Password: {{ $user->temp_password }} <br/>

@component('mail::button', ['url' => "https://omniscient.poker/login"])
Login
@endcomponent

Thanks,<br>
The Management
@endcomponent
