<?php

namespace App\Http\Controllers;

/**
*  @OA\Info(
*     title="Events API",
*     version="1.0.0",
*     description="API documentation for My API",
*     @OA\Contact(
*         email="hericklucas.hlf@gmail.com"
*     ),
*     @OA\License(
*         name="MIT License",
*         url="https://opensource.org/licenses/MIT"
*     )
* )
*/

class MainController extends Controller
{
    public function main() {

        return redirect('/api/documentation');
    }
};
