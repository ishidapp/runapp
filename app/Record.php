<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Record extends Model
{
    protected $table = 'Records';

    public function user() {
        return $this->belongsTo('App\User');
    }
    public static function getMonthlyData($from, $to)
    {
        $data = DB::table('records as r')
            ->select('r.user_id as user_id', 'u.name as name', DB::raw('sum(r.distances) as distances'))
            ->join('users as u', 'u.id', '=', 'r.user_id')
            ->whereBetween('r.date', [$from, $to])
            ->groupBy('r.user_id', 'u.name')
            ->get()
            ->toArray();
        return $data;
    }
}
