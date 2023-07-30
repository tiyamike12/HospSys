@component('mail::message')
    # Welcome to App!

    Your login credentials are:

    - Username: {{ $username }}
    - Password: {{ $password }}

    Please keep this information secure and do not share it with others.

    Thank you for registering with YourApp!

@endcomponent
