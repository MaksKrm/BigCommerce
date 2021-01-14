<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-pjax-version" content="v123">
    <script type="text/javascript">
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

    if (!inIframe()) {
        window.location.replace('https://splitit-bc.iwdfun.com/testUrl/layoutBlade');
    }

    function inIframe() {
        try {
            return window.self !== window.top;
        } catch (e) {
            return true;
        }
    }
    </script>

    @yield('before-head')
</head>

<body>
<div class="wrapper">
    @yield ('navbar')
    <main class="main">
        @yield ('content')
    </main>
</div>


<div class="loader js-loader">
    <div class="loader__spin">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

@yield('before-body')
</body>
</html>
