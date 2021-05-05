<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === 'Laravel')
    <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Logo">
    @elseif (trim($slot) === 'Komunikator')
    <img src="https://cdn.discordapp.com/attachments/768759916700762144/839183138885730324/discordz.png" class="logo" alt="Logo">
    @else
{{ $slot }}
@endif
</a>
</td>
</tr>
