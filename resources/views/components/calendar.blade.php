<table class="calendar">
    <thead>
        <tr>
            @foreach ( $weeks as $week )
                <th class="{{ $week['class'] }}">{{ $week['name'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ( $calendar as $calendar_week )
        <tr>
            @foreach ( $calendar_week as $calendar_day )
                <td class="{{ $calendar_day['class']['box'] }}">
                    <div><a href="{{ route('records.create') }}?day={{ $calendar_day['date'] }}" class="{{ $calendar_day['class']['date'] }}">{{ $calendar_day['date'] }}</a></div>
                    <ul style="list-style-type:none; margin:0; padding:0;">
                        @foreach ( $calendar_day['records'] as $record )
                            @if ( $auth_id == $record['user_id'] )
                                <li style="margin:0;"><a href="{{ route('records.edit', ['record' => $record['id']]) }}" style="display: inline-block; font-size: 9px; line-height: 1; margin-bottom: 10px; vertical-align: top;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</a></li>
                            @else
                                <li style="margin:0;"><span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span></li>
                            @endif
                        @endforeach
                    </ul>
                </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>