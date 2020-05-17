<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        define("DAYS_OF_WEEK", 7);

        //当月の日数を取得
        $days = Carbon::now()->daysInMonth;
        //当月の1日を取得
        $start_date = Carbon::now()->startOfMonth();
        //当月の月末日を取得
        $end_date = Carbon::now()->endOfMonth();

        $calendar = [];
        $week = 0;

        //1日開始曜日までの値を空にする
        for ( $i = 0; $i < $start_date->dayOfWeek; $i++ ) {
            $calendar[$week][] = [
                'date'    => '',
                'class'   => [
                    'box' => 'p-calendar__box',
                    'date' => '',
                ],
                'records' => [],
            ];
        }

        //1日から月末日までループ
        for ( $i = 1, $date = $start_date->copy(); $i <= $days; $i++, $date->addDay() ) {
            //日曜日まで進んだら改行
            if ( count($calendar[$week]) === DAYS_OF_WEEK ) {
                $week++;
            }
            $format_date = $date->format('Y-m-d');
            $box_class = Carbon::now()->day == $i ? 'p-calendar__box p-calendar__box--em' : 'p-calendar__box';
            if ( empty($calendar[$week]) ) {
                $date_class = 'p-calendar__head p-calendar__head--first';
            } elseif ( count($calendar[$week]) == (DAYS_OF_WEEK - 1) ) {
                $date_class = 'p-calendar__head p-calendar__head--last';
            } else {
                $date_class = 'p-calendar__head';
            }
            //if ($i === 5) dd(Record::with('user')->where('date', $format_date)->get()->toArray());
            $calendar[$week][] = [
                'date'    => $i,
                'class'   => [
                    'box'  => $box_class,
                    'date' => $date_class,
                ],
                'records' => Record::with('user')->where('date', $format_date)->orderBy('distances', 'desc')->get()->toArray(),
            ];
        }

        //月末日以降の値を空にする
        for ( $i = count($calendar[$week]); $i < DAYS_OF_WEEK; $i++ ) {
            $calendar[$week][] = [
                'date'    => '',
                'class'   => [
                    'box' => 'p-calendar__box',
                    'date' => '',
                ],
                'records' => [],
            ];
        }
        
        $day_of_week = [
            ['name' => '日', 'class' => 'p-calendar__item p-calendar__item--first'],
            ['name' => '月', 'class' => 'p-calendar__item'],
            ['name' => '火', 'class' => 'p-calendar__item'],
            ['name' => '水', 'class' => 'p-calendar__item'],
            ['name' => '木', 'class' => 'p-calendar__item'],
            ['name' => '金', 'class' => 'p-calendar__item'],
            ['name' => '土', 'class' => 'p-calendar__item p-calendar__item--last'],
        ];

        $from = $start_date->format('Y-m-d');
        $to = $end_date->format('Y-m-d');
        $monthly_data = Record::getMonthlyData($from, $to);

        return view('home', [
            'auth_id'      => Auth::user()->id,
            'monthly_data' => $monthly_data,
            'day_of_week'  => $day_of_week,
            'calendar'     => $calendar,
            'year'         => Carbon::now()->year,
            'month'        => Carbon::now()->month,
            'today'        => Carbon::now()->day,
        ]);
    }
}
