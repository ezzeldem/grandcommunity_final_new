<!-- Sidebar wrapper start -->
<div class="overlay" onclick="toggleMenu()"></div>
<aside id="sidebar" class="sidebar" style=" overflow-x: hidden; ">

    <!-- Sidebar brand start  -->
    <a class="logo list-item">
        <div class="icon-container">
            <img src="{{asset('assets/img/brand/logo.png')}}" alt="grand community">
        </div>
        <div class="text-container">
            <div class="text">
                Grand Community
            </div>
        </div>
        <!-- <div class="list-chevron toggle-btn" onclick="toggleMenu()">
            <i class="icon-minus"></i>
        </div> -->
    </a>

    <!-- Sidebar brand end  -->


    <!-- User profile end -->

    <!-- Sidebar content start -->
    <div class="sidebar-content">

        <!-- sidebar menu start -->

        <a href="{{route('dashboard.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-home2"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Home
                </div>
            </div>
        </a>
        @if(user_can_any('admins') )
        <a href="{{route('dashboard.admins.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-person_add"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Admins
                </div>
            </div>
        </a>
        @endif
        @if(user_can_any('operations') )
        <a href="{{route('dashboard.operations.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-users"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Operations
                </div>
            </div>
        </a>
        @endif
        <!-- @if(user_can_any('sales') )
        <a href="{{route('dashboard.sales.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-users"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Sales
                </div>
            </div>
        </a>
        @endif -->
        @if(user_can_any('roles') )
        <a href="{{route('dashboard.roles.index')}}" class="list-item">
            <div class="icon-container">

                <i class="icon-package"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Roles
                </div>
            </div>
        </a>
        @endif

        <!-- @if(user_can_any('offices') )
        <a href="{{route('dashboard.offices.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-package"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Offices
                </div>
            </div>
        </a>
        @endif -->
        @if(user_can_any('influencers') )
        <a href="{{route('dashboard.influences.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-instagram-with-circle"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Influencers
                </div>
            </div>
        </a>
        @endif
        @if(user_can_any('brands') || user_can_any('sub-brands'))
        <a href="#" class="list-item submenu-header" data-toggle="1">
            <div class="icon-container">
                <i class="icon-brightness_auto"></i>
            </div>
            <div class="text-container">
                <div class="text">
                Companies

                </div>
            </div>
            <div class="list-chevron">
                <i class="icon-chevron-down"></i>
            </div>

        </a>
        @endif

        <div class="submenu" data-toggle="1">
            @if(user_can_any('brands'))
            <a href="{{route('dashboard.brands.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Companies
                    </div>
                </div>
            </a>
            @endif
            @if(user_can_any('sub-brands'))
            <a href="{{route('dashboard.sub-brands.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Brands
                    </div>
                </div>

            </a>
            @endif
            {{-- @if(user_can_any('branches'))
                <a href="{{route('dashboard.branches.index')}}" class="list-item">
            <div class="icon-container"></div>
            <div class="text-container">
                <div class="text">
                    Branches
                </div>
            </div>
            </a>
            @endif --}}
        </div>

        @if(user_can_any('campaigns') )
        <a href="{{route('dashboard.campaigns.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-explore"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Campaigns
                </div>
            </div>
        </a>
        @endif

        <!-- @if(user_can_any('tasks'))
        <a href="{{route('dashboard.tasks.index')}}" class="list-item">
            <div class="icon-container">
                <i class="icon-list"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Tasks
                </div>
            </div>
        </a>
        @endif -->



        <a href="#" class="list-item submenu-header" data-toggle="2">
            <div class="icon-container">
                <i class="icon-settings"></i>
            </div>
            <div class="text-container">
                <div class="text">
                    Setting

                </div>
            </div>
            <div class="list-chevron">
                <i class="icon-chevron-down"></i>
            </div>
        </a>

        <div class="submenu" data-toggle="2">
            @if(user_can_any('setting'))
            <a href="{{route('dashboard.setting.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Setting
                    </div>
                </div>
            </a>
            @endif
            @if(user_can_any('faqs'))
            <a href="{{route('dashboard.faqs.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Faqs
                    </div>
                </div>
            </a>
            @endif
            @if(user_can_any('faqs'))
            <a href="{{route('dashboard.caseStudies.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Case Studies
                    </div>
                </div>
            </a>
            @endif
            @if(user_can_any('jobs'))
            <a href="{{route('dashboard.jobs.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Jobs
                    </div>
                </div>
            </a>
            @endif
            <!-- @if(user_can_any('match_campaigns'))
            <a href="{{route('dashboard.match-campaign.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Match Campaigns
                    </div>
                </div>
            </a>
            @endif -->
            @if(user_can_any('our_sponsors'))
            <a href="{{route('dashboard.our-sponsors.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Sponsors
                    </div>
                </div>
            </a>
            @endif

            @if(user_can_any('pages'))
            <a href="{{route('dashboard.pages.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Pages
                    </div>
                </div>
            </a>
            @endif
            @if(user_can_any('articles'))
            <a href="{{route('dashboard.articles.index')}}" class="list-item">
                <div class="icon-container"></div>
                <div class="text-container">
                    <div class="text">
                        Articles
                    </div>
                </div>
            </a>
            @endif
        </div>
        <!-- sidebar menu end -->
		@if(user_can_any('contacts'))
            <a href="{{route('dashboard.contacts.index')}}" class="list-item">
                <div class="icon-container">
				<i class="icon-brightness_auto"></i>
				</div>
                <div class="text-container">
                    <div class="text">
                        Contact us
                    </div>
                </div>
            </a>
            @endif

        <!-- Sidebar content end -->

