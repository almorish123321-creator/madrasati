<?php

namespace App\Http\Controllers\Transportation;

use App\Http\Controllers\Controller;
use App\Repository\BusRepositoryInterface;
use App\Http\Requests\StoreBusRequest;
use Illuminate\Http\Request;

class BusController extends Controller
{
    protected $bus;

    public function __construct(BusRepositoryInterface $bus)
    {
        $this->bus = $bus;
    }

    public function index()
    {
        return $this->bus->index();
    }

    public function create()
    {
        return $this->bus->create();
    }

    public function store(StoreBusRequest $request)
    {
        return $this->bus->store($request);
    }

    public function edit($id)
    {
        return $this->bus->edit($id);
    }

    public function update(StoreBusRequest $request)
    {
        return $this->bus->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->bus->destroy($request);
    }

    public function show($id)
    {
        return $this->bus->show($id);
    }

    public function assignStudent(Request $request)
    {
        return $this->bus->assignStudent($request);
    }

    public function removeStudent(Request $request)
    {
        return $this->bus->removeStudent($request);
    }
}