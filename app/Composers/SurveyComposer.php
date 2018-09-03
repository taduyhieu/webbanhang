<?php

namespace Fully\Composers;

use Fully\Repositories\Survey\SurveyInterface;

/**
 * Class SurveyComposer.
 *
 * @author
 */
class SurveyComposer {

    /**
     * @var \Fully\Repositories\Survey\SurveyInterface
     */
    protected $survey;

    /**
     * SurveyComposer constructor.
     * @param SurveyInterface $survey
     */
    public function __construct(SurveyInterface $survey) {
        $this->survey = $survey;
    }

    /**
     * @param $view
     */
    public function compose($view) {
        $survey = $this->survey->getSurveyView();
        $view->with('survey', $survey);
    }

}
