@if($type === 'navbar')
    <ul class="navbar-nav m-auto">
        @foreach($menuItems as $item)
            @include('components.partials.navbar-item', ['item' => $item])
        @endforeach
    </ul>
@elseif($type === 'footer')
    <ul>
        @foreach($menuItems as $item)
            <li>
                <a href="{{ url($item->link) }}" target="{{ $item->target }}" class="{{ $item->class }}">
                    @if($item->icon) <i class="{{ $item->icon }}"></i> @endif
                    {{ $item->label }}
                </a>
            </li>
        @endforeach
    </ul>
@elseif($type === 'footer_bottom')
    <ul class="d-flex flex-wrap">
        @foreach($menuItems as $item)
            <li>
                <a href="{{ url($item->link) }}" target="{{ $item->target }}" class="{{ $item->class }}">
                    @if($item->icon) <i class="{{ $item->icon }}"></i> @endif
                    {{ $item->label }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
