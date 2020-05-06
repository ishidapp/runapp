<table class="calendar">
    <thead>
        <tr>
            @foreach ( $weeks as $week )
                @if ( $loop->first )
                    <th class="calendar__head calendar__head--first">{{ $week }}</th>
                @elseif ( $loop->last )
                    <th class="calendar__head calendar__head--last">{{ $week }}</th>
                @else
                    <th class="calendar__head">{{ $week }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ( $calendar as $tr )
        <tr>
            @foreach ( $tr as $td )
                @if ( $td['date'] == $today )
                    <td class="cal-box cal-box--em">
                        <span class="cal-box__date cal-box__date--em">{{ $td['date'] }}</span>
                        @foreach ( $td['records'] as $record )
                            @if ( $auth_id == $record['user_id'] )
                                <a href="{{ route('records.edit', ['record' => $record['id']]) }}"><span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span></a>
                            @else
                                <span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span>
                            @endif
                        @endforeach
                    </td>
                @else
                    @if ( $loop->first )
                        <td class="cal-box">
                            <span class="cal-box__date cal-box__date--first">{{ $td['date'] }}</span>
                            @foreach ( $td['records'] as $record )
                                @if ( $auth_id == $record['user_id'] )
                                    <a href="{{ route('records.edit', ['record' => $record['id']]) }}"><span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span></a>
                                @else
                                    <span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span>
                                @endif
                            @endforeach
                        </td>
                    @elseif ( $loop->last )
                        <td class="cal-box">
                            <span class="cal-box__date cal-box__date--last">{{ $td['date'] }}</span>
                            @foreach ( $td['records'] as $record )
                                @if ( $auth_id == $record['user_id'] )
                                    <a href="{{ route('records.edit', ['record' => $record['id']]) }}"><span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span></a>
                                @else
                                    <span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span>
                                @endif
                            @endforeach
                        </td>
                    @else
                        <td class="cal-box">
                            <span class="cal-box__date">{{ $td['date'] }}</span>
                            @foreach ( $td['records'] as $record )
                                @if ( $auth_id == $record['user_id'] )
                                    <a href="{{ route('records.edit', ['record' => $record['id']]) }}"><span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span></a>
                                @else
                                    <span style="display: block; font-size: 9px; line-height: 1; margin-bottom: 10px;">{{ $record['user']['name'] }}：<br class="sp">{{ $record['distances'] }}km</span>
                                @endif
                            @endforeach
                        </td>
                    @endif
                @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>