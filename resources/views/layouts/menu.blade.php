<li class="nav-item">
    <a href="{{ route('admin.typeVariables.index') }}"
       class="nav-link {{ Request::is('backend/typeVariables*') ? 'active' : '' }}">
        <p>@lang('Type Variables')</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.dataVariables.index') }}"
       class="nav-link {{ Request::is('backend/dataVariables*') ? 'active' : '' }}">
        <p>Data Variables</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.devices.index') }}"
       class="nav-link {{ Request::is('backend/devices*') ? 'active' : '' }}">
        <p>Devices</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.villages.index') }}"
       class="nav-link {{ Request::is('backend/villages*') ? 'active' : '' }}">
        <p>Villages</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.areas.index') }}"
       class="nav-link {{ Request::is('backend/areas*') ? 'active' : '' }}">
        <p>Areas</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.locationDevices.index') }}"
       class="nav-link {{ Request::is('backend/locationDevices*') ? 'active' : '' }}">
        <p>Location Devices</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.variableDevices.index') }}"
       class="nav-link {{ Request::is('backend/variableDevices*') ? 'active' : '' }}">
        <p>Variable Devices</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.measures.index') }}"
       class="nav-link {{ Request::is('frontend/measures*') ? 'active' : '' }}">
        <p>Measures</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.eventLogs.index') }}"
       class="nav-link {{ Request::is('backend/eventLogs*') ? 'active' : '' }}">
        <p>Event Logs</p>
    </a>
</li>


