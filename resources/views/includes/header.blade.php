<header class="c-header border-bottom">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('img/logo.png') }}" width="156" height="49" alt="Vyhľadávanie miest a obcí v SR">
            </a>
            <button type="button" data-toggle="collapse" data-target=".mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="c-header__main-navbar mainNavbar collapse navbar-collapse order-lg-1">
                <ul class="navbar-nav pt-2 pt-lg-6">
                    <li class="nav-item">
                        <a href="#" class="nav-link">O nás</a>
                    </li>
                    <li class="nav-item ml-lg-7">
                        <a href="#" class="nav-link">Zoznam miest</a>
                    </li>
                    <li class="nav-item ml-lg-7">
                        <a href="#" class="nav-link">Inšpekcia</a>
                    </li>
                    <li class="nav-item ml-lg-7">
                        <a href="#" class="nav-link">Kontakt</a>
                    </li>
                </ul>
            </div>
            <div class="mainNavbar collapse navbar-collapse">
                <ul class="navbar-nav ml-auto align-items-lg-center">
                    <li class="nav-item">
                        <a href="#" class="font-weight-bolder">Kontakty a čísla na oddelenia</a>
                    </li>
                    <li class="nav-item dropdown ml-lg-6">
                        <a id="navbarDropdownLanguage" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
                            EN
                        </a>
                        <div aria-labelledby="navbarDropdownLanguage" class="dropdown-menu">
                            <a href="#" class="dropdown-item">SK</a>
                            <a href="#" class="dropdown-item">DE</a>
                        </div>
                    </li>
                    <li class="nav-item ml-lg-3">
                        <form class="my-2 my-lg-0">
                            <div class="c-search-field">
                                <input type="text" aria-label="Vyhľadávanie" aria-describedby="button-search" class="c-search-field__input form-control">
                                <button type="submit" class="c-search-field__icon btn">
                                    <i aria-hidden="true" class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </li>
                    <li class="nav-item ml-lg-2">
                        <a href="#" class="btn btn-success">Prihlásenie</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
