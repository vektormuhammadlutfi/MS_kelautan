<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SubUsaha, App\Usaha;

class UsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data['usaha'] = SubUsaha::paginate(10);
        return view ('app.master.usaha',$data);
    }

    public function getTambah(Request $request)
    {
        $data['usaha'] = SubUsaha::paginate(10);
        $dt = new SubUsaha;
        $dt->nama = $request->nama;
        $dt->jenis = $request->jenis;
        $dt->save();
        return redirect()->route('usaha', $data);
    }

    public function getHapus($id){

        $val = explode(",", $id);

        foreach ($val as $value) {
            Bantuan::where('id', $value)->delete();            
        }
        return redirect()->route('usaha');
    }
}
