<?php

namespace App\Repository;

use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeworkRepository implements HomeworkRepositoryInterface
{
    public function index()
    {
        $teacherId = Auth::user()->id;
        $homeworks = Homework::where('teacher_id', $teacherId)
            ->with(['subject', 'grade', 'section', 'submissions'])
            ->orderBy('deadline', 'desc')
            ->paginate(15);
        return view('pages.Homework.index', compact('homeworks'));
    }

    public function create()
    {
        $teacherId = Auth::user()->id;
        $sections = \App\Models\Teacher::findOrFail($teacherId)->Sections;
        $subjects = \App\Models\Subject::all();
        $grades = \App\Models\Grade::all();
        return view('pages.Homework.create', compact('sections', 'subjects', 'grades'));
    }

    public function store($request)
    {
        $data = $request->except('_token', 'file');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('attachments/homeworks', $name, 'upload_attachments');
            $data['file'] = $name;
        }
        Homework::create($data);
        toastr()->success(trans('messages.success'));
        return redirect()->route('homeworks.index');
    }

    public function show($id)
    {
        $homework = Homework::findOrFail($id);
        return view('pages.Homework.show', compact('homework'));
    }

    public function edit($id)
    {
        $homework = Homework::findOrFail($id);
        $sections = \App\Models\Teacher::findOrFail(Auth::user()->id)->Sections;
        $subjects = \App\Models\Subject::all();
        $grades = \App\Models\Grade::all();
        return view('pages.Homework.edit', compact('homework', 'sections', 'subjects', 'grades'));
    }

    public function update($request)
    {
        $homework = Homework::findOrFail($request->id);
        $data = $request->except('_token', 'file', 'id');
        if ($request->hasFile('file')) {
            if ($homework->file) {
                Storage::disk('upload_attachments')->delete('attachments/homeworks/' . $homework->file);
            }
            $file = $request->file('file');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('attachments/homeworks', $name, 'upload_attachments');
            $data['file'] = $name;
        }
        $homework->update($data);
        toastr()->success(trans('messages.Update'));
        return redirect()->route('homeworks.index');
    }

    public function destroy($request)
    {
        $homework = Homework::findOrFail($request->id);
        if ($homework->file) {
            Storage::disk('upload_attachments')->delete('attachments/homeworks/' . $homework->file);
        }
        $homework->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('homeworks.index');
    }

    public function studentHomeworks()
    {
        $student = Student::where('id', Auth::user()->id)->first();
        if (!$student) {
            $student = Student::where('email', Auth::user()->email)->first();
        }
        $homeworks = Homework::where('section_id', $student->section_id ?? 0)
            ->with(['subject', 'teacher', 'submissions' => function($q) use ($student) {
                $q->where('student_id', $student->id ?? 0);
            }])
            ->orderBy('deadline', 'desc')
            ->paginate(15);
        return view('pages.Homework.student_index', compact('homeworks'));
    }

    public function submitHomework($request)
    {
        $data = [
            'homework_id' => $request->homework_id,
            'student_id' => Auth::user()->id,
            'notes' => $request->notes,
        ];
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('attachments/homework_submissions', $name, 'upload_attachments');
            $data['file'] = $name;
        }
        HomeworkSubmission::updateOrCreate(
            ['homework_id' => $request->homework_id, 'student_id' => Auth::user()->id],
            $data
        );
        toastr()->success(trans('messages.success'));
        return redirect()->back();
    }

    public function submissions($homeworkId)
    {
        $homework = Homework::findOrFail($homeworkId);
        $submissions = $homework->submissions()->with('student')->paginate(15);
        return view('pages.Homework.submissions', compact('homework', 'submissions'));
    }
}