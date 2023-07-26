<header>
    <div class="btn-container">
        <button class="toggle-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>
    <div class="user-info">
        <a href="{{route('dashboard.set_countries_session', ['reset' => true])}}" class="btn text-white" title="Reset"><i class="fa-solid fa-filter-circle-xmark"></i></a>
        <button id="clickHeaderSelect" class="btn mr-1"><i class="fa fa-search-plus"></i></button>
        <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3"
            multiselect-hide-x="false" name="header_country_id" id="header_country_id"
            class="header_country_id_class Custom_Select_box" placeholder="Select">
            @foreach ($countries_active as $country)
                @php
                    $countries = session()->get('country');
                @endphp
                <option value={{ $country->id }} data-flag="{{ $country->code }}"
                    @if ($countries) @foreach ($countries as $cou) {{ $cou == $country->id ? 'selected' : '' }} @endforeach @endif>
                    {{ $country->name }} </option>
            @endforeach
        </select>
        @inject('Notify', 'App\Models\Notification')
        @php
            $notifications = $Notify->orderBy('id','DESC')->where('is_read', 0)->get(['message', 'created_at']);
        @endphp
        <div class="notification" id="_notfi-box" style=" position: relative;">
            <button
                style="position: relative;
            outline: none;
            border-radius: 10px;
            background-color: transparent;"
                class="_btn">
                <span class="icon" style=" color: #fff;
                font-size: 20px;">
                    <i class="fas fa-bell"></i>
                </span>
                <span class="notif_count"
                    style=" position: absolute;
                top: -6px;
                right: -4px;
                background: #674b1d;
                color: #fff;
                border-radius: 50%;
                padding: 0.2rem 0.3rem;
                font-size: 10px;
                line-height: 1;">
                    {{ count($notifications) }}
                </span>
            </button>

            <div class="notifications_list">

                @foreach ($notifications as $notification)
                    <div class="notifications-item">
                        <div class="text">
                            <p> {{ $notification->message }}</p>
                            <span class="date_noti"> ago {{ $notification->created_at }} </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>






        <div class="dropdown user-settings">
            <a href="#" id="userSettings" data-toggle="dropdown" aria-haspopup="true" class="img-container">
                <img src="{{ auth()->user()->image }}" class="user-avatar" alt="Avatar">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                <div class="header-profile-actions">
                    <div class="header-user-profile">
                        <div class="header-user">
                            <img src="{{ auth()->user()->image }}" alt="Admin Template">
                        </div>
                        <div class="info">
                            <span>{{ auth()->user()->username }}</span>
                        </div>
                    </div>

                    <a href="{{ route('dashboard.editprofile') }}"><i class="icon-settings1"></i> Edit Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit(); ">
                            <i class="icon-log-out1"></i>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</header>
