<!DOCTYPE html>
<html lang="en">

<head>
    @livewireStyles
    @include('admin.dashboard.layouts.includes.head')
</head>

<body>
    <!-- Loading starts -->
    <!-- <div id="loading-wrapper">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div> -->
    <!-- Loading ends -->
    <!-- Page wrapper start -->
    <div class="dashboard" id="dashboardLayout">
        <div class="sidebar-wrapper">
            @include('admin.dashboard.layouts.includes.sidebar')
        </div>
        <div class="content-wrapper">
            <div class="toolbar">
                @include('admin.dashboard.layouts.includes.header')
            </div>
            <div class="content-container">
                @yield('page-header')
                @yield('content')
                @include('admin.dashboard.layouts.includes.footer')
            </div>
        </div>
    </div>
    <!-- Page wrapper end -->
    @include('admin.dashboard.layouts.includes.scripts')





    </script>
    @livewireScripts
</body>

{{--<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
{{--<script src="{{ url('js/app.js') }}"></script>--}}
<script>
    // Echo.channel('notify')
    //     .listen('.send.notify', (data) => {
    //         $('.notifications_list').prepend(`
    //           <div class="notifications-item">
    //                 <div class="text">
    //                     <p> ${data.message.message}</p>
    //                     <span class="date_noti"> ${data.message.created_at} </span>
    //                 </div>
    //             </div>
    // `)
    //         var not_count = $('.notif_count').text();
    //         $('.notif_count').html('')
    //             ++not_count;
    //         $('.notif_count').html(not_count)
    //     });
    //
    //
    //     Echo.channel('campaignvisit')
    //     .listen('.visit.campaign', (data) => {
    //         $('.notifications_list').prepend(`
    //           <div class="notifications-item">
    //                 <div class="text">
    //                     <h4>All Notifications </h4>
    //                     <p> The ${data.influenceName} has visited the ${data.campaignName} </p>
    //                     <span class="date_noti">Ago ${data.notify.created_at} </span>
    //                 </div>
    //             </div>
    // `)
    //
    //         var not_count = $('.notif_count').text();
    //         $('.notif_count').html('')
    //             ++not_count;
    //         $('.notif_count').html(not_count)
    //     });



</script>

</html>
