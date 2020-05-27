<div class="wrapper ">
  @include('subs::layouts.navbars.sidebar')
  <div class="main-panel">
    @include('subs::layouts.navbars.navs.auth')
    @yield('content')
    @include('subs::layouts.footers.auth')
  </div>
</div>