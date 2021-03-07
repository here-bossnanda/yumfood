<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRequest;
use App\Http\Resources\VendorResource;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $vendors = Vendor::query();
        
        $tags = $request->query('tags');

        $vendors->when($tags, function($query) use ($tags){
            return $query->whereHas('tags', function($query) use($tags) {
              return $query->whereIn('name', $tags);
            });
        });

        return VendorResource::collection($vendors->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\VendorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
      $data = $request->all();

      $vendors = Vendor::create($data);
        return response()->json([
          'status' => 'success',
          'data' => $vendors
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $vendors = Vendor::with('tags')->findOrFail($id);
      return response()->json(['status' => 'success', 'data' => $vendors], 200);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\VendorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id)
    {
      $data = $request->all();

      $vendors = Vendor::find($id);

      if(!$vendors){
        return response()->json([
            'status' => 'error',
            'message' => 'vendors not found'
        ], 404);
      }

      $vendors->fill($data);

      return response()->json([
        'status' => 'success',
        'data' => $vendors
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $vendors = Vendor::find($id);
        
      if(!$vendors){
          return response()->json([
              'status' => 'error',
              'message' => 'vendor not found'
          ],404);
      }

      $vendors->delete();

      return response()->json([
          'status' => 'success',
          'message' => 'vendor deleted'
      ]);
    }
}
