<?php

namespace Modules\Course\Http\Controllers\Api\V1;

use App\Transformers\CourseTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;

class ApiCourseController extends Controller
{
    /**
     * Display a listing of the course.
     * @return Response
     */
    public function index()
    {
        $courses = Course::all();
        return fractal($courses, new CourseTransformer())->respond(200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified course.
     * @return Response
     */
    public function show($id)
    {
        $course = Course::query()->findOrFail($id);
        return fractal($course, new CourseTransformer())->includeDescription()->includeUsers()->serializeWith(new \Spatie\Fractalistic\ArraySerializer())->respond(200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
