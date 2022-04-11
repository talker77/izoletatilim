<?php

namespace App\Http\Controllers;

use App\Models\Product\UrunFirma;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{


    public function forward(Request $request)
    {
        $company = UrunFirma::where(['id' => $request->get('companyId')])->first();

        Report::where(['type' => Report::TYPE_SERVICE_COMPANY, 'item_id' => $request->serviceCompanyId])
            ->firstOrCreate(['type' => Report::TYPE_SERVICE_COMPANY, 'item_id' => $request->serviceCompanyId])->increment('click');


        return view('site.service.forward', [
            'company' => $company
        ]);
    }
}
