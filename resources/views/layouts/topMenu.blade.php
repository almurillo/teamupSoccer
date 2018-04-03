
<div id="bmemSearchResults"></div>
<div id="pagetop">
	<div id="pagetopwrap">
		<div id="pagetoplogo">
			<a href="{{ route('home') }}"><img src="/images/logo.png" alt="Logo" class="animated lightSpeedIn"  title="TeamUp Soccer" /></a>		
		</div>
		<div id="pagetoprest">
		<div id="menu1">
	       <!-- Right Side Of Navbar -->
	        <ul class="nav navbar-nav navbar-right">
	            <!-- Authentication Links -->
	            @if (Auth::guest())
	                <li><a href="{{ route('login') }}">Login</a></li>
	                <li><a href="{{ route('register') }}">Register</a></li>
	            @else
	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
	                        {{ Auth::user()->name }} <span class="caret"></span>
	                    </a>

	                    <ul class="dropdown-menu" role="menu">
	                        <li>
	                            <a href="{{ route('logout') }}"
	                                onclick="event.preventDefault();
	                                         document.getElementById('logout-form').submit();">
	                                Logout
	                            </a>

	                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                {{ csrf_field() }}
	                            </form>
	                        </li>
	                    </ul>
	                </li>
	            @endif
	        </ul>
		</div>
		<div class="menu">
		<div>
			<a href="{{ route('home') }}"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp;Home</a>
			<div id="memSearch">
			<div id="memSearchInput">
			<input id="searchUsername" type="text" autocomplete="off" placeholder="Find Players" >
			</div>
			<div id="memSearchResults"></div>
		</div>
		</div>
		</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="/css/hover.css" rel="stylesheet" media="all">
<link href="/css/effeckt.css" rel="stylesheet" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="https://rawgit.com/moment/moment/develop/min/moment-with-locales.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
 <script src="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/js/bootstrap-datetimepicker.min.js"></script>


<script src="/js/post.js"></script>
<script src="/js/main.js"></script>
