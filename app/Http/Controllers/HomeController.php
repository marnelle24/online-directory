<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\Organization;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function search(Request $request) 
    {
        $keyword = $request->searchKeyword;

        // if the selected type is CHURCH
        if($request->searchtype === 'church') 
        {
            $result = Church::where(function ($q) use ($keyword) {
    
                        $chopKeyword = array_map('trim', explode(' ', $keyword));
    
                        if(!empty($keyword) && count($chopKeyword)>=1) 
                        {
                            foreach ($chopKeyword as $keyword) 
                            {
                                $q->orWhere('name', 'LIKE', '%'.$keyword. '%');
                                $q->orWhere('denomination', 'LIKE', '%'.$keyword. '%');
                                $q->orWhere('address', 'LIKE', '%'.$keyword. '%');
                            }
                        } 
                        
                    })
                    ->select('name', 'type', 'denomination as x', 'address', 'is_nccsmember', 'slug', 'avatar')
                    ->where('is_approved', 1)
                    ->where('is_published', 1)
                    ->where('is_searchable', 1)
                    ->with('contacts_details')
                    ->with('service_schedules')
                    ->with('pastors_staffs')
                    ->orderBy('churches.created_at', 'DESC')
                    ->get();

            return response()->json($result, 200);
        }

        // if the selected type is ORGANIZATION
        else if($request->searchtype === 'org') 
        {
            $result = Organization::where(function ($q) use ($keyword) {
    
                    $chopKeyword = array_map('trim', explode(' ', $keyword));

                    if(!empty($keyword) && count($chopKeyword)>=1) 
                    {
                        foreach ($chopKeyword as $keyword) 
                        {
                            $q->orWhere('name', 'LIKE', '%'.$keyword. '%');
                            $q->orWhere('category', 'LIKE', '%'.$keyword. '%');
                            $q->orWhere('address', 'LIKE', '%'.$keyword. '%');
                        }
                    } 
                    
                })
                ->select('name', 'type', 'category as x', 'address', 'is_nccsmember', 'slug', 'avatar')
                ->where('is_approved', 1)
                ->where('is_published', 1)
                ->where('is_searchable', 1)
                ->with('contacts_details')
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json($result, 200);

        }

        // if  the selected is ALL
        else {
            
            $churches = Church::where(function ($q) use ($keyword) {
    
                $chopKeyword = array_map('trim', explode(' ', $keyword));

                if(!empty($keyword) && count($chopKeyword)>=1) 
                {
                    foreach ($chopKeyword as $keyword) 
                    {
                        $q->orWhere('churches.name', 'LIKE', '%'.$keyword. '%');
                        $q->orWhere('churches.address', 'LIKE', '%'.$keyword. '%');
                    }
                } 
                
            })
            ->select('churches.name', 'type', 'denomination as x', 'address', 'is_nccsmember', 'slug', 'avatar')
            ->where('is_approved', 1)
            ->where('is_published', 1)
            ->where('is_searchable', 1);

            $result = Organization::where(function ($q) use ($keyword) {
    
                $chopKeyword = array_map('trim', explode(' ', $keyword));

                if(!empty($keyword) && count($chopKeyword)>=1) 
                {
                    foreach ($chopKeyword as $keyword) 
                    {
                        $q->orWhere('organizations.name', 'LIKE', '%'.$keyword. '%');
                        $q->orWhere('organizations.address', 'LIKE', '%'.$keyword. '%');
                    }
                } 
            })
            ->select('organizations.name', 'type', 'category as x', 'address', 'is_nccsmember', 'slug', 'avatar')
            ->where('is_approved', 1)
            ->where('is_published', 1)
            ->where('is_searchable', 1)
            ->unionAll($churches)
            ->get();

            return response()->json($result, 200);

        }
        
    }

    public function fetch($slug) {

        $result = Church::where('slug', $slug)
                ->unionAll(Organization::where('slug', $slug))
                ->first();
        if($result)
            return view('show', compact('result'));
        else
            abort(404);
    }

    public function getRecords(Request $request) {

        $id = $request->id;
        $type = $request->type;

        if($type === 'church') {
            $result = Church::whereId($id)
                            ->with('contacts_details')
                            ->with('service_schedules')
                            ->with('pastors_staffs')
                            ->first();
        }
        else {
            $result = Organization::whereId($id)
                            ->with('contacts_details')                
                            ->first();
        }

        return response()->json($result, 200);
    }

}
