<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UsersController extends Controller
{
  public function showById($id){
    $user = User::find($id);
    return response()->json(["data"=>$user]);
  }
}
