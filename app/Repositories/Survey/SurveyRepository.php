<?php

namespace Fully\Repositories\Survey;

use Config;
use Fully\Models\Survey;
use Fully\Models\SurveyDetail;
use DB;
use Response;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class NewsRepository.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class SurveyRepository extends RepositoryAbstract implements SurveyInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \News
     */
    protected $survey;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
    ];

    public function __construct(Survey $survey) {
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
        $this->survey = $survey;
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->survey->orderBy('created_at', 'DESC')
                        ->where('lang', $this->getLang())
                        ->get();
    }

    /**
     * Get paginated survey.
     *
     * @param int  $page  Number of survey per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->survey->orderBy('created_at', 'DESC')->where('lang', $this->getLang());

        $survey = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalSurvey($all);
        $result->items = $survey->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->survey->findOrFail($id);
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        DB::beginTransaction();
        try {
            $this->survey->lang = $this->getLang();
            $survey = $this->survey->fill($attributes);
            $result = json_decode($attributes['list-survey']);
            $listSurvey = [];
            foreach ($result as $re) {
                $surveyDetail = new SurveyDetail();
                $surveyDetail->name = $re;
                $listSurvey[] = $surveyDetail;
            }

            $survey->save();
            $survey->getSurveyDetail()->saveMany($listSurvey);
            DB::commit();
            return trans('fully.mes_add_succes');
        } catch (Exception $ex) {
            DB::rollback();
            return 'Đã có lỗi xảy ra. Mời tạo lại khảo sát';
        }
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function update($id, $attributes) {
        DB::beginTransaction();
        try {
            $this->survey = $this->find($id);
            $survey = $this->survey->fill($attributes);

            $result = json_decode($attributes['list-survey']);

            $listSurvey = [];
            foreach ($result as $re) {
                $surveyDetail = new SurveyDetail();
                $surveyDetail->name = $re;
                $listSurvey[] = $surveyDetail;
            }

            $survey->save();
            $survey->getSurveyDetail()->delete();
            $survey->getSurveyDetail()->saveMany($listSurvey);

            DB::commit();
            return trans('fully.mes_update_succes');
        } catch (Exception $ex) {
            DB::rollback();
            return 'Đã có lỗi xảy ra. Mời sửa lại bài viết';
        }
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $this->survey->find($id)->delete();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function toggleActive($id) {
        $survey = $this->survey->find($id);
        $survey->active = ($survey->active) ? false : true;
        $survey->save();

        return Response::json(array('result' => 'success', 'changed' => ($survey->active) ? 1 : 0));
    }

    /**
     * Get total news count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalSurvey($all = false) {
        if (!$all) {
            return $this->survey->where('active', 1)->where('lang', $this->getLang())->count();
        }

        return $this->survey->where('lang', $this->getLang())->count();
    }

    public function searchByName($searchTitle) {
        return $this->survey->where('name', 'like', $searchTitle . '%')
                        ->where('lang', $this->getLang())
                        ->paginate(10);
    }

    public function getSurveyView() {
        $surveyView = $this->survey->orderBy('created_at', 'DESC')->where('active', 1)->where('lang', $this->getLang())->first();
        $surveyView->surveyDetail = $surveyView->getSurveyDetail ? $surveyView->getSurveyDetail : [];
        $totalRate = $surveyView->getSurveyDetail()->sum('rating');
        foreach ($surveyView->surveyDetail as $sv) {
            $sv->percent = 0;
            if ($totalRate != 0) {
                $sv->percent = ($sv->rating / $totalRate) * 100;
            }
        }
        return $surveyView;
    }

}
