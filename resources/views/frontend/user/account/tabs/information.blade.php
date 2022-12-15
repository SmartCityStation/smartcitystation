<x-forms.patch :action="route('frontend.user.profile.update')">
    <div class="form-group row">
        <label for="name" class="col-md-3 col-form-label text-md-right">@lang('Name')</label>

        <div class="col-md-9">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $logged_in_user->name }}" required autofocus autocomplete="name" />
        </div>
    </div><!--form-group-->

    @if ($logged_in_user->canChangeEmail())
        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">@lang('E-mail Address')</label>

            <div class="col-md-9">
                <x-utils.alert type="info" class="mb-3" :dismissable="false">
                    <i class="fas fa-info-circle"></i> @lang('If you change your e-mail you will be logged out until you confirm your new e-mail address.')
                </x-utils.alert>

                <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') ?? $logged_in_user->email }}" required autocomplete="email" />
            </div>
        </div><!--form-group-->
    @endif
    <div class="form-group row">
        <label for="surname" class="col-md-3 col-form-label text-md-right">@lang('Surname')</label>

        <div class="col-md-4">
            <input type="text" name="surname" class="form-control" placeholder="{{ __('Surname') }}" value="{{ old('surname') ?? $logged_in_user->surname }}"   />
        </div>

        <label for="phone" class="col-md-1 col-form-label text-md-right">@lang('phone')</label>

        <div class="col-md-4">
            <input type="number" name="phone" class="form-control" placeholder="{{ __('phone') }}" value="{{ old('phone') ?? $logged_in_user->phone }}"   />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="address" class="col-md-3 col-form-label text-md-right">@lang('address')</label>

        <div class="col-md-9">
            <input type="text" name="address" class="form-control" placeholder="{{ __('address') }}" value="{{ old('address') ?? $logged_in_user->address }}"   />
        </div>
    </div><!--form-group-->

    <div class="form-group row mb-0">
        <div class="col-md-12 text-right">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
        </div>
    </div><!--form-group-->
</x-forms.patch>
