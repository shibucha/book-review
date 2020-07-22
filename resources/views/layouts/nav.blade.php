<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark primary-color">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="{{ route('books.index') }}" }>Your Bookshelf</a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

        <!-- Links -->
        <ul class="navbar-nav ml-auto">
            <!-- <form class="form-inline">
                <div class="md-form my-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="本を探す" aria-label="Search">
                </div>
            </form> -->

            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register')}}">ユーザー登録</a>
            </li>
            @endguest

            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login')}}">ログイン</a>
            </li>
            @endguest

            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('books.create')}}"><i class="fas fa-book-open"></i>本を記録する</a>
            </li>
            @endauth

            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">メニュー</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                    <button class="dropdown-item" onclick="location.href='{{ route('books.index') }}'">マイページ</button>
                    <button type="submit" class="dropdown-item" form="logout-button">ログアウト</button>
                </div>
            </li>

            <form id="logout-button" method="POST" action="{{ route('logout') }}">
                @csrf
            </form>
            @endauth
            <!-- Dropdown -->
        </ul>
    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->