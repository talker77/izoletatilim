<?php

namespace App\Http\Controllers\Admin;

use App\Models\SSS;
use App\Repositories\Interfaces\SSSInterface;
use App\Http\Controllers\Controller;

class SSSController extends Controller
{
    protected SSSInterface $model;

    public function __construct(SSSInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }
        return view('admin.sss.listSss', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $item = new SSS();
        if ($id != 0) {
            $item = $this->model->getById($id);
        }
        return view('admin.sss.newOrEditSSS', compact('item'));
    }

    public function save($id = 0)
    {
        $request_data = \request()->only('title', 'desc', 'lang');
        $request_data['active'] = request()->has('active') ? 1 : 0;
        if ($id != 0) {
            $entry = $this->model->update($request_data, $id);
        } else {
            $entry = $this->model->create($request_data);
        }
        if (!is_null($entry))
            return redirect(route('admin.sss.edit', $id));
        return back()->withInput();
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect(route('admin.sss'));
    }
}
