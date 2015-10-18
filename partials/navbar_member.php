<section class="container-full">
    <div class="container">
        <a href="/">
            <h1 class="logo">Discover</h1>
        </a>
        <a id="mobile-toggle" href="javascript:;" class="mobile-toggle">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </a>
        <nav id="nav">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="javascript:;">Find <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a href="/find?type=1">Promotions</a>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="/find?type=2">Offers</a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-submenu">
                            <a href="/find">Near me</a>
                        </li>
                    </ul>
                </li>
                <?php if($_SESSION['user_isPartner']) : ?>
                    <li>
                        <a href="javascript:;">Campaign <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-submenu">
                                <a href="/campaign/create">Create campaign</a>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="/campaign/">Dashboard</a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="/faq">FAQ</a>
                </li>
                <li>
                    <a href="/contact">Contact</a>
                </li>
                <li>
                    <a href="javascript:;">Account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a href="/profile">Profile</a>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="/logout">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</section>