
@component('mail::message')
# Weather Update for {{ $city }}

Current Temperature: {{ $temp_c }}°C

Condition: {{ $condition }}

Humidity: {{ $humidity }}%

Wind Speed: {{ $wind_kph }} kph

<img src="https:{{ $icon }}" alt="{{ $condition }}">

Thanks,<br>
{{ config('app.name') }}
@endcomponent
