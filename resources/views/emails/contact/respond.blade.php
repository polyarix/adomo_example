@component('mail::message')
    # Ответ на обращение в поддержку

    Вы сделали обращение в поддержку с вопросом:

    "{{ $contact->text }}"


    Ответ от поддержки: "{{ $contact->response_text }}"

    {{ config('app.name') }}
@endcomponent
