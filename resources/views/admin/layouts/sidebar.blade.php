<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        @php
            $notifications = \App\Models\OrderPlacedNotification::where('seen', 0)->latest()->take(10)->get();
            $unseenMessages = \App\Models\Chat::where(['receiver_id' => auth()->user()->id, 'seen' => 0])->count();
        @endphp

        <li class="dropdown dropdown-list-toggle">
            <a href="{{ route('admin.chat.index') }}"
                class="nav-link nav-link-lg message-envelope {{ $unseenMessages > 0 ? 'beep' : '' }}">
                <i class="far fa-envelope"></i>
            </a>
        </li>

        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg notification_beep {{ count($notifications) > 0 ? 'beep' : '' }}">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="{{ route('admin.clear-notification') }}">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons rt_notification">

                    @forelse ($notifications as $notification)
                        <a href="{{ route('admin.orders.show', $notification->order_id) }}" class="dropdown-item">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ $notification->message }}
                                <div class="time">{{ date('h:i A | d-F-Y', strtotime($notification->created_at)) }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center w-100"
                            style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%; color: #98a6ad;">
                            <i class="far fa-bell-slash mb-2" style="font-size: 30px; opacity: 0.5;"></i>
                            <h6 class="mb-0" style="font-weight: 500;">No new notifications</h6>
                            <small>We'll notify you when something arrives.</small>
                        </div>
                    @endforelse

                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('admin.orders.index') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image"
                    src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('default-avatar.jpg') }}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('admin.setting.index') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#"
                        onclick="event.preventDefault();
                    this.closest('form').submit();"
                        class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>


