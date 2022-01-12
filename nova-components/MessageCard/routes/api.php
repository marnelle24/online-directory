<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

// Route::get('/endpoint', function (Request $request) {
//     //
// });

Route::post('/checkPendingRecords', function (Request $request) {

    $churches = \App\Models\Church::where('is_approved', 0)->count();
    $orgs = \App\Models\Organization::where('is_approved', 0)->count();
    $users = \App\Models\User::where('status', 0)->count();
    
    // For example we'll sleep the process for 2 seconds before returning a response
    sleep(2);

    return response()->json([
                        'total'        => $churches + $orgs + $users,
                        'totalChurches' => $churches,
                        'totalOrgs'     => $orgs,
                        'totalUsers'    =>$users
                    ]);
});
