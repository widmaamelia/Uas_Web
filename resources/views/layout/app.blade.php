<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'SIPUSKA - Sistem Informasi Perpustakaan')</title>

  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f8fafc;
      color: #1f2937;
      transition: all 0.3s ease;
    }

    .navbar {
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .navbar-brand {
      font-weight: 700;
      color: #2563eb !important;
    }
    .nav-link {
      font-weight: 500;
      color: #374151 !important;
    }
    .nav-link:hover, .nav-link.active {
      color: #2563eb !important;
    }

    input[type="search"] {
      border-radius: 50px;
    }

    .main-container {
      padding: 2rem 0 4rem;
    }
    .content-card {
      background: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 10px 20px rgba(0,0,0,0.04);
    }

    .book-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 1rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .book-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .book-card img {
      height: 200px;
      object-fit: cover;
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
    }

    .swiper {
      padding-bottom: 1rem;
    }
    .swiper-slide {
      width: 280px;
    }

    footer {
      background: #2563eb;
      color: white;
      text-align: center;
      padding: 2rem 0;
      margin-top: 3rem;
    }
  </style>
</head>
<body>

  <div id="loader" style="position: fixed; width: 100%; height: 100%; background: #fff; display: flex; justify-content: center; align-items: center; z-index: 9999;">
    <div class="spinner-border text-primary" role="status"></div>
  </div>

  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <i class="bi bi-book me-2"></i> SIPUSKA
      </a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMain">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">
              <i class="bi bi-house-door me-1"></i> Home
            </a>
          </li>

          @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <i class="bi bi-layers me-1"></i> Manajemen
            </a>
            <ul class="dropdown-menu">
              @if (Auth::user()->role === 'admin')
                <li><a class="dropdown-item" href="{{ route('books.index') }}">📚 Buku</a></li>
                <li><a class="dropdown-item" href="{{ route('categories.index') }}">🏷️ Kategori</a></li>
                <li><a class="dropdown-item" href="{{ route('members.index') }}">👥 Anggota</a></li>
              @endif
              <li><a class="dropdown-item" href="{{ route('borrowings.index') }}">🔄 Peminjaman</a></li>
            </ul>
          </li>
          @endauth

          {{-- Kategori tampil hanya jika bukan admin --}}
          @guest
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle {{ request()->has('category') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-tags me-1"></i> Kategori
              </a>
              <ul class="dropdown-menu">
                @if(isset($navbarCategories) && count($navbarCategories) > 0)
                  @foreach ($navbarCategories as $category)
                    <li>
                      <a class="dropdown-item {{ request('category') == $category->id ? 'active' : '' }}"
                         href="{{ route('home', ['category' => $category->id]) }}">
                        {{ $category->name }}
                      </a>
                    </li>
                  @endforeach
                @else
                  <li><span class="dropdown-item text-muted">Tidak ada kategori</span></li>
                @endif
              </ul>
            </li>
          @endguest

          @auth
            @if (Auth::user()->role !== 'admin')
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->has('category') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                  <i class="bi bi-tags me-1"></i> Kategori
                </a>
                <ul class="dropdown-menu">
                  @if(isset($navbarCategories) && count($navbarCategories) > 0)
                    @foreach ($navbarCategories as $category)
                      <li>
                        <a class="dropdown-item {{ request('category') == $category->id ? 'active' : '' }}"
                           href="{{ route('home', ['category' => $category->id]) }}">
                          {{ $category->name }}
                        </a>
                      </li>
                    @endforeach
                  @else
                    <li><span class="dropdown-item text-muted">Tidak ada kategori</span></li>
                  @endif
                </ul>
              </li>
            @endif
          @endauth

        </ul>

        <form class="d-flex me-2" method="GET" action="{{ route('home') }}">
          <input class="form-control me-2" type="search" name="search" placeholder="Cari buku..." value="{{ request('search') }}">
          <button class="btn btn-outline-primary rounded-pill" type="submit"><i class="bi bi-search"></i></button>
        </form>

        <ul class="navbar-nav">
          @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-item text-muted">👤 {{ ucfirst(Auth::user()->role) }}</li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                  </a>
                </li>
              </ul>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
          @else
            <li class="nav-item">
              <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary ms-2">
                <i class="bi bi-box-arrow-in-right"></i> Login
              </a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <div class="container main-container">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="content-card" data-aos="zoom-in">
      @yield('content')
    </div>
  </div>

  <footer>
    <div>Sistem Informasi Perpustakaan Kampus</div>
    <small>© 2025 SIPUSKA • by Amelia</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    AOS.init();
    window.addEventListener('load', () => {
      document.getElementById('loader').style.display = 'none';
    });

    const swiper = new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        1024: { slidesPerView: 4 }
      }
    });
  </script>
</body>
</html>
