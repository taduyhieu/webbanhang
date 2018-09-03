<?php

namespace Fully\Models;

use Fully\Models\SurveyDetail;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model {

    public $table = 'survey';
    public $fillable = ['name', 'active'];
    protected $hidden = ['getSurveyDetail'];

    public function getSurveyDetail() {
        return $this->hasMany(SurveyDetail::class, 'survey_id', 'id');
    }

}
