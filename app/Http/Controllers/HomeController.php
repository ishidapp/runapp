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
                    'box' => 'cal-box',
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
            $box_class = Carbon::now()->day == $i ? 'cal-box cal-box--em' : 'cal-box';
            if ( empty($calendar[$week]) ) {
                $date_class = 'cal-box__date cal-box__date--first';
            } elseif ( count($calendar[$week]) == (DAYS_OF_WEEK - 1) ) {
                $date_class = 'cal-box__date cal-box__date--last';
            } else {
                $date_class = 'cal-box__date';
            }
            $calendar[$week][] = [
                'date'    => $i,
                'class'   => [
                    'box'  => $box_class,
                    'date' => $date_class,
                ],
                'records' => Record::with('user')->where('date', $format_date)->get()->toArray(),
            ];
        }

        //月末日以降の値を空にする
        for ( $i = count($calendar[$week]); $i < DAYS_OF_WEEK; $i++ ) {
            $calendar[$week][] = [
                'date'    => '',
                'class'   => [
                    'box' => 'cal-box',
                    'date' => '',
                ],
                'records' => [],
            ];
        }
        
        $weeks = [
            ['name' => '日', 'class' => 'calendar__head calendar__head--first'],
            ['name' => '月', 'class' => 'calendar__head'],
            ['name' => '火', 'class' => 'calendar__head'],
            ['name' => '水', 'class' => 'calendar__head'],
            ['name' => '木', 'class' => 'calendar__head'],
            ['name' => '金', 'class' => 'calendar__head'],
            ['name' => '土', 'class' => 'calendar__head calendar__head--last'],
        ];

        $from = $start_date->format('Y-m-d');
        $to = $end_date->format('Y-m-d');
        $monthly_data = Record::getMonthlyData($from, $to);

        return view('home', [
            'auth_id'      => Auth::user()->id,
            'monthly_data' => $monthly_data,
            'weeks'        => $weeks,
            'calendar'     => $calendar,
            'year'         => Carbon::now()->year,
            'month'        => Carbon::now()->month,
            'today'        => Carbon::now()->day,
        ]);
    }
}
