<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://lh3.googleusercontent.com/ogw/ADea4I79PFKqn6WiE3fNnrt7Ft-oqiAp2_DvFwjeLfPS=s83-c-mo" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
