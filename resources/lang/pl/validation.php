<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute musi być zaakceptowany.',
    'active_url' => ':attribute nie jest poprawnym linkiem URL.',
    'after' => ':attribute musi być datą po :date.',
    'after_or_equal' => ':attribute musi być datą po lub równą :date.',
    'alpha' => ':attribute musi zawierać tylko litery.',
    'alpha_dash' => ':attribute musi zawerać tylko litery, cyfry, myślniki i podkreślenia.',
    'alpha_num' => ':attribute musi zawierać tylko litery i cyfry.',
    'array' => ':attribute musi być tablicą.',
    'before' => ':attribute musi być przed datą :date.',
    'before_or_equal' => ':attribute musi być datą przed lub równą :date.',
    'between' => [
        'numeric' => ':attribute musi zawierać się w przedziale :min i :max.',
        'file' => ':attribute musi zawierać się w przedziale :min i :max kilobajtów.',
        'string' => ':attribute musi zawierać się w przedziale :min i :max znaków.',
        'array' => ':attribute musi zawierać się w przedziale :min i :max przedmiotów.',
    ],
    'boolean' => ':attribute musi mieć wartość prawda lub fałsz.',
    'confirmed' => ':attribute potwierdzenie nie zgadza się.',
    'date' => ':attribute nie jest prawidłową datą.',
    'date_equals' => ':attribute musi być datą równą :date.',
    'date_format' => ':attribute nie zgadza się z formatem :format.',
    'different' => ':attribute i :other muszą się różnić.',
    'digits' => ':attribute musi być :digits cyframi.',
    'digits_between' => ':attribute musi zawierać się w przedziale od :min do :max cyfr.',
    'dimensions' => ':attribute ma nieprawidłowe wymiary obrazu.',
    'distinct' => 'Pole :attribute ma zduplikowaną wartość.',
    'email' => ':attribute musi być prawidłowym adresem e-mail.',
    'ends_with' => ':attribute musi kończyć się jednym z poniższych: :values.',
    'exists' => 'Wybrany :attribute jest nieprawidłowy.',
    'file' => ':attribute musi być plikiem.',
    'filled' => 'Pole :attribute musi mieć wartość.',
    'gt' => [
        'numeric' => ':attribute musi być większa niż :value.',
        'file' => ':attribute musi być większa niż :value kilobajtów.',
        'string' => ':attribute musi być większa niż :value znaków.',
        'array' => ':attribute musi mieć więcej niż :value przedmiotów.',
    ],
    'gte' => [
        'numeric' => ':attribute musi być większa niż lub równa :value.',
        'file' => ':attribute musi być większa niż lub równa :value kilobajtów.',
        'string' => ':attribute musi być większa niż lub równa :value znaków.',
        'array' => ':attribute musi mieć :value przedmiotów lub więcej.',
    ],
    'image' => ':attribute musi być obrazem .',
    'in' => 'Wybrany :attribute jest nieprawidłowy.',
    'in_array' => 'Pole :attribute nie istnieje w :other.',
    'integer' => ':attribute musi być liczbą całkowitą.',
    'ip' => ':attribute musi być prawidłowym adresem IP.',
    'ipv4' => ':attribute musi być prawidłowym adresem IPv4.',
    'ipv6' => ':attribute musi być prawidłowym adresem IPv6.',
    'json' => 'The :attribute musi być prawidłowym ciągiem JSON.',
    'lt' => [
        'numeric' => ':attribute musi być mniejszy niż :value.',
        'file' => ':attribute musi być mniejszy niż :value kilobajtów.',
        'string' => ':attribute musi być mniejszy niż :value znaków.',
        'array' => ':attribute musi mieć mniej niż :value przedmiotów.',
    ],
    'lte' => [
        'numeric' => ':attribute musi być mniejszy lub równy :value.',
        'file' => ':attribute musi być mniejszy lub równy :value kilobajtów.',
        'string' => ':attribute musi być mniejszy lub równy :value znaków.',
        'array' => ':attributenie może mieć więcej niż :value przedmiotów.',
    ],
    'max' => [
        'numeric' => ':attribute nie może być większa niż :max.',
        'file' => ':attribute nie może być większa niż :max kilobajtów.',
        'string' => ':attribute nie może być większa niż :max znaków.',
        'array' => ':attribute nie może mieć więcej niż :max przedmiotów.',
    ],
    'mimes' => ':attribute musi być plikiem typu: :values.',
    'mimetypes' => ':attribute musi być plikiem typu: :values.',
    'min' => [
        'numeric' => ':attribute musi mieć conajmniej :min.',
        'file' => ':attribute musi mieć conajmniej :min kilobajtów.',
        'string' => ':attribute musi mieć conajmniej :min znaków.',
        'array' => 'attribute musi mieć conajmniej :min przedmiotów.',
    ],
    'multiple_of' => ':attribute musi być wielokrotnością :value.',
    'not_in' => 'wybrany :attribute jest niepoprawny.',
    'not_regex' => ':attribute format jest niepoprawny.',
    'numeric' => ':attribute musi być numeryczny.',
    'password' => 'Hasło jest niepoprawne.',
    'present' => 'Pole :attribute musi być obecne.',
    'regex' => 'Format :attribute jest niepoprawny.',
    'required' => 'Pole :attribute jest wymagane.',
    'required_if' => 'Pole :attribute jest wymagane gdy :other jest :value.',
    'required_unless' => 'Pole :attribute jest wymagane, chyba że :other znajduje się w :values.',
    'required_with' => 'Pole :attribute jest wymagane, gdy istnieje :values.',
    'required_with_all' => 'Pole :attribute jest wymagane, gdy istnieją :values.',
    'required_without' => 'Pole :attribute jest wymagane, gdy :values nie występuje.',
    'required_without_all' => 'Pole :attribute jest wymagane, gdy żadna z :values nie jest obecna.',
    'prohibited' => 'Pole :attribute jest zabronione.',
    'prohibited_if' => 'Pole :attribute jest zabronione gdy :other ma wartość :value.',
    'prohibited_unless' => 'Pole :attribute jest zabronione, chyba że :other jest w :values.',
    'same' => ':attribute i :other muszą pasować.',
    'size' => [
        'numeric' => ':attribute musi być rozmiaru :size.',
        'file' => ':attribute musi być rozmiaru :size kilobajtów.',
        'string' => ':attribute musi być rozmiaru :size znaków.',
        'array' => ':attribute musi zawierać :size przedmiotów.',
    ],
    'starts_with' => ':attribute musi zaczynać się jednym z ponższych: :values.',
    'string' => ':attribute musi być ciągiem.',
    'timezone' => ':attribute musi być prawidłową strefą czasową.',
    'unique' => ':attribute jest już zajęty.',
    'uploaded' => ':attribute nie został przesłany.',
    'url' => 'Format :attribute jest nieprawidłowy.',
    'uuid' => ':attribute musi być prawidłowym UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
