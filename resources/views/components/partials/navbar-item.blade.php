@php
    $hasChildren = $item->children->count() > 0;
@endphp

<li class="nav-item">
    <a class="nav-link" href="{{ $hasChildren ? '#' : url($item->link) }}">
        {{ $item->label }}
        @if($hasChildren)
            <i class="far fa-angle-down"></i>
        @endif
    </a>

    @if($hasChildren)
        <ul class="droap_menu">
            @foreach($item->children as $child)
                <li>
                    <a href="{{ url($child->link) }}">
                        {{ $child->label }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
