<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Art Share</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{asset("css/main.css")}}" />
</head>

<body id="top">


<!-- Banner -->
<!--
    To use a video as your background, set data-video to the name of your video without
    its extension (eg. images/banner). Your video must be available in both .mp4 and .webm
    formats to work correctly.
-->
<section id="banner" data-video={{asset("css/images/darkvisual")}}>
    <div class="inner">
        <header>
            <h1>Art Share</h1>
            <p>@if (Auth::check()) <b>Hello {{Auth::user()->name}}!</b> <br> Your beautiful creations are ready to be shared with the world. @else A platform to share any type of art and feedback. <a href="{{route('register')}}" class="icon"><b>Register</b></a> for free now! @endif</p>

                <ul class="icons">
                    <li><a href="{{route('art')}}" class="icon"><p>Home</p></a></li>
                    <li><a href="{{route('upload')}}" class="icon"><p>Upload</p></a></li>
                    <li><a href="{{route('search')}}" class="icon"><p>Search</p></a></li>
                    <li><a href="{{route('profile')}}" class="icon"><p>@if (Auth::check()) Profile @else Login @endif </p></a></li>
                    <li><a href="{{route('about')}}" class="icon"><p>About</p></a></li>
                </ul>


        </header>
        <a href="#main" class="more">Learn More</a>

        @if($errors->any())
            <div class="error">
                <h2 class="text-danger" id="error">{{$errors->first()}}</h2>
            </div>
        @endif

    </div>
</section>


<!-- Main -->
<div id="main">
    <div class="inner">

    @yield('content')

        </div>

    </div>

<!-- Footer -->
<footer id="footer">
    <div class="inner">
        <h2>What is Art Share?</h2>
        <p>Art Share is a platform for any type of creative person to upload their creations in image format, and also leaving constructive feedback on other artists their work. Please be respectable and keep your feedback constructive.</p>

        <ul class="icons">
            <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
            <li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
        </ul>
        <p class="copyright">&copy; <a href="{{route('about')}}">333ak</a>.</p>
    </div>
</footer>

<!-- Scripts -->
<script src={{asset("js/jquery.min.js")}}></script>
<script src={{asset("js/jquery.scrolly.min.js")}}></script>
<script src={{asset("js/jquery.poptrox.min.js")}}></script>
<script src={{asset("js/skel.min.js")}}></script>
<script src={{asset("js/util.js")}}></script>
<script src={{asset("js/main.js")}}></script>

</body>
</html>
