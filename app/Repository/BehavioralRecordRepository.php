<?php

namespace App\Repository;

use App\Models\BehavioralRecord;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class BehavioralRecordRepository implements BehavioralRecordRepositoryInterface
{
    public function index($studentId = null)
    {
        if ($studentId) {
            $records = BehavioralRecord::where('student_id', $studentId)
                ->with(['student', 'teacher'])
                ->orderBy('date', 'desc')
                ->paginate(15);
        } else {
            $records = BehavioralRecord::with(['student', 'teacher'])
                ->orderBy('date', 'desc')
                ->paginate(15);
        }
        return view('pages.Behavioral.index', compact('records'));
    }

    public function create($studentId = null)
    {
        $students = Student::all();
        return view('pages.Behavioral.create', compact('students', 'studentId'));
    }

    public function store($request)
    {
        BehavioralRecord::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'description' => $request->description,
            'points' => $request->points,
            'teacher_id' => Auth::user()->id,
            'date' => $request->date,
        ]);
        toastr()->success(trans('messages.success'));
        return redirect()->route('behavioral.index');
    }

    public function show($id)
    {
        $records = BehavioralRecord::where('student_id', $id)
            ->with(['student', 'teacher'])
            ->orderBy('date', 'desc')
            ->paginate(15);
        $student = Student::findOrFail($id);
        return view('pages.Behavioral.show', compact('records', 'student'));
    }

    public function destroy($request)
    {
        BehavioralRecord::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->back();
    }

    public function studentRecords()
    {
        $student = Student::where('id', Auth::user()->id)->first();
        if (!$student) {
            $student = Student::where('email', Auth::user()->email)->first();
        }
        $records = BehavioralRecord::where('student_id', $student->id ?? 0)
            ->with(['teacher'])
            ->orderBy('date', 'desc')
            ->paginate(15);
        return view('pages.Behavioral.student_index', compact('records'));
    }
}