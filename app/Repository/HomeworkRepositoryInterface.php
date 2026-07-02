<?php

namespace App\Repository;

interface HomeworkRepositoryInterface
{
    public function index();
    public function create();
    public function store($request);
    public function show($id);
    public function edit($id);
    public function update($request);
    public function destroy($request);
    public function studentHomeworks();
    public function submitHomework($request);
    public function submissions($homeworkId);
}