@extends('layouts.app')

@section('content')
    <div class="container">
        @if (\Session::has('error'))
            <div class="alert alert-warning">
                <ul style="text-align: center">
                    {!! \Session::get('error') !!}
                </ul>
            </div>
        @endif
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul style="text-align: center;">
                        {!! \Session::get('success') !!}
                    </ul>
                </div>
            @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create new Manufacture') }}
                        <button type="submit" class="btn" style="float: right ">
                            <a href="/manufactures" >{{ __('Back') }}</a>
                        </button>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('save-manufacture') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('mac') }}</label>

                                <div class="col-md-6">
                                    <input id="mac" type="text" class="form-control @error('mac') is-invalid @enderror" name="mac" value="{{ old('mac') }}" required autocomplete="mac" autofocus>

                                    @error('mac')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('address_format') }}</label>

                                <div class="col-md-6">
                                    <input id="address_format" type="text" class="form-control @error('address_format') is-invalid @enderror" name="address_format" value="{{ old('address_format') }}" required autocomplete="address_format" autofocus>

                                    @error('address_format')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-end">{{ __('street') }}</label>

                                <div class="col-md-6">
                                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street" autofocus>

                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('city') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('country') }}</label>

                                <div class="col-md-6">
                                    <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required autocomplete="country">

                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
