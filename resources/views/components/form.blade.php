@if(isset($form))
    <form id="form-{{$form->id}}" action="{{ route('form.submit', $form) }}" class="form form-sub" method="POST" enctype="multipart/form-data">
        @if (session('convention-subcription-message'))
            <div class="alert alert-success">
                {{ session('convention-subcription-message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="line--filters"></div>
        @csrf
        @honeypot
        @foreach($form->steps as $step)
            <div>
                @if($form->steps->count() > 1)
                    <h2>{{ $step->name }}</h2>
                @endif

                @foreach($step->sections as $section)
                    <fieldset class="section" id="form-section-{{ $section->id }}">
                        <h3 class="section-title">{{ $section->name }}</h3>
                        <div class="section-container">
                            @foreach($section->fields as $field)
                                <div id="field-{{ $field->id }}-container" class="field-container {{ 'col-span-'.$field->column }} {{ $field->type === \App\Enums\FieldTypeEnum::select()->value ? 'select--content' : '' }}">
                                    @if($field->label && $field->type !== \App\Enums\FieldTypeEnum::switch()->value && $field->type !== \App\Enums\FieldTypeEnum::title()->value)
                                        <label for="field-{{ $field->id }}">{{ $field->label }}@if($field->is_required) * @endif</label>
                                    @endif

                                    @if($field->type === \App\Enums\FieldTypeEnum::title()->value)
                                        <h4 class="section-title">{{ $field->label }}</h4>
                                    @endif

                                    @php $model = explode('.', $field->model_reference)[0] @endphp

                                    @if(
                                        $field->type === \App\Enums\FieldTypeEnum::text()->value ||
                                        $field->type === \App\Enums\FieldTypeEnum::email()->value ||
                                        $field->type === \App\Enums\FieldTypeEnum::password()->value
                                    )
                                        <input
                                            id="field-{{ $field->id }}"
                                            name="field-{{ $field->id }}"
                                            value="{{ isset($$model) ? $$model[explode('.', $field->model_reference)[1]] : old('field-'.$field->id) }}"
                                            type="{{ \App\Enums\FieldTypeEnum::toArray()[$field->type] }}"
                                            placeholder="{{ $field->placeholder }}"
                                            {{ $field->is_required ? 'required="required"' : '' }}
                                        />

                                        @if($field->type === \App\Enums\FieldTypeEnum::email()->value && $alreadyAskConnection === false)
                                                <p>
                                                    Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez vous!</a>
                                                </p>
                                                <input
                                                    type="password"
                                                    name="password"
                                                    placeholder="Mot de passe"
                                                    value=""
                                                    required
                                                />

                                                <input
                                                    type="password"
                                                    name="password_confirmation"
                                                    placeholder="Confirmation du mot de passe"
                                                    value=""
                                                    required
                                                />
                                            @php $alreadyAskConnection = true @endphp
                                        @endif
                                    @endif
                                    {{--TODO : add suffix, prefix--}}
                                    @if( $field->type === \App\Enums\FieldTypeEnum::number()->value )
                                        <input
                                            id="field-{{ $field->id }}"
                                            name="field-{{ $field->id }}"
                                            value="{{ isset($$model) ? $$model[explode('.', $field->model_reference)[1]] : old('field-'.$field->id) }}"
                                            type="number"
                                            placeholder="{{ $field->placeholder }}"
                                            {{ $field->is_required ? 'required="required"' : '' }}
                                        />
                                    @endif

                                    @if( $field->type === \App\Enums\FieldTypeEnum::textarea()->value )
                                        <textarea
                                            id="field-{{ $field->id }}"
                                            name="field-{{ $field->id }}"
                                            placeholder="{{ $field->placeholder }}"
                                            {{ $field->is_required ? 'required="required"' : '' }}
                                        >{{ isset($$model) ? $$model[explode('.', $field->model_reference)[1]] : old('field-'.$field->id) }}
                                        </textarea>
                                    @endif

                                    @if($field->type === \App\Enums\FieldTypeEnum::select()->value)
                                        <select
                                            id="field-{{ $field->id }}"
                                            name="field-{{ $field->id }}{{ $field->has_multiple_choices ? '[]' : '' }}"
                                            class="form-select"
                                            {{ $field->has_multiple_choices ? 'multiple="multiple"' : '' }}
                                            {{ $field->is_required ? 'required="required"' : '' }}
                                        >
                                            <option></option>
                                            @foreach($field->options as $option)
                                                <option
                                                    value="option-{{ $option->id }}"
                                                    {{ ($option->amount && $option->amount - $option->answers->count() <= 0) ? 'disabled=disabled' : ''}}
                                                    {{ old('field-'.$field->id) === 'option-'.$option->id ? 'selected=selected' : '' }}
                                                ">
                                                    {{ $option->label }}
                                                    @if($option->price)
                                                        - {{ $option->price }} €
                                                    @endif
                                                    @if($option->amount)
                                                        - {{ $option->answers->count() }}/{{ $option->amount }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif

                                    @if( $field->type === \App\Enums\FieldTypeEnum::checklist()->value )
                                        <div class="field-checklist {{ $field->has_multiple_choices ? 'multiple' : ''}}" id="field-{{ $field->id }}">
                                            @foreach($field->options as $option)
                                                <label for="option-{{ $option->id }}" class="{{ ($option->amount && $option->amount - $option->answers->count() <= 0) ? '-disabled' : ''}}">
                                                    <input
                                                        type="{{ $field->has_multiple_choices ? 'checkbox' : 'radio'}}"
                                                        name="field-{{ $field->id }}{{ $field->has_multiple_choices ? '[]' : '' }}"
                                                        id="option-{{ $option->id }}"
                                                        value="option-{{ $option->id }}"
                                                        {{ old('field-'.$field->id) === 'option-'.$option->id ? 'checked=checked' : '' }}
                                                        {{ ($option->amount && $option->amount - $option->answers->count() <= 0) ? 'disabled=disabled' : ''}}
                                                        {{ $field->is_required ? 'required=required' : '' }}
                                                    >
                                                    {{ $option->label }}
                                                    @if($option->price)
                                                        - {{ $option->price }} €
                                                    @endif
                                                    @if($option->amount)
                                                        - {{ $option->answers->count() }}/{{ $option->amount }}
                                                    @endif
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if( $field->type === \App\Enums\FieldTypeEnum::switch()->value )
                                        <h5>{!! $field->label !!}@if($field->is_required) * @endif</h5>
                                        <label for="field-{{ $field->id }}" class="switch-button">
                                            <input id="field-{{ $field->id }}"
                                                   name="field-{{ $field->id }}"
                                                   value="{{ $field->id}}"
                                                   {{ old('field-'.$field->id) === $field->id ? 'checked=checked' : '' }}
                                                   {{ $field->is_required ? 'required=required' : '' }}
                                                   type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    @endif

                                    @if( $field->type === \App\Enums\FieldTypeEnum::date()->value )
                                        <input
                                            id="field-{{ $field->id }}"
                                            name="field-{{ $field->id }}"
                                            value="{{ old('field-'.$field->id) }}"
                                            type="text"
                                            class="date-pckr"
                                            placeholder="{{ $field->placeholder }}"
                                            {{ $field->is_required ? 'required=required' : '' }}
                                        />
                                    @endif

                                    @if( $field->type === \App\Enums\FieldTypeEnum::time()->value )
                                        <input
                                            id="field-{{ $field->id }}"
                                            name="field-{{ $field->id }}"
                                            value="{{ old('field-'.$field->id) }}"
                                            type="time"
                                            placeholder="{{ $field->placeholder }}"
                                            {{ $field->is_required ? 'required="required"' : '' }}
                                        />
                                    @endif

                                    @if( $field->type === \App\Enums\FieldTypeEnum::filepckr()->value )
                                        <input
                                            id="field-{{ $field->id }}"
                                            name="field-{{ $field->id }}"
                                            type="file"
                                            class="filepond-pckr"
                                            placeholder="{{ $field->placeholder }}"
                                            {{ $field->is_required ? 'required="required"' : '' }}
                                        />
                                    @endif

                                    @if($field->type === \App\Enums\FieldTypeEnum::phone()->value)
                                        <div class="form-phoneSelector">
                                            <div class="select--content">
                                                <select
                                                    id="field-{{ $field->id }}[prefix]"
                                                    name="field-{{ $field->id }}[prefix]"
                                                    class="form-select-prefix"
                                                >
                                                    @foreach(config('slym.prefixes') as $prefix)
                                                        <option
                                                            value="{{ $prefix['value'] }}"
                                                            data-country="{{ $prefix['country'] }}"
                                                            {{ old('field-'.$field->id.'[prefix]') === $prefix['value'] ? 'selected=selected' : '' }}
                                                        >{{ $prefix['value'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <input
                                                    id="field-{{ $field->id }}[phone]"
                                                    name="field-{{ $field->id }}[phone]"
                                                    value="{{ old('field-'.$field->id.'[phone]') }}"
                                                    type="text"
                                                    placeholder="{{__("4758963")}}"
                                                >
                                            </div>
                                        </div>
                                    @endif

                                    {{--TODO : add editor --}}

                                    @if($field->tooltip)
                                        <small class="tooltip">{{ $field->tooltip }}</small>
                                    @endif
                                </div>
                            @endforeach

                        </div>
                    </fieldset>
                @endforeach
            </div>
        @endforeach
        @if($form->is_summable)
            <div class="total">
                <p>Total</p>
                <p class="form-total"></p>
            </div>
        @endif
        <button class="btn" type="submit">
            <x-content name="conventions-subscription-form-CTA-label">
                Réserver maintenant
            </x-content>
        </button>
        <input type="hidden" id="form-data" value="<?php echo base64_encode(json_encode($form->load(['steps.sections.fields.rules.option', 'steps.sections.fields.options']))); ?>">
    </form>
@endif
