<!-- Device Code Field -->
<div class="col-sm-12">
    {!! Form::label('customer', __('Customer:')) !!}
    <p>{{ $project->usName }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('Name project:')) !!}
    <p>{{ $project->proName }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('Description:')) !!}
    <p>{{ $project->description }}</p>
</div>

<!-- Company Field -->
<div class="col-sm-12">
    {!! Form::label('company', __('Company:')) !!}
    <p>{{ $project->company }}</p>
</div>


<!-- Start date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', __('Start date:')) !!}
    <p>{{ $project->start_date }}</p>
</div>

<!-- End date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', __('End date:')) !!}
    <p>{{ $project->end_date }}</p>
</div>
