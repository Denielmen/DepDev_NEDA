@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/DEDev_logo.png') }}" class="logo" alt="DEPDEV company logo with bold blue and green letters on a white background, conveying a professional and modern tone" style="height: 50px;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
