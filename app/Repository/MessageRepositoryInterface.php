<?php

namespace App\Repository;

interface MessageRepositoryInterface
{
    public function inbox();
    public function sent();
    public function create();
    public function store($request);
    public function show($id);
    public function destroy($id);
    public function getUnreadCount();
}