@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Witaj!')
@endif
@endif

{{-- Intro Lines --}}
{{"Kliknij przycisk poniżej, aby zweryfikować swój adres e-mail."}}

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ "Weryfikuj konto" }}
@endcomponent
@endisset

{{-- Outro Lines --}}
{{"Jeśli nie utworzyłeś konta, żadne dalsze działania nie są wymagane."}}

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Najlepszego'),<br>
@lang('Komunikator :D') 
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Jeśli nie możesz kliknąć w \"Weryfikuj konto\", skopiuj i wklej poniższy link\n".
    'do swojej przeglądarki:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
