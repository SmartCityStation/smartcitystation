<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered mb-0">
        <tr>
            <th>@lang('Type')</th>
            <td>@include('backend.auth.user.includes.type', ['user' => $logged_in_user])</td>
        </tr>

        <tr>
            <th>@lang('Name')</th>
            <td>{{ $logged_in_user->name }}</td>
        </tr>

        @if ($logged_in_user->surname)
        <tr>
            <th>@lang('Surname')</th>
            <td>{{ $logged_in_user->surname }}</td>
        </tr>
        @endif

        @if ($logged_in_user->phone)
        <tr>
            <th>@lang('phone')</th>
            <td>{{ $logged_in_user->phone }}</td>
        </tr>
        @endif

        @if ($logged_in_user->address)
        <tr>
            <th>@lang('address')</th>
            <td>{{ $logged_in_user->address }}</td>
        </tr>
        @endif

        <tr>
            <th>@lang('E-mail Address')</th>
            <td>{{ $logged_in_user->email }}</td>
        </tr>

       
    </table>
</div><!--table-responsive-->
