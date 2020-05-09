@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $year }}年{{ $month }}月</div>
                <div class="card-body">
                    <p><a href="{{ route('users') }}">ユーザー一覧</a></p>
                    <ul>
                        @foreach ( $monthly_data as $data )
                            <li>{{ $data->name }}：{{ $data->distances }}km</li>
                        @endforeach
                    </ul>
                    @component('components.calendar', [
                        'auth_id'  => $auth_id,
                        'weeks'    => $weeks,
                        'calendar' => $calendar,
                        'today'    => $today,
                    ])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
