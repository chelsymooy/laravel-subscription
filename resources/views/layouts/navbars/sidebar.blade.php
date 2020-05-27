<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('subs') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{route('subs.dashboard.index')}}" class="simple-text logo-normal">
      {{ __('Subscription') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('subs.dashboard.index') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'plans' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('subs.plans.index') }}">
          <i class="material-icons">local_offer</i>
            <p>{{ __('Plan') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'subscriptions' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('subs.subscriptions.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Subscription') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
