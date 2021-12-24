<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Models\WisataImage;
use Illuminate\Support\Facades\DB;

class AdminWisataController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('tb_wisata')->join('tb_img', 'tb_wisata.id', '=', 'tb_img.id_wisata')->select('tb_wisata.*', 'tb_img.name_img')->get();

        return response()->json([
            'data' => $data,
        ]);

    }

    /**
     * Creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $wisata = new Wisata();
        $imgwisata = new WisataImage();

        $wisata->name = $request->name;
        $wisata->description = $request->description;
        $wisata->price = $request->price;
        $wisata->rating = $request->rating;
        $wisata->address = $request->address;
        $wisata->telephone = $request->telephone;
        $wisata->website = $request->website;

        if($wisata->save())
        {
            $request->validate([
                'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048'
            ]);

            $datawisata = Wisata::where('name', $request->name)->first();

            if($request->hasfile('img'))
            {
                $images = $request->file('img');

                $nameimage = time().".".$images->getClientOriginalExtension();
                $filenameimage = "http://127.0.0.1:8000/uploads/image/".$nameimage;
                $folderimage = 'uploads/image';
                $images->move($folderimage,$nameimage);

                $imgwisata->id_wisata = $datawisata->id;
                $imgwisata->name_img = $filenameimage;

                if($imgwisata->save())
                {
                    return response()->json([
                        'status' => 'Success'
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => 'Failed Save'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'status' => 'Failed Upload Image'
                ]);
            }  
        }
        else
        {
            return response()->json([
                'status' => 'Failed'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
