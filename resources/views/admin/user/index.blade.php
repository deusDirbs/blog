@extends('layouts.app')

@section('content')
    <div class="container">
        @if (\Session::has('user-delete'))
            <div class="alert alert-success">
                <ul style="text-align: center">
                    {!! \Session::get('user-delete') !!}
                </ul>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">{{ __('Users') }}
                    <button type="submit" class="btn" style="float: right ">
                        <a href="/admin/user/create" >{{ __('Create new User') }}</a>
                    </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">Middle name</th>
                                <th scope="col">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->middle_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><button><a href="user/edit/{{ $user->id }}">Edit</a></button></td>
                                    <td><button><a href="user/delete/{{ $user->id }}">Delete</a></button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
