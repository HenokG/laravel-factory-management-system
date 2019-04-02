<!-- Header Begins -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary-color">
    <a class="navbar-brand" href="/">Firdows</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">

            @if(session()->get(\App\Util\FinalConstants::SESSION_DEPARTMENT_LABEL) == \App\Util\FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL)
                <li class="nav-item {{Request::is('deliveries') || Request::is('deliveries') ? 'active': ''}}">
                    <a class="nav-link" href="/deliveries">Delivery Nos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"
                       href="#"> {{ session(\App\Util\FinalConstants::SESSION_LOGGEDINUSER_LABEL) ?? session(\App\Util\FinalConstants::SESSION_LOGGEDIN_ADMIN_LABEL) }}</a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="logout">Signout</a>
                    </div>
                </li>

            @elseif(session()->has(\App\Util\FinalConstants::SESSION_LOGGEDINUSER_LABEL))
                {{--
                                <li class="nav-item {{Request::is('customers') ? 'active': ''}}">
                                    <a class="nav-link" href="customers">Customers</a>
                                </li>
                                <li class="nav-item {{Request::is('orders') || Request::is('order') ? 'active': ''}}">
                                    <a class="nav-link" href="orders">Orders</a>
                                </li>
                                <li class="nav-item {{Request::is('agreements') ? 'active': ''}}">
                                    <a class="nav-link" href="agreements">Agreements</a>
                                </li>--}}
                <li class="nav-item {{Request::is('customers') ? 'active': ''}}">
                    <a class="nav-link" href="/customers">Dashboard</a>
                </li>
                <li class="nav-item {{Request::is('proformas') || Request::is('proforma') ? 'active': ''}}">
                    <a class="nav-link" href="/proformas">Proforma Nos</a>
                </li>
                <li class="nav-item {{Request::is('deliveries') || Request::is('deliveries') ? 'active': ''}}">
                    <a class="nav-link" href="/deliveries">Delivery Nos</a>
                </li>
                <li class="nav-item dropdown">
                    {{--<img src="/images/santa.png" alt="Avatar" style="width: 1.8rem;">--}}
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"
                       href="#"> {{ session(\App\Util\FinalConstants::SESSION_LOGGEDINUSER_LABEL) ?? session(\App\Util\FinalConstants::SESSION_LOGGEDIN_ADMIN_LABEL) }}</a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/logout">Signout</a>
                    </div>
                </li>


            @elseif ( session()->has(\App\Util\FinalConstants::SESSION_LOGGEDIN_ADMINID_LABEL))


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"
                       href="#"> {{session(\App\Util\FinalConstants::SESSION_LOGGEDIN_ADMIN_LABEL) }}</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="logout">Signout</a>
                    </div>
                </li>


            @else

                <li class="{{Request::is('login') ? 'active': ''}} nav-item">
                    <a class="nav-link" href="login">Sign In <span class="sr-only">(current)</span></a>
                </li>
                {{--<li class="nav-item {{Request::is('signup') ? 'active': ''}}">--}}
                    {{--<a class="nav-link" href="signup">Sign Up <span class="sr-only">(current)</span></a>--}}
                {{--</li>--}}
            @endif
        </ul>
    </div>
</nav>

{{--sidbar--}}
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <ul class="list-group mx-2">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Alerts
            <span class="badge badge-dark badge-pill">14</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Notifications
            <span class="badge badge-dark badge-pill">2</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Others
            <span class="badge badge-dark badge-pill">1</span>
        </li>
    </ul>
</div>

<script>
    /* Set the width of the side navigation to 250px */
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>

<!-- Header Ends -->