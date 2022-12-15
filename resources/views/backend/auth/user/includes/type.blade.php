@if ($user->isAdmin())
    @lang('Administrator')
@elseif ($user == 'Visitor')
    @lang('Visitor')
@elseif($user == 'Customer')
    @lang('Customer')
@else
    @lang('N/A')
@endif
