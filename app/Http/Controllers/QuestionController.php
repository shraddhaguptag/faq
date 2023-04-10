<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\QuestionResource;

#models
use App\Models\Category;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuestionResource::collection(Question::where('category_status',1)->get());
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
        $categoryId = $request->category_id;
        //check and validate fields as per requirements
        $validator = Validator::make(
            $request->all(),
            [
                'title' => Rule::unique('questions')->where(function ($query) use ($categoryId) {
                    return $query->where('category_id', $categoryId);
                }),
                'category_id' => 'required',
                'answer'      => 'required'
            ]
            
        );

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => implode(', ', $validator->errors()->all())], 400);
            
        }

        // save data into database
        $save = Question::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'answer' => $request->answer,
        ]);


        //send response with status code & message
        return response()->json(["status" => "success", "message" => "Question created successfully.!"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
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
        $question = Question::find($id);
        $categoryId = $request->category_id;
        //check and validate fields as per requirements
        $validator = Validator::make(
            $request->all(),
            [
                'title' => Rule::unique('questions')->ignore($id)->where(function ($query) use ($categoryId) {
                    return $query->where('category_id', $categoryId);
                }),
                'category_id' => 'required',
                'answer'      => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => implode(', ', $validator->errors()->all())], 400);
        }
        #update the resource
        $question->update($request->all());

        return response()->json(["status" => "success", "message" => "Question updated successfully.!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id)->delete();
        return response()->json('Question is deleted!');
    }

    //method to show all faq according to their category
    public function faq()
    {
        $questions = QuestionResource::collection(Question::where('status',1)->where('category_status',1)->orderBy('id', 'desc')->get())->groupBy(function ($data) {
                    return $data->category;
        });
        return response()->json(["status" => "success", "message" => "Faq fetched.", "data" => $questions], 200);
    }
}
