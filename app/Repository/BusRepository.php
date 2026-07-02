<?php

namespace App\Repository;

use App\Models\Bus;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class BusRepository implements BusRepositoryInterface
{
    public function index()
    {
        $buses = Bus::withCount('students')->paginate(15);
        return view('pages.Transportation.index', compact('buses'));
    }

    public function create()
    {
        return view('pages.Transportation.create');
    }

    public function store($request)
    {
        Bus::create($request->except('_token'));
        toastr()->success(trans('messages.success'));
        return redirect()->route('buses.index');
    }

    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        return view('pages.Transportation.edit', compact('bus'));
    }

    public function update($request)
    {
        $bus = Bus::findOrFail($request->id);
        $bus->update($request->except('_token', 'id'));
        toastr()->success(trans('messages.Update'));
        return redirect()->route('buses.index');
    }

    public function destroy($request)
    {
        Bus::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('buses.index');
    }

    public function show($id)
    {
        $bus = Bus::findOrFail($id);
        $students = $bus->students()->withPivot('pickup_point', 'dropoff_point')->paginate(15);
        $allStudents = Student::all();
        return view('pages.Transportation.show', compact('bus', 'students', 'allStudents'));
    }

    public function assignStudent($request)
    {
        DB::table('student_bus')->updateOrInsert(
            ['student_id' => $request->student_id, 'bus_id' => $request->bus_id],
            [
                'pickup_point' => $request->pickup_point,
                'dropoff_point' => $request->dropoff_point,
                'updated_at' => now(),
            ]
        );
        toastr()->success(trans('messages.success'));
        return redirect()->back();
    }

    public function removeStudent($request)
    {
        DB::table('student_bus')->where('student_id', $request->student_id)
            ->where('bus_id', $request->bus_id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->back();
    }
}