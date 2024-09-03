<x-mail::message>
# Account Password Reset
 
Your Toddler App account password has been reset. Your new credentials are as below.

<x-mail::panel>
<span style="font-weight: 400;">Email: </span><span style="font-weight: 500;">{{ $email }}</span><br>
<span style="font-weight: 400;">Password: </span><span style="font-weight: 500;">{{ $password }}</span><br>
</x-mail::panel>

Thank you,<br>
{{ config('app.name') }}
</x-mail::message>