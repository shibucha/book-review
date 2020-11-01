<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-light navbar-t">

    <div class="navbar__inner">
        <div class="navbar__btn">
            @guest
            <a class="display__none-900down letter-white navbar__service-name" href="{{ route('index') }}"><img src="" alt="">Your Bookshelf</img></a>
            @endguest
            @auth
            <a class="display__none-900down letter-white navbar__service-name" href="{{ route('books.index') }}"><img src="" alt="">Your Bookshelf</img></a>
            @endauth

            <!-- Collapse button -->            
            <button class="navbar-toggler navbar__hamburger" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="basicExampleNav">
                <!-- Links -->
                <ul class="navbar-nav ml-auto">

                    @guest
                    <li class="nav-item for-none">
                        <a class="btn btn-primary-s for-r-sign" href="{{ route('register')}}" role="button">新規登録</a>
                    </li>
                    <li class="nav-item for-r-li">
                        <a class="btn-primary-s for-r-sign" href="{{ route('register')}}">新規登録</a>
                    </li>
                    @endguest

                    @guest
                    <li class="nav-item for-none">
                        <a class="btn btn-primary-l for-r-sign" href="{{ route('login')}}" role="button">ログイン</a>
                    </li>
                    <li class="nav-item for-r-li">
                        <a class="btn-primary-l for-r-sign" href="{{ route('login')}}" role="button">ログイン</a>
                    </li>
                    @endguest

                    @auth
                    <li class="nav-item navbar__item">
                        <a class="letter-white" href="{{ route('books.search')}}"><i class="fas fa-book-open"></i>本を検索する</a>
                    </li>
                    @endauth

                    @auth
                    <li class="nav-item dropdown navbar__item">
                        <a class="navbar__menu-btn dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">メニュー</a>
                        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                            <button class="dropdown-item btn__mypage" onclick="location.href='{{ route('books.index') }}'">マイページ</button>
                            <button class="dropdown-item btn__mypage" onclick="location.href='{{ route('index') }}'">トップページ</button>
                            <button type="submit" class="dropdown-item btn__logout" form="logout-button">ログアウト</button>
                            <button type="submit" class="dropdown-item btn__setting" form="resign-button" onclick="location.href='{{ route('settings.my_profile') }}'">設定</button>
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
        </div>
        <!-- Navbar brand -->

    </div>

</nav>
<!--/.Navbar-->