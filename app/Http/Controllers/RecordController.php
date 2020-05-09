<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RecordRequest;
use App\Record;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecordController extends Controller
{
    public function showCreateFrom(Request $request) {
        //$today = Carbon::today()->format('Y-m-d');
        $query_date = Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, $request->day)->format("Y-m-d");
        return view('records/create', [
            'query_date' => $query_date,
            //'today' => $today,
        ]);
    }

    public function create(RecordRequest $request) {
        $record = new Record();
        $record->user_id = Auth::user()->id;
        $record->date = $request->date;
        $record->distances = $request->distance;
        $record->save();
        return redirect()->route('home');
    }

    public function showEditFrom(Record $record) {
        return view('records/edit', [
            'record' => $record
        ]);
    }

    public function edit(Record $record, RecordRequest $request) {
        $record->date = $request->date;
        $record->distances = $request->distance;
        $record->save();
        return redirect()->route('home');
    }

    public function delete(Record $record) {
        $record->delete();
        return redirect()->route('home');
    }
}
