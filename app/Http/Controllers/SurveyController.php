<?php

namespace Fully\Http\Controllers;

use Fully\Models\SurveyDetail;
use Response;
use Fully\Http\Controllers\Controller;
use Mockery\Exception;
class SurveyController extends Controller {

    /**
     * @param $id
     *
     * @return mixed
     */
    public function addVote($id) {
        try {
            $survey = SurveyDetail::find($id);
            if ($survey) {
                $survey->rating = $survey->rating + 1;
                $survey->save();
            }
            return Response::json(1);
        } catch (Exception $ex) {
            return Response::json(0);
        }
    }

}
