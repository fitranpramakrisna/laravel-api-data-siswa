<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct() {
        $this->middleware(['auth:api', 'verified']);
     }
    
    public function index()
    {   
        $id = auth()->user()->id;
        
        $user = User::find($id);

        $grade = Grade::where('user_id', $id)->get();

        $count_lesson = DB::table('grades')
                        ->where('user_id', $id)
                        ->count();

        $sum_grade = DB::table('grades')
                    ->where('user_id', $id)
                    ->sum('grade');

        return response()->json([
            'message' => 'Data successfully get',
            'data' => [
              'user' => $user,
              'grades' => $grade,
              'final_grade' => $sum_grade / $count_lesson  
            ],
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Grade();

        foreach ($request->lessons as $key => $value) {

            $grades = array(
            'user_id' => auth()->user()->id,
            'lesson'  => $value['lesson'],
            'grade' => $value['grade']
            );
            $grades = Grade::create($grades);

        }

        return response()->json([
            'msg' => 'Data success created!', 
            ], 201);
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

        $grade = Grade::find($id);
        $grade->lesson = $request->lesson;
        $grade->grade = $request->grade;
        $grade->save();

        return response()->json(["msg" => "Data successfully updated!"], 201);
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grade = Grade::find($id);;
        $grade->delete();

        return response()->json(["msg" => "Data successfully deleted!"], 200);
        
    }
}
