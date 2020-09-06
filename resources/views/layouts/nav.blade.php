<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-light navbar-t" style="background-color: rgba(110, 80, 100, 0.1);">

    <!-- Navbar brand -->
    @guest
    <a class="navbar-brand" href="{{ route('index') }}" }><img src="" alt="">ロゴ｜</img>Your Bookshelf</a>
    @endguest
    @auth
    <a class="navbar-brand" href="{{ route('books.index') }}"><img src="" alt="">ロゴ｜</img>Your Bookshelf</a>
    @endauth
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
                <a class="btn btn-primary-s" href="{{ route('register')}}" role="button" style="background-color: #ff7f50;">新規登録</a>
            </li>
            @endguest

            @guest
            <li class="nav-item">
                <a class="btn btn-primary-l" href="{{ route('login')}}" role="button" style="background-color: #8fbc8f;">ログイン</a>
            </li>
            @endguest

            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('books.search')}}"><i class="fas fa-book-open"></i>本を検索する</a>
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