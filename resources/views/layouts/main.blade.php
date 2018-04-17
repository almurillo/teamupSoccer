<!DOCTYPE html>
<html>
<head>
	<meta property="og:site_name" content="<TeamUp Soccer">
	<meta property="og:title" content="Welcome to TeamUp Soccer" />
	<meta name="description" property="og:description" content="You can join anytime to play the game that you love SOCCER or simply start a team of your own, anything you need about gathering players and setting up game times is here." />
	<meta property="og:url" content="#" />
	<meta property="og:image" itemprop="image" content="#" />
	<meta property="og:image:width" content="50" />
	<meta property="og:image:height" content="50" />
	<meta charset="UTF-8">
	<title>TeamUp Soccer @yield('title')</title>

<!-- Latest compiled and minified JavaScript -->

	<link rel="icon" href="favicon.ico" type="image/x-icon">

	 <link href="{{ asset('css/app.css') }}" rel="stylesheet">

	 <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
@include('layouts.topMenu')

<div id="pagemiddle">
<div id="pagemiddleleft">

@yield('content')

</div>

@include ('layouts.sidebar')

</div>
</div>
</body>
</html>
