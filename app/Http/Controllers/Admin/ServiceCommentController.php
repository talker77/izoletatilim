<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceComment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceCommentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.services.comments.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.comments.create');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceComment $servicesComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceComment $servicesComment)
    {
        $this->authorize('view', $servicesComment);
        if (!$servicesComment->read_at) {
            $servicesComment->update(['read_at' => Carbon::now()]);
        }

        return view('admin.services.comments.create', [
            'item' => $servicesComment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ServiceComment $servicesComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceComment $servicesComment)
    {
        $servicesComment->update(['status' => activeStatus('status')]);
        success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
