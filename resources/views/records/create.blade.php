@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ( count($errors) > 0 )
                <p>入力に問題があります。再入力してください。</p>
            @endif
            <div class="card">
                <div class="card-header">走行距離の登録</div>
                <div class="card-body">
                    <form action="{{ route('records.create') }}" method="POST">
                        @csrf
                        <table>
                            <tr>
                                <th><label for="date">記録日：</label></th>
                                <td>
                                    <input type="text" id="date" name="date" value="{{ old('date', $today) }}" />
                                    @if ( $errors->has('date') )
                                        <span style="color:red;">{{ $errors->first('date') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th><label for="distance">走行距離：</label></th>
                                <td>
                                    <input type="text" id="distance" name="distance" value="{{ old('distance') }}" />km
                                    @if ( $errors->has('distance') )
                                        <span style="color:red;">{{ $errors->first('distance') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td><input type="submit" value="送信" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
