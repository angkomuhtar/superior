@if(config('layout.self.layout') == 'blank')
    <div class="d-flex flex-column flex-root">
        @yield('content')
    </div>
@else

    @include('metronic-layout.base._header-mobile')

    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">

            @if(config('layout.aside.self.display'))
                @include('metronic-layout.base._aside')
            @endif

            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                @include('metronic-layout.base._header')

                <div class="content {{ Metronic::printClasses('content', false) }} d-flex flex-column flex-column-fluid" id="kt_content">

                    @if(config('layout.subheader.display'))
                        @if(array_key_exists(config('layout.subheader.layout'), config('layout.subheader.layouts')))
                            @include('metronic-layout.partials.subheader._'.config('layout.subheader.layout'))
                        @else
                            @include('metronic-layout.partials.subheader._'.array_key_first(config('layout.subheader.layouts')))
                        @endif
                    @endif

                    @include('metronic-layout.base._content')
                </div>

                @include('metronic-layout.base._footer')
            </div>
        </div>
    </div>

@endif

@if (config('layout.self.layout') != 'blank')

    @if (config('layout.extras.search.layout') == 'offcanvas')
        @include('metronic-layout.partials.extras.offcanvas._quick-search')
    @endif

    @if (config('layout.extras.notifications.layout') == 'offcanvas')
        @include('metronic-layout.partials.extras.offcanvas._quick-notifications')
    @endif

    @if (config('layout.extras.quick-actions.layout') == 'offcanvas')
        @include('metronic-layout.partials.extras.offcanvas._quick-actions')
    @endif

    @if (config('layout.extras.user.layout') == 'offcanvas')
        @include('metronic-layout.partials.extras.offcanvas._quick-user')
    @endif

    @if (config('layout.extras.quick-panel.display'))
        @include('metronic-layout.partials.extras.offcanvas._quick-panel')
    @endif

    @if (config('layout.extras.toolbar.display'))
        @include('metronic-layout.partials.extras._toolbar')
    @endif

    @if (config('layout.extras.chat.display'))
        @include('metronic-layout.partials.extras._chat')
    @endif

    @include('metronic-layout.partials.extras._scrolltop')

@endif
