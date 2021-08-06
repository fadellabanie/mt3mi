<div>
    <x-alert class="alert-success"></x-alert>

    <x-auth-validation-errors></x-auth-validation-errors>

    <div class="card card-custom">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    {{ svg('Layers') }}
                </span>
                <h3 class="card-label">
                    {{ __('Basic Data') }}
                </h3>
            </div>
            <!--begin::Toolbar-->
            <div class="card-toolbar">
                <button type="button" class="mr-2 btn btn-info btn-sm" wire:click.prevent="submit" wire:loading.attr="disabled" wire:loading.class="spinner spinner-white spinner-left">{{ __('Save') }}</button>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">
            <form class="form" id="kt_form1">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Name') }}</x-label>
                            <x-input wire:model.defer="name" field='name' />
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Username') }}</x-label>
                            <x-input wire:model.defer="username" field='username' />
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Email') }}</x-label>
                            <x-input type="email" wire:model.defer="email" field='email' />
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Dial Code') }}</x-label>
                            <div class="col-9">
                                <select class="form-control" wire:model.defer="dial_code">
                                    <option></option>
                                    <option value="+966">{{ __("Saudi Arabia (+966)") }}</option>
                                    <option value="+973">{{ __("Bahrain (+973)") }}</option>
                                    <option value="+1">{{ __("United States (+1)") }}</option>
                                    <option value="+971">{{ __("United Arab Emirates (+971)") }}</option>
                                    <option value="+965">{{ __("Kuwait (+965)") }}</option>
                                    <option value="+968">{{ __("Oman (+968)") }}</option>
                                    <option value="+20">{{ __("Egypt (+20)") }}</option>
                                    <option value="+974">{{ __("Qatar (+974)") }}</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Phone') }}</x-label>
                            <x-input type="tel" wire:model.defer="phone" field='phone' />
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Password') }}</x-label>
                            <x-input type="password" wire:model.defer="password" field='password' />
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Subscription End Date') }}</x-label>
                            <x-date-picker field="subscription_end_date" wire:model="subscription_end_date" minDate="new Date()" />
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Attachments') }}</x-label>
                            <x-filepond
                                wire:model="attachments"
                                multiple
                                allowImagePreview
                                imagePreviewMaxHeight="200"
                                allowFileTypeValidation
                                allowFileSizeValidation
                                maxFileSize="2mb"
                            />
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="my-2 col-xl-7">
                        <!--begin::Group-->
                        <div class="form-group row">
                            <x-label>{{ __('Active') }}</x-label>
                            <div class="col-9">
                            <span class="switch switch-sm switch-icon">
                                <label>
                                    <input type="checkbox" wire:model.defer="is_active" />
                                    <span></span>
                                </label>
                            </span>
                            </div>
                        </div>
                        <!--end::Group-->
                    </div>
                </div>
                <!--end::Row-->
            </form>
        </div>
        <!--begin::Card body-->
    </div>
</div>
