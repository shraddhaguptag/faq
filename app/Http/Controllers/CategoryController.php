<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

#models
use App\Models\Category;
use App\Models\Question;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * @method constructor for Create a new  instance.
     * @return
     * @param 
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Display a listing of enable resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCategories()
    {
        return CategoryResource::collection(Category::where('status',1)->get());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check and validate fields as per requirements
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:200|unique:categories',
            ]
        );
        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "Category name already taken. Please try again."], 400);
        }
        // saves data into database
        $save = Category::create([
            'name' => $request->name,
        ]);
        //send response with status code & message
        return response()->json(["status" => "success", "message" => "Category create successfully.!"], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //CategoryResource
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $category = Category::find($id);
        //check and validate fields as per requirements
        $validator =
            Validator::make($request->all(), [
                'name' => [
                    'required',
                    Rule::unique('categories', 'name')->ignore($id),
                ],
            ]);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => "Category name already taken. Please try again."], 400);
        }
        #update the resource
        $category->update($request->all());
        $question = Question::where('category_id', $id)->update(['category_status'=>$request->status]);

        return response()->json(["status" => "success", "message" => "Category updated successfully.!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        $question = Question::where('category_id', $id)->delete();
        return response()->json('Category deleted!');
    }
}
