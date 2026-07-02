<?php

namespace App\Repository;

interface BehavioralRecordRepositoryInterface
{
    public function index($studentId = null);
    public function create($studentId = null);
    public function store($request);
    public function show($id);
    public function destroy($request);
    public function studentRecords();
}