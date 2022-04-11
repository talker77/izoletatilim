<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Interfaces\EBultenInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EBultenController extends Controller
{
    private EBultenInterface $_bultenService;

    public function __construct(EBultenInterface $bultenService)
    {
        $this->_bultenService = $bultenService;
    }

    public function list()
    {
        $list = $this->_bultenService->allWithPagination();
        return view('admin.ebulten.listBultens', compact('list'));
    }

    public function delete($id)
    {
        $this->_bultenService->delete($id);
        return redirect(route('admin.ebulten'));
    }
}
