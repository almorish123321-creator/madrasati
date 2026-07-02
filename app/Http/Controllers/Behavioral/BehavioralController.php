<?php

namespace App\Http\Controllers\Behavioral;

use App\Http\Controllers\Controller;
use App\Repository\BehavioralRecordRepositoryInterface;
use App\Http\Requests\StoreBehavioralRecordRequest;
use Illuminate\Http\Request;

class BehavioralController extends Controller
{
    protected $behavioral;

    public function __construct(BehavioralRecordRepositoryInterface $behavioral)
    {
        $this->behavioral = $behavioral;
    }

    public function index()
    {
        return $this->behavioral->index();
    }

    public function create()
    {
        return $this->behavioral->create();
    }

    public function store(StoreBehavioralRecordRequest $request)
    {
        return $this->behavioral->store($request);
    }

    public function show($id)
    {
        return $this->behavioral->show($id);
    }

    public function destroy(Request $request)
    {
        return $this->behavioral->destroy($request);
    }

    public function studentRecords()
    {
        return $this->behavioral->studentRecords();
    }
}