<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RecordRequest;
use App\Record;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable as Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RecordController extends Controller
{
    public function showCreateFrom(Request $request): View
    {
        $query_date = Carbon::today()->setDay($request->day)->format("Y-m-d");
        return view('records/create', [
            'query_date' => $query_date,
        ]);
    }

    public function create(RecordRequest $request): RedirectResponse
    {
        $record = new Record();
        $record
            ->fill(['user_id' => Auth::user()->id] + $request->validated())
            ->save();
        return redirect()->route('home');
    }

    public function showEditFrom(Record $record): View
    {
        return view('records/edit', [
            'record' => $record
        ]);
    }

    public function edit(Record $record, RecordRequest $request): RedirectResponse
    {
        $record
            ->fill($request->validated())
            ->save();
        return redirect()->route('home');
    }

    public function delete(Record $record): RedirectResponse
    {
        $record->delete();
        return redirect()->route('home');
    }
}
