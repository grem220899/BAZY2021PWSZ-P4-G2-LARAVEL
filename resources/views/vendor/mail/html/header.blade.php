<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === 'Laravel')
    <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Logo">
    @elseif (trim($slot) === 'Komunikator')
    <img src="https://www.wykop.pl/cdn/c3201142/comment_HUzL630KBBhQ5G7IL55n21YEUzgPFaoH.jpg" class="logo" alt="Logo">
    @else
{{ $slot }}
@endif
</a>
</td>
</tr>
