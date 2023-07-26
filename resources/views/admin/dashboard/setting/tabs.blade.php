<ul class="nav justify-content-center nav-pills list-social-scrap">
    @if(user_can_any('setting'))
        <li class="nav-item">
            <a class="nav-link {{activeRoute('dashboard.setting.index')}}" aria-current="page" href="{{route('dashboard.setting.index')}}">General</a>
        </li>
    @endif

    @if(user_can_any('setting'))
    <li class="nav-item">
            <a class="nav-link {{activeRoute('dashboard.controlhome.datatable')}}" href="{{route('dashboard.controlhome.datatable')}}">Home Control</a>
        </li>
    @endif



{{--    @if(user_can_any('our_sponsors'))--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="{{route('dashboard.our-sponsors.index')}}">sponsors</a>--}}
{{--        </li>--}}
{{--    @endif--}}

{{--    @if(user_can_any('contacts'))--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="{{route('dashboard.contacts.index')}}">Contacts</a>--}}
{{--        </li>--}}
{{--    @endif--}}

{{--    @if(user_can_any('pages'))--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="{{route('dashboard.pages.index')}}">Pages</a>--}}
{{--        </li>--}}
{{--    @endif--}}

{{--    @if(user_can_any('statistics'))--}}
        <li class="nav-item">
            <a class="nav-link {{activeRoute('dashboard.statistics.index')}}" href="{{route('dashboard.statistics.index')}}">Statistics</a>
        </li>


{{--    @endif--}}

</ul>
