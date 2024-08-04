<ul class="navbar-nav bg-green-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="/home">
        <div class="sidebar-brand-text mx-2 bg-white d-flex align-items-center justify-content-center p-1 rounded shadow" style="max-width: 80px;">
            <img src="{{ asset('image/icon.png') }}" alt="{{ config('app.name', 'Laravel') }}" style="width: 100%;">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @foreach (config('navmenu') as $menu)
            @if (array_key_exists('child', $menu))
                @php
                    $childUrls = array_map(function ($child) {
                        return url($child['url']);
                    }, $menu['child']);
                @endphp
                <li class="nav-item {{ in_array(Request::url(), $childUrls) ? 'active' : '' }}">
                    <a class="nav-link collapsed dropdown-toggle" href="#" data-bs-toggle="collapse"
                        data-bs-target="#{{ $menu['code'] }}" aria-expanded="true" aria-controls="{{ $menu['code'] }}">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span class="text-truncate">{{ $menu['name'] }}</span>
                    </a>
                    <div id="{{ $menu['code'] }}" class="collapse {{ in_array(Request::url(), $childUrls) ? 'show' : '' }}">
                        <div class="bg-warning py-2 collapse-inner rounded">
                            @foreach ($menu['child'] as $child)
                                <a class="collapse-item {{ Request::url() == url($child['url']) ? 'active' : '' }}"
                                    href="{{ url($child['url']) }}">{{ $child['name'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
            @else
                <li class="nav-item {{ Request::url() == url($menu['url']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url($menu['url']) }}">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span>{{ $menu['name'] }}</span>
                    </a>
                </li>
            @endif
    @endforeach
</ul>
