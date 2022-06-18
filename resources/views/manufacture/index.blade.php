@extends('layouts.app')

@section('content')
    <div class="container">
        @if (\Session::has('error'))
            <div class="alert alert-success">
                <ul style="text-align: center">
                    {!! \Session::get('error') !!}
                </ul>
            </div>
        @endif
        <div class="row justify-content-center" style="width: 120%">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">{{ __('Manufactures') }}
                        <button type="submit" class="btn">
                            <a href="/parser">{{ __('Create Manufactures (API)') }}</a>
                        </button>
                        <button type="submit" class="btn">
                            <a href="/upload/upload-file">{{ __('Upload XML file') }}</a>
                        </button>
                        <button type="submit" class="btn" style="float: right">
                            <a href="/manufacture/create">{{ __('Create new Manufacture') }}</a>
                        </button>
                    </div>

                    <div class="card-body">
                        <table id="selectedColumn" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Mac</th>
                                <th scope="col">Mac format</th>
                                <th scope="col">Full address</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($manufactures as $manufacture)
                                <tr>
                                    <td>
                                        @if($manufacture->getManufactureMacAsHex)
                                            {{ $manufacture->getManufactureMacAsHex->mac  }}<br>
                                        @endif
                                        {{ optional($manufacture->getManufactureMacAsBase)->mac }}
                                    </td>
                                    <td>
                                        @if($manufacture->getManufactureMacAsHex)
                                            {{ $manufacture->getManufactureMacAsHex->address_format }}<br>
                                        @endif
                                        {{ optional($manufacture->getManufactureMacAsBase)->address_format  }}
                                    </td>
                                    <td>
                                        @if($manufacture->getManufactureMacAsHex)
                                            {{ $manufacture->title }}<br>
                                        @endif
                                        @if(optional($manufacture->getManufactureMacAsBase)->address_format)
                                            {{ $manufacture->title }}
                                            {{ $manufacture->getManufactureAddress->street }}
                                            {{ $manufacture->getManufactureAddress->city }}
                                            {{ $manufacture->getManufactureAddress->country }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