<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">{{ config('settings.site_name') }}</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ setSidebarActive(['admin.dashboard']) }}"><a class="nav-link"
                    href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
            @can('manage sliders')
                <li class="menu-header">Starter</li>
                <li class="{{ setSidebarActive(['admin.slider.*']) }}"><a class="nav-link"
                        href="{{ route('admin.slider.index') }}"><i class="fas fa-sliders-h"></i><span>Slider</span></a>
                </li>
            @endcan

            @can('manage daily offers')
                <li class="{{ setSidebarActive(['admin.daily-offer.*']) }}"><a class="nav-link"
                        href="{{ route('admin.daily-offer.index') }}"><i class="fas fa-tags"></i><span>Daily
                            Offers</span></a></li>
            @endcan

            @can('view products')
                <li
                    class="dropdown {{ setSidebarActive(['admin.category.*', 'admin.product.*', 'admin.product-reviews.index']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-shopping-cart"></i><span>Manage Products </span></a>
                    <ul class="dropdown-menu">
                        @can('view categories')
                            <li class="{{ setSidebarActive(['admin.category.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.category.index') }}">Product Categories</a></li>
                        @endcan
                        @can('view products')
                            <li class="{{ setSidebarActive(['admin.product.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.product.index') }}">Products</a></li>
                        @endcan
                        <li class="{{ setSidebarActive(['admin.product-reviews.index']) }}"><a class="nav-link"
                                href="{{ route('admin.product-reviews.index') }}">Product Reviews</a></li>
                    </ul>
                </li>
            @endcan

            @can('view orders')
                <li
                    class="dropdown {{ setSidebarActive(['admin.orders.index', 'admin.pending-orders', 'admin.inprocess-orders', 'admin.delivered-orders', 'admin.declined-orders']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-box"></i><span>Orders </span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.orders.index']) }}"><a class="nav-link"
                                href="{{ route('admin.orders.index') }}">All Orders</a></li>
                        <li class="{{ setSidebarActive(['admin.pending-orders']) }}"><a class="nav-link"
                                href="{{ route('admin.pending-orders') }}">Pending Orders</a></li>
                        <li class="{{ setSidebarActive(['admin.inprocess-orders']) }}"><a class="nav-link"
                                href="{{ route('admin.inprocess-orders') }}">In Process Orders</a></li>
                        <li class="{{ setSidebarActive(['admin.delivered-orders']) }}"><a class="nav-link"
                                href="{{ route('admin.delivered-orders') }}">Delivered Orders</a></li>
                        <li class="{{ setSidebarActive(['admin.declined-orders']) }}"><a class="nav-link"
                                href="{{ route('admin.declined-orders') }}">Decliend Orders</a></li>
                    </ul>
                </li>
            @endcan

            @can('manage ecommerce')
                <li
                    class="dropdown {{ setSidebarActive(['admin.coupon.*', 'admin.delivery-area.*', 'admin.payment-setting.index']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-store"></i><span> Manage Ecommerce </span></a>
                    <ul class="dropdown-menu">
                        @can('view coupons')
                            <li class="{{ setSidebarActive(['admin.coupon.*']) }}"><a class="nav-link"
                                    href="{{ route('admin.coupon.index') }}">Coupon</a></li>
                        @endcan
                        <li class="{{ setSidebarActive(['admin.delivery-area.*']) }}"><a class="nav-link"
                                href="{{ route('admin.delivery-area.index') }}">Delivery Areas</a></li>
                        <li class="{{ setSidebarActive(['admin.payment-setting.index']) }}"><a class="nav-link"
                                href="{{ route('admin.payment-setting.index') }}">Payment Gateways</a></li>
                    </ul>
                </li>
            @endcan

            @can('view reservations')
                <li class="dropdown {{ setSidebarActive(['admin.reservation-time.*', 'admin.reservation.index']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-chair"></i><span>Manage Reservations </span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.reservation-time.*']) }}"><a class="nav-link"
                                href="{{ route('admin.reservation-time.index') }}">Reservation Times</a></li>
                        <li class="{{ setSidebarActive(['admin.reservation.index']) }}"><a class="nav-link"
                                href="{{ route('admin.reservation.index') }}">Reservation</a></li>
                    </ul>
                </li>
            @endcan

            @can('access chat')
                <li class="{{ setSidebarActive(['admin.chat.index']) }}"><a class="nav-link"
                        href="{{ route('admin.chat.index') }}"><i
                            class="fas fa-comment-dots"></i><span>Messages</span></a></li>
            @endcan

            @can('view blogs')
                <li
                    class="dropdown {{ setSidebarActive(['admin.blog-category.*', 'admin.blogs.*', 'admin.blogs.comments.index']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-rss"></i><span> Blog </span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.blog-category.*']) }}"><a class="nav-link"
                                href="{{ route('admin.blog-category.index') }}">Categories</a></li>
                        <li class="{{ setSidebarActive(['admin.blogs.*']) }}"><a class="nav-link"
                                href="{{ route('admin.blogs.index') }}">All Blogs</a></li>
                        <li class="{{ setSidebarActive(['admin.blogs.comments.index']) }}"><a class="nav-link"
                                href="{{ route('admin.blogs.comments.index') }}">Comments</a></li>
                    </ul>
                </li>
            @endcan

            @can('manage sections')
                <li
                    class="dropdown {{ setSidebarActive(['admin.why-choose-us.*', 'admin.banner-slider.*', 'admin.chefs.*', 'admin.app-download.*', 'admin.testimonial.*', 'admin.counter.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-stream"></i><span>Sections </span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.why-choose-us.*']) }}"><a class="nav-link"
                                href="{{ route('admin.why-choose-us.index') }}">Why Choose Us</a></li>
                        <li class="{{ setSidebarActive(['admin.banner-slider.*']) }}"><a class="nav-link"
                                href="{{ route('admin.banner-slider.index') }}">Banner Slider</a></li>
                        <li class="{{ setSidebarActive(['admin.chefs.*']) }}"><a class="nav-link"
                                href="{{ route('admin.chefs.index') }}">Chefs</a></li>
                        <li class="{{ setSidebarActive(['admin.app-download.*']) }}"><a class="nav-link"
                                href="{{ route('admin.app-download.index') }}">App Download Section</a></li>
                        <li class="{{ setSidebarActive(['admin.testimonial.*']) }}"><a class="nav-link"
                                href="{{ route('admin.testimonial.index') }}">Testimonial</a></li>
                        <li class="{{ setSidebarActive(['admin.counter.*']) }}"><a class="nav-link"
                                href="{{ route('admin.counter.index') }}">Counter</a></li>
                    </ul>
                </li>
            @endcan

            @can('manage pages')
                <li
                    class="dropdown {{ setSidebarActive(['admin.custom-page-builder.*', 'admin.about.*', 'admin.privacy-policy.*', 'admin.contact.*', 'admin.faq.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-file-alt"></i><span>Pages </span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setSidebarActive(['admin.custom-page-builder.*']) }}"><a class="nav-link"
                                href="{{ route('admin.custom-page-builder.index') }}">Custom Page</a></li>
                        <li class="{{ setSidebarActive(['admin.about.*']) }}"><a class="nav-link"
                                href="{{ route('admin.about.index') }}">About</a></li>
                        <li class="{{ setSidebarActive(['admin.privacy-policy.*']) }}"><a class="nav-link"
                                href="{{ route('admin.privacy-policy.index') }}">Privacy Policy</a></li>
                        <li class="{{ setSidebarActive(['admin.contact.*']) }}"><a class="nav-link"
                                href="{{ route('admin.contact.index') }}">Contact</a></li>
                        <li class="{{ setSidebarActive(['admin.faq.*']) }}"><a class="nav-link"
                                href="{{ route('admin.faq.index') }}">FAQ</a></li>
                    </ul>
                </li>
            @endcan

            <li class="{{ setSidebarActive(['admin.news-letter.index']) }}"><a class="nav-link"
                    href="{{ route('admin.news-letter.index') }}"><i class="fas fa-newspaper"></i><span>News
                        Letter</span></a></li>

            <li class="{{ setSidebarActive(['admin.social-link.*']) }}"><a class="nav-link"
                    href="{{ route('admin.social-link.index') }}"><i class="fas fa-link"></i>
                    <span>Social Links</span></a></li>

            <li class="{{ setSidebarActive(['admin.footer-info.index']) }}"><a class="nav-link"
                    href="{{ route('admin.footer-info.index') }}"> <i class="fas fa-info-circle"></i> <span>Footer
                        Info</span></a></li>

            <li class="{{ setSidebarActive(['admin.menus.*']) }}"><a href="{{ route('admin.menus.index') }}"
                    class="nav-link"><i class="fas fa-list"></i><span>Menu
                        Builder</span></a></li>

            @can('view admins')
                <li class="{{ setSidebarActive(['admin.admin-management.*']) }}"><a class="nav-link"
                        href="{{ route('admin.admin-management.index') }}"><i class="fas fa-user-shield"></i><span>Admin
                            Management</span></a></li>
            @endcan

            @can('view roles')
                <li class="{{ setSidebarActive(['admin.roles.*']) }}"><a class="nav-link"
                        href="{{ route('admin.roles.index') }}"><i class="fas fa-user-lock"></i><span>Role
                            Management</span></a></li>
            @endcan

            @can('manage permissions')
                <li class="{{ setSidebarActive(['admin.permissions.*']) }}"><a class="nav-link"
                        href="{{ route('admin.permissions.index') }}"><i
                            class="fas fa-key"></i><span>Permissions</span></a>
                </li>
            @endcan

            @can('manage settings')
                <li class="{{ setSidebarActive(['admin.setting.index']) }}"><a class="nav-link"
                        href="{{ route('admin.setting.index') }}"><i class="fas fa-cogs"></i><span>Settings</span></a>
                </li>
                <li class="{{ setSidebarActive(['admin.clear-database.index']) }}"><a class="nav-link"
                        href="{{ route('admin.clear-database.index') }}"><i class="fas fa-database"></i><span>Clear
                            Database</span></a></li>
            @endcan
        </ul>
    </aside>
</div>
