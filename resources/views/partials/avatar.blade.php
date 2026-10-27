@if (! empty($photo))
    <img class="avatar {{ $class ?? '' }}" src="{{ $photo }}" alt="">
@else
    <span class="avatar {{ $class ?? '' }}">{{ mb_strtoupper(mb_substr($name, 0, 1)) }}</span>
@endif
