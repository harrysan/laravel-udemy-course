@if (!isset($show) || $show)
    <span class="badge alert-{{ $type ?? 'success' }}">
        {{ $slot }}
    </span>
@endif