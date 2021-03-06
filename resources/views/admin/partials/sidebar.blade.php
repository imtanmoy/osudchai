@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            @can('users_manage')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span class="title">User Management</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        <li class="{{ $request->segment(2) == 'permissions' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">
                        @lang('global.permissions.title')
                        </span>
                            </a>
                        </li>
                        <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.roles.index') }}">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">
                        @lang('global.roles.title')
                        </span>
                            </a>
                        </li>
                        {{--<li class="{{ $request->segment(2) == 'adminusers' ? 'active active-sub' : '' }}">--}}
                        {{--<a href="{{ route('admin.adminusers.index') }}">--}}
                        {{--<i class="fa fa-user"></i>--}}
                        {{--<span class="title">--}}
                        {{--@lang('global.users.title')--}}
                        {{--</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>
                <li class="{{ $request->segment(2) == 'manufacturers' ? 'active' : '' }}">
                    <a href="{{ route('admin.manufacturers.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Manufacturers</span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'product_types' ? 'active' : '' }}">
                    <a href="{{ route('admin.product_types.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Product Types</span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'categories' ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Category</span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'attributes' ? 'active' : '' }}">
                    <a href="{{ route('admin.attributes.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Attributes</span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'options' ? 'active' : '' }}">
                    <a href="{{ route('admin.options.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Options</span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'products' ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Products</span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'order-statuses' ? 'active' : '' }}">
                    <a href="{{ route('admin.order-statuses.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Order Status</span>
                    </a>
                </li>
                <li class="{{ $request->segment(2) == 'orders' ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}">
                        <i class="fa fa-wrench"></i>
                        <span class="title">Orders</span>
                    </a>
                </li>
                {{--<li class="{{ $request->segment(2) == 'discounts' ? 'active' : '' }}">--}}
                {{--<a href="{{ url('/admin/discounts') }}">--}}
                {{--<i class="fa fa-wrench"></i>--}}
                {{--<span class="title">Discounts</span>--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li class="{{ $request->segment(2) == 'orders' ? 'active' : '' }}">--}}
                {{--<a href="{{ url('/admin/orders') }}">--}}
                {{--<i class="fa fa-wrench"></i>--}}
                {{--<span class="title">Orders</span>--}}
                {{--</a>--}}
                {{--</li>--}}
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span class="title">Customer Management</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        {{--<li class="{{ $request->segment(2) == 'customers' ? 'active active-sub' : '' }}">--}}
                        {{--<a href="{{ route('admin.customers.index') }}">--}}
                        {{--<i class="fa fa-briefcase"></i>--}}
                        {{--<span class="title">Customers</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="{{ $request->segment(2) == 'customer_group' ? 'active' : '' }}">--}}
                        {{--<a href="{{ url('/admin/customer_group') }}">--}}
                        {{--<i class="fa fa-wrench"></i>--}}
                        {{--<span class="title">Customer Group</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                </li>
            @endcan

            {{--<li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">--}}
            {{--<a href="{{ route('auth.change_password') }}">--}}
            {{--<i class="fa fa-key"></i>--}}
            {{--<span class="title">Change password</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li>--}}
            {{--<a href="#logout" onclick="$('#logout').submit();">--}}
            {{--<i class="fa fa-arrow-left"></i>--}}
            {{--<span class="title">@lang('global.app_logout')</span>--}}
            {{--</a>--}}
            {{--</li>--}}
        </ul>
    </section>
</aside>
{{--{!! Form::open(['route' => 'admin.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}--}}
{{--<button type="submit">Logout</button>--}}
{{--{!! Form::close() !!}--}}
