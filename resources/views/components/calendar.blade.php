<div class="p-calendar">
    @foreach ( $day_of_week as $day )
        <div class="{{ $day['class'] }}">{{ $day['name'] }}</div>
    @endforeach
    @foreach ( $calendar as $week )
        @foreach ( $week as $date )
            <div class="{{ $date['class']['box'] }}">
                <a href="{{ route('records.create') }}?day={{ $date['date'] }}" class="{{ $date['class']['date'] }}">{{ $date['date'] }}</a>
                <ul class="p-calendar__lists">
                    @foreach ( $date['records'] as $record )
                        <li class="p-calendar__list">
                            @if ( $auth_id == $record['user_id'] )
                                <a class="p-calendar__target" href="{{ route('records.edit', ['record' => $record['id']]) }}">{{ mb_substr($record['user']['name'], 0, 1) }} {{ $record['distances'] }}km</a>
                            @else
                                {{ mb_substr($record['user']['name'], 0, 1) }} {{ $record['distances'] }}km
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endforeach
</div>