<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    use HasFactory;

    public function scopeCountry($query, $country)
    {
        if ($country === "HK") $query->where('is_hongkong', true);
        if ($country === "SG") $query->where('is_singapore', true);
        if ($country === "TW") $query->where('is_taiwan', true);
        if ($country === "MY") $query->where('is_malaysia', true);
        if ($country === "BN") $query->where('is_brunei', true);
        if ($country === "ALL") $query->where('is_all_format', true);
        return $query;
    }

    public function scopeQuestionMaid($query, $param)
    {
        $query->select('*')
            ->from(DB::raw("(SELECT a.id, a.question, a.`question_hk`,
            b.answer,a.`is_hongkong`, a.`is_singapore`, a.`is_taiwan`,
            a.`is_malaysia`, a.`is_brunei`,a.is_all_format,a.is_check, a.is_child,
            a.is_input,b.note,b.rate, a.`is_active`, a.`is_language`, a.parent_id FROM questions a
            LEFT JOIN (SELECT question_id, answer, rate, note FROM languages
            WHERE maid_id = '$param') b
            ON a.id = b.question_id
            WHERE a.`is_language` = TRUE) tb"));
    }

    public function scopeWillingnessMaid($query, $param)
    {
        $query->select('*')
            ->from(DB::raw("(SELECT a.id, a.question, a.`question_hk`,
            a.`is_hongkong`, a.`is_singapore`, a.`is_taiwan`,
            a.`is_malaysia`, a.`is_brunei`,a.is_all_format, b.answer, b.note,a.is_check,
            a.is_input,a.`is_active`, a.`is_language`, a.is_child, a.parent_id FROM questions a
            LEFT JOIN (SELECT question_id, answer, note FROM skills
            WHERE maid_id = '$param'
            AND is_willingness = TRUE) b
            ON a.id = b.question_id
            WHERE a.`is_willingness` = TRUE) tb"));
    }

    public function scopeSpecialityMaid($query, $param)
    {
        $query->select('*')
            ->from(DB::raw("(SELECT a.id, a.question, a.`question_hk`,
            a.`is_hongkong`, a.`is_singapore`, a.`is_taiwan`,
            a.`is_malaysia`, a.`is_brunei`,a.is_all_format, b.answer, b.note,a.is_check, a.is_child,
            a.is_input, a.`is_active`, a.`is_language`, a.parent_id, b.experience,
            b.willingness, b.note_experience, b.rate, b.note_observation FROM questions a
            LEFT JOIN (SELECT question_id, answer, note, experience,
            willingness, note_experience, rate, note_observation FROM skills
            WHERE maid_id = '$param') b
            ON a.id = b.question_id
            WHERE a.`is_speciality` = TRUE
            AND a.is_method = FALSE) tb"));
    }

    public function scopeOtherMaid($query, $param)
    {
        $query->select('*')
            ->from(DB::raw("(SELECT a.id, a.question, a.`question_hk`,
            a.`is_hongkong`, a.`is_singapore`, a.`is_taiwan`,
            a.`is_malaysia`, a.`is_brunei`,a.is_all_format, b.answer, b.note,a.is_check, a.is_child,
            a.is_input, a.`is_active`, a.`is_language`, a.parent_id FROM questions a
            LEFT JOIN (SELECT question_id, answer, note FROM others
            WHERE maid_id = '$param') b
            ON a.id = b.question_id
            WHERE a.`is_other` = TRUE) tb"));
    }

    public function scopeMedicalMaid($query, $param)
    {
        $query->select('*')
            ->from(DB::raw("(SELECT a.id, a.question, a.`question_hk`,
            a.`is_hongkong`, a.`is_singapore`, a.`is_taiwan`,
            a.`is_malaysia`, a.`is_brunei`,a.is_all_format, b.answer, b.note,a.is_check, a.is_child,
            a.is_input, a.`is_active`, a.`is_language`, a.parent_id FROM questions a
            LEFT JOIN (SELECT question_id, answer, note FROM medicals
            WHERE maid_id = '$param') b
            ON a.id = b.question_id
            WHERE a.`is_medical` = TRUE) tb"));
    }

    public function scopeMethodMaid($query, $param)
    {
        $query->select('*')
            ->from(DB::raw("(SELECT a.id, a.question, a.`question_hk`,
            a.`is_hongkong`, a.`is_singapore`, a.`is_taiwan`,
            a.`is_malaysia`, a.`is_brunei`,a.is_all_format, b.answer, b.note,a.is_check, a.is_child,
            a.is_input, a.`is_active`, a.`is_language`, a.parent_id FROM questions a
            LEFT JOIN (SELECT question_id, answer, note FROM skills
            WHERE maid_id = '$param') b
            ON a.id = b.question_id
            WHERE a.`is_method` = TRUE) tb"));
    }

    public function scopeInterviewMaid($query, $param)
    {
        $query->select('*')
            ->from(DB::raw("(SELECT a.id, a.question, a.`question_hk`,
            a.`is_hongkong`, a.`is_singapore`, a.`is_taiwan`,
            a.`is_malaysia`, a.`is_brunei`,a.is_all_format, b.answer, b.note,a.is_check, a.is_child,
            a.is_input, a.`is_active`, a.`is_language`, a.parent_id, b.rate FROM questions a
            LEFT JOIN (SELECT question_id, answer, note, rate FROM interviews
            WHERE maid_id = '$param') b
            ON a.id = b.question_id
            WHERE a.`is_interview` = TRUE) tb"));
    }
}
