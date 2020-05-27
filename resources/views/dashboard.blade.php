@extends('subs::layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">Total tenants</p>
              <h3 class="card-title">{{ $dashboard['stat']['users'] }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> {{$dashboard['last']['users'] ? $dashboard['last']['users']->diffForHumans() : ''}}
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">info_outline</i>
              </div>
              <p class="card-category">Unpaid invoice</p>
              <h3 class="card-title">{{ $dashboard['stat']['bills'] }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> {{$dashboard['last']['bills']}} invoice(s)
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">content_copy</i>
              </div>
              <p class="card-category">Issued invoice</p>
              <h3 class="card-title">{{ $dashboard['stat']['invoices'] }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">group</i> Issued for {{$dashboard['last']['invoices']}} user(s)
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">toggle_on</i>
              </div>
              <p class="card-category">Active subs</p>
              <h3 class="card-title">{{ $dashboard['stat']['subs'] }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">info_outline</i> {{$dashboard['last']['subs'] ? 'Last unsubscribe '.$dashboard['last']['subs']->diffForHumans() : ''}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Daily Sales</h4>
              <p class="card-category">
                @if($dashboard['rate']['sales'] > 0)
                  <span class="text-success"><i class="fa fa-long-arrow-up"></i> {{$dashboard['rate']['sales']}}% </span> increase in today sales.</p>
                @else
                  <span class="text-danger"><i class="fa fa-long-arrow-down"></i> {{abs($dashboard['rate']['sales'])}}% </span> decrease in today sales.</p>
                @endif
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-warning">
              <div class="ct-chart" id="websiteViewsChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">New Users</h4>
              <p class="card-category">Last Campaign Performance</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header card-header-danger">
              <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Unsubscribe Rate</h4>
              <p class="card-category">Retention Performance</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ asset('subs') }}/demo/demo.css" rel="stylesheet" />
  <link href="{{ asset('subs') }}/demo/pagination.css" rel="stylesheet" />
@endpush

@push('js')
  <!-- Subscription Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{ asset('subs') }}/demo/demo.js"></script>
  <script src="{{ asset('subs') }}/js/settings.js"></script>

  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      if ($('#dailySalesChart').length != 0 || $('#completedTasksChart').length != 0 || $('#websiteViewsChart').length != 0) {
        /* ----------==========     Daily Sales Chart initialization    ==========---------- */

        dataDailySalesChart = {
          labels: {!! json_encode($dashboard['label']) !!},
          series: [
            {!! json_encode($dashboard['graph']['sales']) !!}
          ]
        };

        optionsDailySalesChart = {
          lineSmooth: Chartist.Interpolation.cardinal({
            tension: 0
          }),
          low: 0,
          high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
          chartPadding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
          },
        }

        var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

        md.startAnimationForLineChart(dailySalesChart);



        /* ----------==========     Completed Tasks Chart initialization    ==========---------- */

        dataCompletedTasksChart = {
          labels: {!! json_encode($dashboard['label']) !!},
          series: [
            {!! json_encode($dashboard['graph']['unsubs']) !!}
          ]
        };

        optionsCompletedTasksChart = {
          lineSmooth: Chartist.Interpolation.cardinal({
            tension: 0
          }),
          low: 0,
          high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
          chartPadding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
          }
        }

        var completedTasksChart = new Chartist.Line('#completedTasksChart', dataCompletedTasksChart, optionsCompletedTasksChart);

        // start animation for the Completed Tasks Chart - Line Chart
        md.startAnimationForLineChart(completedTasksChart);


        /* ----------==========     Emails Subscription Chart initialization    ==========---------- */

        var dataWebsiteViewsChart = {
          labels: {!! json_encode($dashboard['label']) !!},
          series: [
            {!! json_encode($dashboard['graph']['users']) !!}
          ]
        };
        var optionsWebsiteViewsChart = {
          axisX: {
            showGrid: false
          },
          low: 0,
          high: 50,
          chartPadding: {
            top: 0,
            right: 5,
            bottom: 0,
            left: 0
          }
        };
        var responsiveOptions = [
          ['screen and (max-width: 640px)', {
            seriesBarDistance: 5,
            axisX: {
              labelInterpolationFnc: function(value) {
                return value[0];
              }
            }
          }]
        ];
        var websiteViewsChart = Chartist.Bar('#websiteViewsChart', dataWebsiteViewsChart, optionsWebsiteViewsChart, responsiveOptions);

        //start animation for the Emails Subscription Chart
        md.startAnimationForBarChart(websiteViewsChart);
      }
    });
  </script>
@endpush
