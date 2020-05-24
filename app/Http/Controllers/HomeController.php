<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable as Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        define("DAYS_OF_WEEK", 7);
        $today = Carbon::now();
        $calendar = [];
        $week = 0;

        // 1日までの空データを作成する
        $start_of_month = $today->startOfMonth()->dayOfWeek;
        for ($i = 0; $i < $start_of_month; $i++) {
            $calendar[$week][] = [
                'date'    => '',
                'class'   => [
                    'box'  => 'p-calendar__box',
                    'date' => '',
                ],
                'records' => [],
            ];
        }

        // データを作成する
        $daily_data = Record::fetchDailyDistancesEachUser(
            $today->startOfMonth()->format('Y-m-d'),
            $today->endOfMonth()->format('Y-m-d'),
        );
        $class = [];
        for ($i = 1, $date = $today->startOfMonth(); $i <= $today->daysInMonth; $i++, $date = $date->addDay()) {
            if (count($calendar[$week]) === DAYS_OF_WEEK) {
                $week++;
            }

            $class['box'] = 'p-calendar__box';
            if ($i == $today->day) {
                $class['box'] .= ' p-calendar__box--em';
            }

            $class['date'] = 'p-calendar__head';
            if (empty($calendar[$week])) {
                $class['date'] .= ' p-calendar__head--first';
            } elseif (count($calendar[$week]) == (DAYS_OF_WEEK - 1)) {
                $class['date'] .= ' p-calendar__head--last';
            }

            $records = [];
            foreach ($daily_data as $data) {
                if ($date->format('Y-m-d') == $data['date'] ) {
                    $records[] = $data;
                }
            }
            $calendar[$week][] = [
                'date'    => $i,
                'class'   => $class,
                'records' => $records,
            ];
        }

        // 月末日以降の空データを作成する
        for ($i = count($calendar[$week]); $i < DAYS_OF_WEEK; $i++) {
            $calendar[$week][] = [
                'date'    => '',
                'class'   => [
                    'box'  => 'p-calendar__box',
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

        $monthly_data = Record::fetchDistancesEachUser(
            $today->startOfMonth()->format('Y-m-d'),
            $today->endOfMonth()->format('Y-m-d'),
        );

        return view('home', [
            'auth_id'      => Auth::user()->id,
            'calendar'     => $calendar,
            'day_of_week'  => $day_of_week,
            'monthly_data' => $monthly_data,
            'year'         => $today->year,
            'month'        => $today->month,
            'today'        => $today->day,
        ]);
    }
}
