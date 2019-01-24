@component('mail::message')
Hi {{$first_name}}

The following request has been recieved.

@component('mail::panel')
    {{$task_name}}
@endcomponent

You can track the status of this request by logging into the client portal.

@component('mail::button', ['url' => 'https://clients.pbdigital.com.au/'])
Click Here To Log In
@endcomponent


Thanks,<br><br>
{{ config('app.name') }}
@endcomponent
