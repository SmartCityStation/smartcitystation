<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show " id="sidebar">
    <!-- <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div> -->
    <!--c-sidebar-brand-->

    <div class="c-sidebar-brand d-lg-down-none">
        <label class="c-sidebar-brand-full" width="200" height="50">
            <h1>Phonon</h1>
        </label>
    </div>
    <!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.dashboard')" :active="activeClass(Route::is('admin.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Dashboard')" />
        </li>

        <li class="c-sidebar-nav-item">
            <x-utils.link :href="route('admin.users.index')" class="c-sidebar-nav-link" :text="__('User Management')" :active="activeClass(Route::is('admin.users.index'), 'c-active')" />
        </li>

        @if ($logged_in_user->hasAllAccess() ||
            ($logged_in_user->can('admin.access.user.list') ||
                $logged_in_user->can('admin.access.user.deactivate') ||
                $logged_in_user->can('admin.access.user.reactivate') ||
                $logged_in_user->can('admin.access.user.clear-session') ||
                $logged_in_user->can('admin.access.user.impersonate') ||
                $logged_in_user->can('admin.access.user.change-password')))
            <li class="c-sidebar-nav-title">@lang('System')</li>

            <li
                class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
                <x-utils.link href="#" icon="c-sidebar-nav-icon cil-user" class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Access')" />

                <ul class="c-sidebar-nav-dropdown-items">
                    @if ($logged_in_user->hasAllAccess() ||
                        ($logged_in_user->can('admin.access.user.list') ||
                            $logged_in_user->can('admin.access.user.deactivate') ||
                            $logged_in_user->can('admin.access.user.reactivate') ||
                            $logged_in_user->can('admin.access.user.clear-session') ||
                            $logged_in_user->can('admin.access.user.impersonate') ||
                            $logged_in_user->can('admin.access.user.change-password')))
                    @endif

                    @if ($logged_in_user->hasAllAccess())
                        <li class="c-sidebar-nav-item">
                            <x-utils.link :href="route('admin.auth.role.index')" class="c-sidebar-nav-link" :text="__('Role Management')"
                                :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if ($logged_in_user->hasAllAccess())
            <li class="c-sidebar-nav-dropdown">
                <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle"
                    :text="__('Logs')" />

                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <x-utils.link :href="route('log-viewer::dashboard')" class="c-sidebar-nav-link" :text="__('Dashboard')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-utils.link :href="route('log-viewer::logs.list')" class="c-sidebar-nav-link" :text="__('Logs')" />
                    </li>
                </ul>
            </li>
        @endif

        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon fas fa-cogs" class="c-sidebar-nav-dropdown-toggle"
                :text="__('Settings')" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.typeVariables.index')" class="c-sidebar-nav-link"
                        :text="__('Variable')" :active="activeClass(Route::is('admin.typeVariables.index.*'), 'c-active')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.dataVariables.index')" class="c-sidebar-nav-link"
                        :text="__('Variable Type')" :active="activeClass(Route::is('admin.dataVariables.index.*'), 'c-active')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.devices.index')" class="c-sidebar-nav-link"
                        :text="__('Device')" :active="activeClass(Route::is('admin.devices.index.*'), 'c-active')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.villages.index')" class="c-sidebar-nav-link"
                        :text="__('Village')" :active="activeClass(Route::is('admin.villages.index.*'), 'c-active')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.areas.index')" class="c-sidebar-nav-link"
                        :text="__('Area')" :active="activeClass(Route::is('admin.areas.index.*'), 'c-active')" />
                </li>

                {{-- <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.variableDevices.index')" class="c-sidebar-nav-link"
                        :text="__('Device with Variables')" :active="activeClass(Route::is('admin.variableDevices.index.*'), 'c-active')" />
                </li> --}}

                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.eventLogs.index')" class="c-sidebar-nav-link"
                        :text="__('Event logs')" :active="activeClass(Route::is('admin.eventLogs.index.*'), 'c-active')" />
                </li>

            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon fas fa-users" class="c-sidebar-nav-dropdown-toggle"
                :text="__('Customers')" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.customers.index')" class="c-sidebar-nav-link"
                        :text="__('Customer management')" :active="activeClass(Route::is('admin.customers.index.*'), 'c-active')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.projects.index')" class="c-sidebar-nav-link"
                        :text="__('Project management')" :active="activeClass(Route::is('admin.projects.index.*'), 'c-active')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link icon="c-sidebar-nav-icon" :href="route('admin.locationDevices.index')" class="c-sidebar-nav-link"
                        :text="__('Devices Location')" :active="activeClass(Route::is('admin.locationDevices.index.*'), 'c-active')" />
                </li>

            </ul>
        </li>


    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
        data-class="c-sidebar-minimized"></button>
</div>
<!--sidebar-->
