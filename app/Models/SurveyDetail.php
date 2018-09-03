<?php

namespace Fully\Models;

use Fully\Models\Survey;
use Illuminate\Database\Eloquent\Model;

class SurveyDetail extends Model {

    public $table = 'survey_detail';
    public $fillable = ['name', 'active'];
    protected $hidden = ['getSurvey'];
    public $timestamps = false;

    public function getSurvey() {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

}
