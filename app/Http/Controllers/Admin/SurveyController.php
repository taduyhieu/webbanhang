<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Survey\SurveyInterface;
use Fully\Exceptions\Validation\ValidationException;

class SurveyController extends Controller {

    protected $survey;
    protected $perPage;

    public function __construct(SurveyInterface $survey) {
        View::share('active', 'modules');
        $this->survey = $survey;
        $this->perPage = config('fully.modules.survey.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $searchTitle = "";
        $pagiData = $this->survey->paginate(Input::get('page', 1), $this->perPage, true);
        $surveys = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.survey.index', compact('surveys', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.survey.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:survey,name',
                ], [
            'name.required' => 'Tên khảo sát không để trống',
            'name.unique' => 'Tên khảo sát đã tồn tại',
        ]);
        try {
            $message = $this->survey->create(Input::all());
            Flash::message($message);

            return langRedirectRoute('admin.survey.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.survey.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $survey = $this->survey->find($id);
        
        $surveyDetail = $survey->getSurveyDetail;
        
        return view('backend.survey.show', compact('survey', 'surveyDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $survey = $this->survey->find($id);
        $surveyDetail = $survey->getSurveyDetail;
        $listSurvey = $survey->getSurveyDetail->pluck('name');
        
        return view('backend.survey.edit', compact('survey', 'surveyDetail', 'listSurvey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|unique:survey,name,'.$id,
                ], [
            'name.required' => 'Tên khảo sát không để trống',
            'name.unique' => 'Tên khảo sát đã tồn tại',
        ]);
        try {
            $message = $this->survey->update($id, Input::all());
            Flash::message($message);

            return langRedirectRoute('admin.survey.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.survey.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function toggleActive($id) {
        return $this->survey->toggleActive($id);
    }

    public function search(Request $request) {
        $searchTitle = $request->title_survey;
        if (isset($searchTitle)) {
            $surveys = $this->survey->searchByName($searchTitle);
        }
        $surveys->appends(['title_survey' => $searchTitle]);
        return view('backend.survey.index', compact('surveys', 'searchTitle'));
    }

}
