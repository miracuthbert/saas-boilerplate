<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('layouts.admin.partials._head')
    </head>

    <!-- BODY options, add following classes to body to change options

    // Header options
    1. '.header-fixed'					- Fixed Header

    // Brand options
    1. '.brand-minimized'       - Minimized brand (Only symbol)

    // Sidebar options
    1. '.sidebar-fixed'					- Fixed Sidebar
    2. '.sidebar-hidden'				- Hidden Sidebar
    3. '.sidebar-off-canvas'		- Off Canvas Sidebar
    4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
    5. '.sidebar-compact'			  - Compact Sidebar

    // Aside options
    1. '.aside-menu-fixed'			- Fixed Aside Menu
    2. '.aside-menu-hidden'			- Hidden Aside Menu
    3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

    // Breadcrumb options
    1. '.breadcrumb-fixed'			- Fixed Breadcrumb

    // Footer options
    1. '.footer-fixed'					- Fixed footer

    -->

    <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden footer-fixed">
        <div id="app">
            @include('layouts.admin.partials._header')

            <div class="app-body">
                @include('layouts.admin.partials._sidebar')

                <!-- Main content -->
                <main class="main">

                    @include('layouts.admin.partials._breadcrumb')

                    <div class="container-fluid">
                        <div class="animated fadeIn">
                            @yield('content')
                        </div>
                    </div><!-- /.conainer-fluid -->

                </main>

                @include('layouts.admin.partials._aside')

            </div>

            @include('layouts.admin.partials._footer')
        </div>

        @include('layouts.admin.partials._scripts')
    </body>
</html>
