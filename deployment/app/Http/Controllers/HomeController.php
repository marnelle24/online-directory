<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\ContactDetails;
use App\Models\Organization;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function search(Request $request) 
    {
        $keyword = $request->searchKeyword;

        if($request->searchtype === 'church') 
        {
            $result = Church::where(function ($q) use ($keyword) {
    
                        $chopKeyword = array_map('trim', explode(' ', $keyword));
    
                        if(!empty($keyword) && count($chopKeyword)>=1) 
                        {
                            foreach ($chopKeyword as $keyword) 
                            {
                                $q->orWhere('churches.name', 'LIKE', '%'.$keyword. '%');
                                $q->orWhere('denominations.name', 'LIKE', '%'.$keyword. '%');
                                $q->orWhere('address', 'LIKE', '%'.$keyword. '%');
                            }
                        } 
                        
                    })
                    ->select('churches.*', 'denominations.name AS church_denom')
                    ->join('denominations', 'denominations.id', '=', 'churches.denomination_id')
                    ->where('is_approved', 1)
                    ->where('is_published', 1)
                    ->where('is_searchable', 1)
                    // ->where('status', 1)
                    ->with('contacts_details')
                    ->with('service_schedules')
                    ->with('pastors_staffs')
                    ->orderBy('churches.created_at', 'DESC')
                    ->get();

            return response()->json($result, 200);
        }
        else 
        {
            $result = Organization::where(function ($q) use ($keyword) {
    
                    $chopKeyword = array_map('trim', explode(' ', $keyword));

                    if(!empty($keyword) && count($chopKeyword)>=1) 
                    {
                        foreach ($chopKeyword as $keyword) 
                        {
                            $q->orWhere('name', 'LIKE', '%'.$keyword. '%');
                            // $q->orWhere('denominations.name', 'LIKE', '%'.$keyword. '%');
                            $q->orWhere('address', 'LIKE', '%'.$keyword. '%');
                        }
                    } 
                    
                })
                // ->select('churches.*', 'denominations.name AS church_denom')
                // ->join('denominations', 'denominations.id', '=', 'churches.denomination_id')
                ->where('is_approved', 1)
                ->where('is_published', 1)
                ->where('is_searchable', 1)
                // ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json($result, 200);

        }
        

    }

    // public function getChurch($type, $slug) 
    // {

    //     $record = Church::where('slug', '=', $slug)->first();

    //     return view('showProfile')->with('record', $record); 
    //     // dd($record);
        
    // }

}
