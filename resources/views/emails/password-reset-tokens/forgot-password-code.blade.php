<x-mail::message>
    # {{__('callmeaf-auth::v1.mails.forgot_password.title')}}

    {{__('callmeaf-auth::v1.mails.forgot_password.content')}}: {{$passwordResetToken->code}}

    {{ config('app.name') }}
</x-mail::message>
