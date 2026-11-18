
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NEXSTORE - @yield('title', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --bauhaus-red: #E63946;
            --bauhaus-yellow: #F4A261;
            --bauhaus-blue: #1D3557;
            --bg-white: #F1FAEE;
            --text-black: #111111;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Jost', sans-serif;
            background-color: var(--bg-white);
            color: var(--text-black);
            min-height: 100vh;
        }

        /* SIDEBAR ADMIN */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bauhaus-blue);
            border-right: 4px solid var(--text-black);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 30px 20px;
            border-bottom: 4px solid var(--text-black);
            background-color: var(--bauhaus-yellow);
            text-align: center;
        }

        .sidebar-brand h1 {
            font-size: 1.8rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            color: var(--text-black);
            line-height: .9;
        }

        .sidebar-nav {
            padding: 20px 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #FFFFFF;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-left: 6px solid transparent;
            transition: all .2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(255,255,255,.1);
            border-left-color: var(--bauhaus-red);
            color: var(--bauhaus-yellow);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 4px solid var(--text-black);
        }

        .btn-logout {
            width: 100%;
            padding: 12px;
            background-color: var(--bauhaus-red);
            color: #FFFFFF;
            border: 3px solid var(--text-black);
            font-family: inherit;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-logout:hover {
            background-color: var(--bauhaus-yellow);
            color: var(--text-black);
            transform: translate(-2px,-2px);
            box-shadow: 4px 4px 0 var(--text-black);
        }

        /* LAYOUT UTAMA */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            min-height: 80px;
            background-color: var(--bg-white);
            border-bottom: 4px solid var(--text-black);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 40px;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -.5px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 600;
            font-size: .9rem;
            text-transform: uppercase;
        }

        .avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            background-color: var(--bauhaus-red);
            border: 3px solid var(--text-black);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-weight: 900;
        }

        .content-area {
            padding: 40px;
            flex-grow: 1;
            min-width: 0;
        }

        /* MODE POS KASIR */
        body.pos-mode {
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Hilangkan sidebar di halaman POS */
        body.pos-mode .sidebar {
            display: none !important;
        }

        /* Gunakan lebar layar penuh */
        body.pos-mode .main-content {
            margin-left: 0 !important;
            width: 100% !important;
            min-height: 100vh;
        }

        /* Header POS */
        body.pos-mode .top-navbar {
            width: 100%;
            min-height: 68px;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background-color: var(--bg-white);
            border-bottom: 4px solid var(--text-black);
        }

        body.pos-mode .page-title {
            font-size: 1.5rem;
            font-weight: 900;
            white-space: nowrap;
        }

        /* Nama kasir, jam, logout */
        body.pos-mode .pos-header-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 18px;
            flex-shrink: 0;
        }

        body.pos-mode .pos-cashier-name {
            display: inline-block;
            color: var(--text-black);
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            white-space: nowrap;
        }

        body.pos-mode .pos-clock {
            display: inline-block;
            color: var(--text-black);
            font-family: 'Jost', sans-serif;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        body.pos-mode .pos-logout-form {
            margin: 0;
        }

        body.pos-mode .pos-logout-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: var(--bauhaus-red);
            color: #FFFFFF;
            border: 2px solid var(--text-black);
            font-family: 'Jost', sans-serif;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 3px 3px 0 var(--text-black);
            transition: all .2s;
        }

        body.pos-mode .pos-logout-btn:hover {
            background-color: var(--bauhaus-yellow);
            color: var(--text-black);
            transform: translate(-2px,-2px);
            box-shadow: 5px 5px 0 var(--text-black);
        }

        body.pos-mode .content-area {
            width: 100%;
            padding: 20px;
            flex-grow: 1;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .top-navbar {
                padding: 15px 20px;
            }

            .content-area {
                padding: 20px;
            }

            body.pos-mode .top-navbar {
                padding: 10px 14px;
                gap: 8px;
            }

            body.pos-mode .page-title {
                font-size: 1.15rem;
            }

            body.pos-mode .pos-header-right {
                gap: 10px;
            }

            body.pos-mode .pos-cashier-name,
            body.pos-mode .pos-clock {
                font-size: 12px;
            }

            body.pos-mode .pos-logout-btn {
                padding: 7px 10px;
                font-size: 11px;
            }

            body.pos-mode .content-area {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            body.pos-mode .top-navbar {
                flex-wrap: wrap;
            }

            body.pos-mode .pos-header-right {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
            }
        }

        /* Area cetak struk jika halaman struk memakai mode POS */
        @media print {
            .sidebar,
            .top-navbar,
            .no-print {
                display: none !important;
            }

            body,
            body.pos-mode,
            body.pos-mode .main-content,
            body.pos-mode .content-area {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                min-height: auto !important;
                background: #FFFFFF !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="@yield('body_class', '')">

    {{-- SIDEBAR ADMIN --}}
    @unless(View::yieldContent('body_class') === 'pos-mode')
        <aside class="sidebar">

            <div class="sidebar-brand">
                <h1>NEX<br>STORE</h1>
            </div>

            <nav class="sidebar-nav">
                @if(Auth::check() && Auth::user()->role === 'admin')

                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        Kelola Produk
                    </a>

                    <a href="{{ route('laporan') }}"
                       class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                        Laporan Penjualan
                    </a>

                @endif
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        Logout
                    </button>
                </form>
            </div>

        </aside>
    @endunless


    {{-- KONTEN UTAMA --}}
    <main class="main-content">

        {{-- HEADER --}}
        <header class="top-navbar">

            <div class="page-title">
                @yield('title', 'Dashboard')
            </div>

            @if(View::yieldContent('body_class') === 'pos-mode')

                {{-- HEADER POS: NAMA KASIR + JAM + LOGOUT --}}
                <div class="pos-header-right">

                    <span class="pos-cashier-name">
                        KASIR:
                        {{ Auth::user()->name ?? 'Kasir' }}
                    </span>

                    <span class="pos-clock" id="pos-clock">
                        --:--:--
                    </span>

                    <form action="{{ route('logout') }}"
                          method="POST"
                          class="pos-logout-form">
                        @csrf

                        <button type="submit" class="pos-logout-btn">
                            LOGOUT
                        </button>
                    </form>

                </div>

            @else

                {{-- HEADER ADMIN --}}
                <div class="user-info">
                    <span>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>

                    <div class="avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>

            @endif

        </header>

        {{-- ISI HALAMAN --}}
        <div class="content-area">
            @yield('content')
        </div>

    </main>

    {{-- SCRIPT TAMBAHAN DARI HALAMAN --}}
    @stack('scripts')

    {{-- JAM DIGITAL WIB --}}
    <script>
        (function () {
            const clock = document.getElementById('pos-clock');

            if (!clock) return;

            function updateClock() {
                const now = new Date();

                clock.textContent = now.toLocaleTimeString('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
            }

            updateClock();
            setInterval(updateClock, 1000);
        })();
    </script>

</body>
</html>
