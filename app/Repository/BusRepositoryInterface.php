<?php

namespace App\Repository;

interface BusRepositoryInterface
{
    public function index();
    public function create();
    public function store($request);
    public function edit($id);
    public function update($request);
    public function destroy($request);
    public function show($id);
    public function assignStudent($request);
    public function removeStudent($request);
}