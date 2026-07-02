<?php

namespace App\Http\Controllers\Homework;

use App\Http\Controllers\Controller;
use App\Repository\HomeworkRepositoryInterface;
use App\Http\Requests\StoreHomeworkRequest;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    protected $homework;

    public function __construct(HomeworkRepositoryInterface $homework)
    {
        $this->homework = $homework;
    }

    public function index()
    {
        return $this->homework->index();
    }

    public function create()
    {
        return $this->homework->create();
    }

    public function store(StoreHomeworkRequest $request)
    {
        return $this->homework->store($request);
    }

    public function show($id)
    {
        return $this->homework->show($id);
    }

    public function edit($id)
    {
        return $this->homework->edit($id);
    }

    public function update(StoreHomeworkRequest $request)
    {
        return $this->homework->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->homework->destroy($request);
    }

    public function studentHomeworks()
    {
        return $this->homework->studentHomeworks();
    }

    public function submitHomework(Request $request)
    {
        return $this->homework->submitHomework($request);
    }

    public function submissions($homeworkId)
    {
        return $this->homework->submissions($homeworkId);
    }
}