</aside>
<!-- Sidebar wrapper end -->


@push('js')
<script>
     $(document).ready(function() {
        var url = window.location;
        $('.sidebar .list-item[href="' + url + '"]').addClass('nav_active')
    })

    const onInit = () => {
        let wInnerWith = window.innerWidth
        let dashLayout = document.getElementById("dashboardLayout")
        let contentWrapper = dashLayout.querySelector('.content-wrapper')
        let sidebarWrapper = dashLayout.querySelector('.sidebar-wrapper')
        let submenuHeader = document.querySelectorAll('.submenu-header')
        let submenus = document.querySelectorAll('.submenu')
        let navToggleBtn = document.querySelector('header .btn-container .toggle-btn')

        if (wInnerWith <= 1000) {
            sidebarWrapper.classList.add('mode-over')
            contentWrapper.classList.add('w-full')
        }
        window.addEventListener('resize', () => {
            let wInnerWith = window.innerWidth
            if (wInnerWith > 1000) {
                sidebarWrapper.classList.remove('mode-over')
                contentWrapper.classList.remove('w-full')
                return
            }
            sidebarWrapper.classList.add('mode-over')
            contentWrapper.classList.add('w-full')
        })

        navToggleBtn.addEventListener('click', () => {
            sidebarWrapper.classList.toggle('opened-sidebar')
            contentWrapper.classList.toggle('opened-sidebar')
        })


        //---
        submenuHeader.forEach((item) => {
            item.addEventListener('click', () => {
                submenus.forEach((sub) => {
                    if (sub.getAttribute('data-toggle') == item.getAttribute('data-toggle')) {
                        sub.classList.toggle('active')
                        item.classList.toggle('active')
                    }
                })
            })
        })
    }
    const toggleMenu = () => {
        let dashLayout = document.getElementById("dashboardLayout")
        let contentWrapper = dashLayout.querySelector('.content-wrapper')
        let sidebarWrapper = dashLayout.querySelector('.sidebar-wrapper')

        contentWrapper.classList.toggle('opened-sidebar')
        sidebarWrapper.classList.toggle('opened-sidebar')
    }
    onInit();
</script>
@endpush
