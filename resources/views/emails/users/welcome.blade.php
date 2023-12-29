<x-mail::message>
# {{__('callmeaf-auth::v1.mails.welcome.title')}}

{{__('callmeaf-auth::v1.mails.welcome.content',[
    'title' => config('app.name'),
])}}

<x-mail::button :url="''">
    {{__('callmeaf-auth::v1.mails.welcome.link')}}
</x-mail::button>

    {{__('callmeaf-auth::v1.mails.welcome.footer')}}<br>
{{ config('app.name') }}
</x-mail::message>
