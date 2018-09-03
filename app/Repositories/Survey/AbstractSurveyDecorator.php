<?php

namespace Fully\Repositories\Survey;

/**
 * Class AbstractSurveyDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
abstract class AbstractSurveyDecorator implements SurveyInterface
{
    /**
     * @var SurveyInterface
     */
    protected $survey;

    /**
     * @param SurveyInterface $survey
     */
    public function __construct(SurveyInterface $survey)
    {
        $this->survey = $survey;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->survey->find($id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->survey->all();
    }

    /**
     * @param null $perPage
     * @param bool $all
     *
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        return $this->survey->paginate($page, $limit, $all);
    }
}
