{{-- resources/views/partials/navbar.blade.php --}}
{{-- Include this via @include('partials.navbar') if needed outside the sidebar layout --}}

<nav style="background: #f7d6e4; border-bottom: 1px solid #e8b4cc; height: 56px; display: flex; align-items: center; justify-content: space-between; padding: 0 1.5rem;">
    <span style="font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 600; color: #a04070;">
        Sakura
    </span>

    <div style="display: flex; align-items: center; gap: 1rem;">
        @if(session('user'))
            <span style="font-size: 0.8rem; color: #a04070;">
                {{ session('user')['name'] }}
                <span class="badge" style="background: {{ session('user')['role'] === 'admin' ? '#d4608a' : '#f3c9d9' }}; color: {{ session('user')['role'] === 'admin' ? '#fff' : '#a04070' }}; font-size: 10px;">
                    {{ ucfirst(session('user')['role']) }}
                </span>
            </span>

            <form action="/logout" method="POST" style="display: inline; margin: 0;">
                @csrf
                <button type="submit" style="border: none; background: #fff0f6; padding: 5px 12px; border-radius: 6px; color: #a04070; cursor: pointer; font-size: 0.8rem;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        @else
            <a href="/login"    style="font-size: 0.85rem; color: #a04070; text-decoration: none;">Login</a>
            <a href="/register" style="font-size: 0.85rem; color: #a04070; text-decoration: none;">Register</a>
        @endif
    </div>
</nav>