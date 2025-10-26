@props([
    'title' => '',
    'items' => [],
])

<div class="mt-5 mb-5">
    <p class="font-bold underline"><small>{{ $title }}</small></p>
    <ul class="list-disc list-inside mt-2">
        @foreach($items as $item)
            <li><small>{!! $item !!}</small></li>
        @endforeach
    </ul>
</div>
