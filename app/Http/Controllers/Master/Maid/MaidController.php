<?php

namespace App\Http\Controllers\Master\Maid;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExcelFormalController;
use App\Http\Controllers\ExcelOtherController;
use App\Http\Controllers\ExcelSingaporeController;
use App\Http\Resources\User\MaidResource;
use App\Models\Country;
use App\Models\DetailWorkExperience;
use App\Models\Document;
use App\Models\EmailSending;
use App\Models\Master\Maid\Interview;
use App\Models\Master\Maid\Language;
use App\Models\Master\Maid\Maid;
use App\Models\Master\Maid\Medical;
use App\Models\Master\Maid\Other;
use App\Models\Master\Maid\Skill;
use App\Models\Master\Maid\WorkExperience;
use App\Models\Notification;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\Image\Image;

class MaidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataMaid = new MaidResource(Maid::with(['userCreated', 'userUpdated', 'historyAction', 'workExperience'])
            ->where('is_active', true)
            ->where('is_trash', false)
            ->where('is_blacklist', false)
            ->where('is_delete', false)
            ->where('code_maid', '<>', '')
            ->latest()
            ->filter([
                'search' => request('search'),
                'code'  =>  request('code'),
                'name'  =>  request('name'),
                'start_age'  =>  request('start_age'),
                'end_age'  =>  request('end_age'),
                'education'  =>  request('education'),
                'marital'  =>  request('marital'),
                'category'  =>  request('category'),
                'branch'  =>  request('branch'),
                'available' =>  request('available') == true ? true : null,
            ], request('countries'))
            ->country(request('country'))
            ->country(request('countries'))
            ->paginate(50)->withQueryString());

        return view('master.maid.index', [
            'title' =>  'Maid Data',
            'pageTitle' =>  'Maid Data',
            'js'    =>  ['assets/js/apps/master/maid/app.js'],
            'maids'  =>  $dataMaid,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $dataMaid = Maid::where('code_maid', $request->maid)
            ->country($request->country)
            ->first();

        $view = 'master.maid.forms.other';
        $js = 'assets/js/apps/master/maid/forms/other.js';

        $medical = Question::where('is_active', true)
            ->where('is_medical', true)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        $cooking = Question::where('is_active', true)
            ->where('is_cooking', true)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        $language = Question::where('is_active', true)
            ->where('is_language', true)
            ->country($request->country)
            ->get();

        $skill = Question::where('is_active', true)
            ->where('is_speciality', true)
            ->where('is_method', false)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        $willingness = Question::where('is_active', true)
            ->where('is_willingness', true)
            ->country($request->country)
            ->get();

        $other = Question::where('is_active', true)
            ->where('is_other', true)
            ->country($request->country)
            ->get();

        $method = Question::where('is_active', true)
            ->where('is_method', true)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        $interview = Question::where('is_active', true)
            ->where('is_interview', true)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        $workChosen = Question::where('is_active', true)
            ->where('is_work_chosen', true)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        $workExperienceCheck = Question::where('is_active', true)
            ->where('is_work_experience', true)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        if ($request->country === 'SG') {
            $view = 'master.maid.forms.singapore';
            $js = 'assets/js/apps/master/maid/forms/singapore.js';
        }

        if ($request->country === 'FM') {
            $view = 'master.maid.forms.allFormat';
            $js = 'assets/js/apps/master/maid/forms/allFormat.js';
        }

        return view($view, [
            'title' =>  'Form Register Maid',
            'pageTitle' =>  'Form Register Maid',
            'maid'  =>  $dataMaid,
            'medicals'  =>  $medical,
            'languages'  =>  $language,
            'specialities'  =>  $skill,
            'willingnesses'  =>  $willingness,
            'others'  =>  $other,
            'methods'  =>  $method,
            'interviews'  =>  $interview,
            'cookings'  =>  $cooking,
            'workChosens'  =>  $workChosen,
            'workExperienceChecks'  =>  $workExperienceCheck,
            'js'    =>  [
                $js,
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataMaid = Maid::where('code_maid', $request->codeMaid)
            ->country($request->countryRequest)
            ->first();

        $validator = Validator::make($request->all(), [
            'codeMaid'    =>  'required',
            'photoMaid' =>  'image|mimes:png,jpg,jpeg'
        ], [
            'codeMaid.required'   =>  'Code Worker is Required',
            'photoMaid.image'   =>  'Maid Worker must an image',
            'photoMaid.mimes'   =>  'Maid Worker must an jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors()
                ]
            ]);
        }

        $fileNameFull = $dataMaid ? $dataMaid->picture_name : '';
        $fileBase = $dataMaid ? $dataMaid->picture_base64 : '';
        if ($request->file('photoMaid')) {
            $photoMaid = $request->file('photoMaid');


            $fileNameFull = $request->codeMaid . '.' . $photoMaid->getClientOriginalExtension();
            $fileBase = str_replace('data:image/' . $photoMaid->getClientOriginalExtension() . ';base64,', '', $photoMaid);
            $fileBase = str_replace(' ', '+', $photoMaid);

            if ($dataMaid->picture_name == null && $dataMaid->picture_name == '') {
                if (File::exists(public_path('assets/image/maids/photos/') . $dataMaid->picture_name)) {
                    File::delete(public_path('assets/image/maids/photos/') . $dataMaid->picture_name);
                }
            }

            $photoMaid->move(public_path('assets/image/maids/photos/'), $fileNameFull);

            Image::load(public_path('assets/image/maids/photos/') . $fileNameFull)
                ->quality(15)
                ->save(public_path('assets/image/maids/photos/') . $fileNameFull);
        }

        $data = [];
        $dataLanguage = array();
        $dataSkill = array();
        $dataWilling = array();
        $dataMedical = array();
        $dataInterview = array();
        $dataOther = array();

        if ($request->countryRequest == 'SG') {
            $data = [
                convertCountry($request->countryRequest)    =>  true,
                'code_maid' =>  $request->codeMaid,
                'full_name' =>  Str::title($request->fullnameMaid),
                'sex' =>  $request->sexMaid,
                'nationality' =>  Str::title($request->nationalityMaid),
                'place_of_birth' =>  Str::title($request->pobMaid),
                'date_of_birth' =>  Carbon::parse($request->dobMaid, 'Asia/Jakarta')->isoFormat('YYYY-MM-DD'),
                'port_airport_name'   =>  $request->portAirportMaid,
                'contact'   =>  $request->contactMaid,
                'address'   =>  $request->addressMaid,
                'height'   =>  $request->heightMaid,
                'weight'   =>  $request->weightMaid,
                'marital'   =>  $request->maritalMaid,
                'religion'   =>  $request->religionMaid,
                'education'    =>    $request->educationMaid,
                'number_of_siblings'  =>  $request->siblingsMaid,
                'number_of_children'  =>  $request->childrenNumberMaid,
                'children_ages'  =>  $request->childrenAgeMaid,
                'work_singapore'  =>  $request->workSingaporeMaid,
                'note'  =>  Str::title($request->remarksMaid),
                'picture_location'  =>  'assets/image/maids/photos/',
                'picture_base64'    =>  base64_encode($fileBase),
                'picture_name'  =>  $fileNameFull,
                'youtube_link'  =>  $request->youtubeMaid,
                'user_updated'  =>  auth()->user()->id,
                'is_active' =>  true,
            ];

            if ($request->medicalMaid) {
                foreach ($request->medicalMaid as $key => $value) {
                    $dataMedical[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'note'  =>  $value,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->otherMaid) {
                foreach ($request->otherMaid as $key => $value) {
                    $dataOther[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'note'  =>  $value,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->interviewMaid) {
                foreach ($request->interviewMaid as $key => $value) {
                    $dataInterview[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->methodMaid) {
                foreach ($request->methodMaid as $key => $value) {
                    $dataSkill[$key] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'is_method'  =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            // dd($request->skillMaidWillingness);

            if ($request->skillMaidWillingness) {
                foreach ($request->skillMaidWillingness as $key => $value) {
                    $dataSkill[$key] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'willingness'  =>  $value == 1 ? true : ($value == 0 ? false : null),
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];

                    if ($request->skillMaid) {
                        foreach ($request->skillMaid as $index => $note) {
                            if ($key == $index) {
                                $dataSkill[$key]['note'] = $note;
                            }
                        }
                    }

                    if ($request->skillMaidExperience) {
                        foreach ($request->skillMaidExperience as $index => $note) {
                            if ($key == $index) {
                                $dataSkill[$key]['experience'] = $note == 1 ? true : ($note == 0 ? false : null);
                            }
                        }
                    }

                    if ($request->skillMaidExperienceNote) {
                        foreach ($request->skillMaidExperienceNote as $index => $note) {
                            if ($key == $index) {
                                $dataSkill[$key]['note_experience'] = $note;
                            }
                        }
                    }

                    if ($request->skillMaidRate) {
                        foreach ($request->skillMaidRate as $index => $note) {
                            if ($key == $index) {
                                $dataSkill[$key]['rate'] = $note;
                            }
                        }
                    }

                    if ($request->skillMaidObservationNote) {
                        foreach ($request->skillMaidObservationNote as $index => $note) {
                            if ($key == $index) {
                                $dataSkill[$key]['observation_note'] = $note;
                            }
                        }
                    }
                }
            }
        } else if ($request->countryRequest == 'FM') {
            $data = [
                convertCountry($request->countryRequest)    =>  true,
                'code_maid' =>  $request->codeMaid,
                'full_name' =>  Str::title($request->fullnameMaid),
                'sex' =>  $request->sexMaid,
                'place_of_birth' =>  Str::title($request->pobMaid),
                'date_of_birth' =>  Carbon::parse($request->dobMaid, 'Asia/Jakarta')->isoFormat('YYYY-MM-DD'),
                'contact'   =>  $request->contactMaid,
                'address'   =>  $request->addressMaid,
                'height'   =>  $request->heightMaid,
                'weight'   =>  $request->weightMaid,
                'marital'   =>  $request->maritalMaid,
                'religion'   =>  $request->religionMaid,
                'education'    =>    $request->educationMaid,
                'number_of_siblings'  =>  $request->siblingsMaid,
                'number_of_children'  =>  $request->childrenNumberMaid,
                'family_background'    =>  $request->familyMaid,
                'children_ages'  =>  $request->childrenAgeMaid,
                'hobby'  =>  $request->heirMaid,
                'note'  =>  $request->noteMaid,
                'paspor_no'  =>  $request->pasporNoMaid,
                'paspor_issue'  =>  $request->placeIssueMaid,
                'paspor_date'  =>  $request->doiPasporMaid ? Carbon::parse($request->doiPasporMaid, 'Asia/Jakarta')->isoFormat('YYYY-MM-DD') : null,
                'expire_date'  =>  $request->doePasporMaid ? Carbon::parse($request->doePasporMaid, 'Asia/Jakarta')->isoFormat('YYYY-MM-DD') : null,
                'picture_location'  =>  'assets/image/maids/photos/',
                'picture_base64'    =>  base64_encode($fileBase),
                'picture_name'  =>  $fileNameFull,
                'youtube_link'  =>  $request->youtubeMaid,
                'user_updated'  =>  auth()->user()->id,
                'is_active' =>  true,
            ];

            if ($request->medicalMaid) {
                foreach ($request->medicalMaid as $key => $value) {
                    $dataMedical[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  $value == 1 ? true : false,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->LanguageMaid) {
                foreach ($request->LanguageMaid as $key => $value) {
                    $dataLanguage[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->languageMaid) {
                foreach ($request->languageMaid as $key => $value) {
                    $dataLanguage[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->cookingMaid) {
                foreach ($request->cookingMaid as $key => $value) {
                    $dataSkill[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->workChosenMaid) {
                foreach ($request->workChosenMaid as $key => $value) {
                    $dataWilling[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'is_willingness'  =>  true,
                        'note'  =>  $value == "" ? null : $value,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->interviewRateMaid) {
                foreach ($request->interviewRateMaid as $key => $value) {
                    $dataInterview[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'rate'  =>  $value,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }
        } else {
            $data = [
                convertCountry($request->countryRequest)    =>  true,
                'code_maid' =>  $request->codeMaid,
                'full_name' =>  Str::title($request->fullnameMaid),
                'sex' =>  $request->sexMaid,
                'country' =>  $request->countryMaid,
                'start_training' =>  Carbon::parse($request->dateTrainingMaid)->isoFormat('YYYY-MM-DD'),
                'place_of_birth' =>  Str::title($request->pobMaid),
                'date_of_birth' =>  Carbon::parse($request->dobMaid, 'Asia/Jakarta')->isoFormat('YYYY-MM-DD'),
                'marital'   =>  $request->maritalMaid,
                'religion'   =>  $request->religionMaid,
                'education'    =>    $request->educationMaid,
                'height'    =>  $request->heightMaid,
                'weight'    =>  $request->weightMaid,
                'contact'   =>  $request->contactMaid,
                'address'   =>  $request->addressMaid,
                'brother'   =>  $request->brotherMaid,
                'sister'    =>  $request->sisterMaid,
                'family_background'    =>  $request->familyMaid,
                'number_in_family'  =>  $request->positionMaid,
                'number_of_children'  =>  $request->childrenNumberMaid,
                'children_ages'  =>  $request->childrenAgeMaid,
                'spouse_name'  =>  $request->spouseNameMaid,
                'spouse_age'  =>  $request->spouseAgeMaid,
                'spouse_passed_away'  =>  $request->spousePassedMaid == 1 ? true : false,
                'father_name'  =>  $request->fatherNameMaid,
                'father_age'  =>  $request->fatherAgeMaid,
                'father_passed_away'  =>  $request->fatherPassedMaid == 1 ? true : false,
                'mother_name'  =>  $request->motherNameMaid,
                'mother_age'  =>  $request->motherAgeMaid,
                'mother_passed_away'  =>  $request->motherPassedMaid == 1 ? true : false,
                'picture_location'  =>  'assets/image/maids/photos/',
                'picture_base64'    =>  base64_encode($fileBase),
                'picture_name'  =>  $fileNameFull,
                'youtube_link'  =>  $request->youtubeMaid,
                'user_updated'  =>  auth()->user()->id,
                'note'  =>  $request->noteMaid,
                'is_active' =>  true,
            ];

            if ($request->languageRateMaid) {
                foreach ($request->languageRateMaid as $key => $value) {
                    $dataLanguage[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'rate'  =>  $value,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->specialityMaid) {
                foreach ($request->specialityMaid as $key => $value) {
                    $dataSkill[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->willingnessMaid) {
                foreach ($request->willingnessMaid as $key => $value) {
                    $dataWilling[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'is_willingness'    =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }

            if ($request->otherMaid) {
                foreach ($request->otherMaid as $key => $value) {
                    $dataOther[] = [
                        'maid_id'   =>  $dataMaid->id,
                        convertCountry($request->countryRequest)    =>  true,
                        'question_id'   =>  $key,
                        'answer'  =>  true,
                        'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                        'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                    ];
                }
            }
        }

        if (Maid::where('code_maid', $request->codeMaid)->update($data)) {
            $language = Language::where('maid_id', $dataMaid->id)
                ->get();

            if ($language) {
                Language::where('maid_id', $dataMaid->id)->delete();
            }

            if ($dataLanguage) {
                Language::insert($dataLanguage);
            }

            $skill = Skill::where('maid_id', $dataMaid->id)
                ->where('is_willingness', false)
                ->get();

            if ($skill) {
                Skill::where('maid_id', $dataMaid->id)
                    ->where('is_willingness', false)->delete();
            }

            if ($dataSkill) {
                foreach ($dataSkill as $key => $value) {
                    Skill::create($value);
                }
            }

            $willingness = Skill::where('maid_id', $dataMaid->id)
                ->where('is_willingness', true)
                ->get();

            if ($willingness) {
                Skill::where('maid_id', $dataMaid->id)
                    ->where('is_willingness', true)->delete();
            }

            if ($dataWilling) {
                Skill::insert($dataWilling);
            }

            $other = Other::where('maid_id', $dataMaid->id)
                ->get();

            if ($other) {
                Other::where('maid_id', $dataMaid->id)->delete();
            }

            if ($dataOther) {
                Other::insert($dataOther);
            }

            $medical = Medical::where('maid_id', $dataMaid->id)
                ->get();

            if ($medical) {
                Medical::where('maid_id', $dataMaid->id)->delete();
            }

            if ($dataMedical) {
                Medical::insert($dataMedical);
            }

            $interview = Interview::where('maid_id', $dataMaid->id)
                ->get();

            if ($interview) {
                Interview::where('maid_id', $dataMaid->id)->delete();
            }

            if ($dataInterview) {
                Interview::insert($dataInterview);
            }

            $dataDocument = Document::where('id', $dataMaid->id)
                ->first();

            if ($dataMaid->full_name != '') {
                if ($dataDocument) {
                    Document::find($dataDocument->id)->update([
                        'is_generate'   =>  false,
                    ]);
                } else {
                    Document::create([
                        'maid_id'   =>  $dataMaid->id,
                        'location_file'   =>  'assets/pdf/',
                        'file_name'   =>  $dataMaid->code_maid . ' - ' . $dataMaid->full_name . '.pdf',
                    ]);
                }


                $country = Country::where('code', $request->countryRequest)
                    ->first();

                $dataUser = null;

                if ($country) {
                    $dataUser = User::where('country_id', $country->id)
                        ->where('is_formal', false)
                        ->get();

                    if ($country->code == 'FM') {
                        if (Str::substr($dataMaid->code_maid, 0, 1) == 'M') {
                            $countryFormal = Country::where('code', 'MY')
                                ->first();

                            $dataUser = User::where('country_id', $countryFormal->id)
                                ->where('is_formal', true)
                                ->get();
                        }

                        if (Str::substr($dataMaid->code_maid, 0, 1) == 'B') {
                            $countryFormal = Country::where('code', 'BN')
                                ->first();

                            $dataUser = User::where('country_id', $countryFormal->id)
                                ->where('is_formal', true)
                                ->get();
                        }
                    }
                }

                if ($dataUser) {
                    foreach ($dataUser as $key => $value) {
                        Notification::create([
                            'tanggal'   =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD'),
                            'message'   =>  'New Worker ' . $dataMaid->code_maid . ' - ' . $dataMaid->full_name . ' is Available to you',
                            'from_user' =>  auth()->user()->id,
                            'to_user'   =>  $value->id,
                            'type'  =>  'new worker',
                        ]);
                    }
                }
            }

            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  "Data successfully added",
                    'dataMaid'  =>  $dataMaid->code_maid
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  "Data failed add"
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWorkExperience(Request $request)
    {
        if (intval($request->start) > intval($request->end)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'End Work Experience must bigger than From Work Experience'
                ]
            ]);
        }

        $dataMaid = Maid::where('code_maid', $request->maid)
            ->country($request->country)
            ->first();

        if (collect($dataMaid)->count() == 0) {
            if ($request->country === 'HK') $country = 'is_hongkong';
            if ($request->country === 'SG') $country = 'is_singapore';
            if ($request->country === 'TW') $country = 'is_taiwan';
            if ($request->country === 'MY') $country = 'is_malaysia';
            if ($request->country === 'BR') $country = 'is_brunei';
            if ($request->country === 'FM') $country = 'is_all_format';

            $dataMaid = Maid::create([
                'code_maid' =>  Str::upper($request->maid),
                $country =>  true,
                'is_active' => true,
                'user_created'  =>  auth()->user()->id,
            ]);
        }

        $data = [];

        if ($request->country == 'SG') {
            $data = [
                'maid_id'   =>  $dataMaid->id,
                'year_start'    =>  $request->start,
                'year_end'    =>  $request->end,
                'country'   =>  $request->location,
                'description'   =>  Str::upper($request->description),
                'employeer_singapore' =>  Str::upper($request->employer),
                'employeer_singapore_feedback' =>  Str::upper($request->feedback),
                'remarks' =>  Str::upper($request->remarks),
                'work_singapore'    => $request->workSingapore,
                convertCountry($request->country)   =>  true,
            ];
        } else {
            $data = [
                'maid_id'   =>  $dataMaid->id,
                'year_start'    =>  $request->start,
                'year_end'    =>  $request->end,
                'country'   =>  $request->location,
                'description'   =>  Str::upper($request->description),
                'work_overseas' =>  $request->overseas,
                convertCountry($request->country)   =>  true,
            ];
        }

        $workExperienceSave = WorkExperience::create($data);

        if ($workExperienceSave) {
            $dataQuestion = Question::where('is_active', true)
                ->where('is_work_experience', true)
                ->where(convertCountry($request->country), true)
                ->get();

            if ($dataQuestion) {
                foreach ($dataQuestion as $key => $value) {
                    foreach ($request->workExperience as $workKey => $work) {
                        if ($value->id == $workKey) {
                            if ($value->is_check && $work != null) {
                                $data = [
                                    'work_experience_id'   =>  $workExperienceSave->id,
                                    'question_id'   =>  $value->id,
                                    'answer'   =>  true,
                                    'note'   =>  null,
                                ];

                                DetailWorkExperience::create($data);
                            }
                            if ($value->is_input && $work != null) {
                                $data = [
                                    'work_experience_id'   =>  $workExperienceSave->id,
                                    'question_id'   =>  $value->id,
                                    'answer'   =>  true,
                                    'note'   =>  $work,
                                ];

                                DetailWorkExperience::create($data);
                            }
                        }
                    }
                }
            }
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data is successfuly added'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data is failed add'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function show(Maid $maid, Request $request)
    {
        $view = 'master.maid.detail.other';
        $js = 'assets/js/apps/master/maid/detail/other.js';

        $language = Question::questionMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $skill = Question::specialityMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->where('is_child', false)
            ->orderBy('id')
            ->get();

        $willingness = Question::willingnessMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $other = Question::otherMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->get();

        $medical = Question::medicalMaid($maid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $method = Question::methodMaid($maid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $interview = Question::interviewMaid($maid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        if ($request->country === 'SG') {
            $view = 'master.maid.detail.singapore';
            $js = 'assets/js/apps/master/maid/detail/singapore.js';
        }

        if ($request->country === 'FM') {
            $view = 'master.maid.detail.allFormat';
            $js = 'assets/js/apps/master/maid/detail/allFormat.js';
        }

        return view($view, [
            'title' =>  'Detail Maid ' . $maid->code_maid,
            'pageTitle' =>  'Detail Maid ' . $maid->code_maid,
            'maid'  =>  $maid,
            'languages'  =>  $language,
            'specialities'  =>  $skill,
            'willingnesses'  =>  $willingness,
            'others'  =>  $other,
            'medicals'  =>  $medical,
            'methods'  =>  $method,
            'interviews'  =>  $interview,
            'js'    =>  [
                $js,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function getDataMaid(Maid $maid)
    {
        return response()->json($maid);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function edit(Maid $maid, Request $request)
    {
        $view = 'master.maid.edit.other';
        $js = 'assets/js/apps/master/maid/edit/other.js';

        $language = Question::questionMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $skill = Question::specialityMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->where('is_child', false)
            ->orderBy('id')
            ->get();

        $willingness = Question::willingnessMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $other = Question::otherMaid($maid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->get();

        $medical = Question::medicalMaid($maid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $method = Question::methodMaid($maid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $interview = Question::interviewMaid($maid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $workExperienceCheck = Question::where('is_active', true)
            ->where('is_work_experience', true)
            ->where('is_child', false)
            ->country($request->country)
            ->get();

        if ($request->country === 'SG') {
            $view = 'master.maid.edit.singapore';
            $js = 'assets/js/apps/master/maid/edit/singapore.js';
        }

        if ($request->country === 'FM') {
            $view = 'master.maid.edit.allFormat';
            $js = 'assets/js/apps/master/maid/edit/allFormat.js';
        }

        return view($view, [
            'title' =>  'Edit Maid ' . $maid->code_maid,
            'pageTitle' =>  'Edit Maid ' . $maid->code_maid,
            'maid'  =>  $maid,
            'languages'  =>  $language,
            'specialities'  =>  $skill,
            'willingnesses'  =>  $willingness,
            'others'  =>  $other,
            'medicals'  =>  $medical,
            'methods'  =>  $method,
            'interviews'  =>  $interview,
            'workExperienceChecks'  =>  $workExperienceCheck,
            'js'    =>  [
                $js,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function editWorkExperience($id)
    {
        return response()->json(WorkExperience::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function editSkill($id)
    {
        return response()->json(Skill::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maid $maid)
    {
        $fileNameFull = $maid->picture_name;
        $fileBase = $maid->picture_base64;
        if ($request->file('photoMaid')) {
            $photoMaid = $request->file('photoMaid');

            $fileNameFull = $request->codeMaid . '.' . $photoMaid->getClientOriginalExtension();
            $fileBase = str_replace('data:image/' . $photoMaid->getClientOriginalExtension() . ';base64,', '', $photoMaid);
            $fileBase = str_replace(' ', '+', $photoMaid);

            $photoMaid->move($_SERVER['DOCUMENT_ROOT'] . '/assets/image/maids/photos/', $fileNameFull);
        }

        $data = [
            convertCountry($request->countryRequest)    =>  true,
            'code_maid' =>  $request->codeMaid,
            'full_name' =>  Str::title($request->fullNameMaid),
            'sex' =>  $request->sex,
            'country' =>  $request->countryMaid,
            'start_training' =>  Carbon::parse($request->dateTrainingMaid)->isoFormat('YYYY-MM-DD'),
            'place_of_birth' =>  Str::title($request->pobMaid),
            'date_of_birth' =>  Carbon::parse($request->dobMaid, 'Asia/Jakarta')->isoFormat('YYYY-MM-DD'),
            'marital'   =>  $request->maritalMaid,
            'religion'   =>  $request->religionMaid,
            'education'    =>    $request->educationMaid,
            'height'    =>  $request->heightMaid,
            'weight'    =>  $request->weightMaid,
            'contact'   =>  $request->contactMaid,
            'address'   =>  $request->addressMaid,
            'brother'   =>  $request->brotherMaid,
            'sister'    =>  $request->sisterMaid,
            'number_in_family'  =>  $request->positionMaid,
            'number_of_children'  =>  $request->childrenNumberMaid,
            'children_ages'  =>  $request->childrenAgeMaid,
            'spouse_name'  =>  $request->spouseNameMaid,
            'spouse_age'  =>  $request->spouseAgeMaid,
            'spouse_passed_away'  =>  $request->spousePassedMaid == 1 ? true : false,
            'father_name'  =>  $request->fatherNameMaid,
            'father_age'  =>  $request->fatherAgeMaid,
            'father_passed_away'  =>  $request->fatherPassedMaid == 1 ? true : false,
            'mother_name'  =>  $request->motherNameMaid,
            'mother_age'  =>  $request->motherAgeMaid,
            'mother_passed_away'  =>  $request->motherPassedMaid == 1 ? true : false,
            'picture_location'  =>  'assets/image/maids/photos/',
            'picture_base64'    =>  base64_encode($fileBase),
            'picture_name'  =>  $fileNameFull,
            'youtube_link'  =>  $request->youtubeMaid,
            'user_updated'  =>  auth()->user()->id,
        ];

        $dataLanguage = array();
        $dataSkill = array();
        $dataWilling = array();
        $dataOther = array();

        if ($request->languageRateMaid) {
            foreach ($request->languageRateMaid as $key => $value) {
                $dataLanguage[] = [
                    'maid_id'   =>  $maid->id,
                    convertCountry($request->countryRequest)    =>  true,
                    'question_id'   =>  $key,
                    'rate'  =>  $value,
                    'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                    'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                ];
            }
        }

        if ($request->specialityMaid) {
            foreach ($request->specialityMaid as $key => $value) {
                $dataSkill[] = [
                    'maid_id'   =>  $maid->id,
                    convertCountry($request->countryRequest)    =>  true,
                    'question_id'   =>  $key,
                    'answer'  =>  true,
                    'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                    'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                ];
            }
        }

        if ($request->willingnessMaid) {
            foreach ($request->willingnessMaid as $key => $value) {
                $dataWilling[] = [
                    'maid_id'   =>  $maid->id,
                    convertCountry($request->countryRequest)    =>  true,
                    'question_id'   =>  $key,
                    'answer'  =>  true,
                    'is_willingness'    =>  true,
                    'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                    'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                ];
            }
        }

        if ($request->otherMaid) {
            foreach ($request->otherMaid as $key => $value) {
                $dataOther[] = [
                    'maid_id'   =>  $maid->id,
                    convertCountry($request->countryRequest)    =>  true,
                    'question_id'   =>  $key,
                    'answer'  =>  true,
                    'created_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss'),
                    'updated_at'    =>  Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
                ];
            }
        }

        if (Maid::where('code_maid', $maid->codeMaid)->update($data)) {
            if ($dataLanguage) {
                $language = Language::where('maid_id', $maid->id)
                    ->get();

                if ($language) {
                    Language::where('maid_id', $maid->id)->delete();
                }

                Language::insert($dataLanguage);
            }

            if ($dataSkill) {
                $skill = Skill::where('maid_id', $maid->id)
                    ->where('is_willingness', false)
                    ->get();

                if ($skill) {
                    Skill::where('maid_id', $maid->id)
                        ->where('is_willingness', false)->delete();
                }

                Skill::insert($dataSkill);
            }

            if ($dataWilling) {
                $willingness = Skill::where('maid_id', $maid->id)
                    ->where('is_willingness', true)
                    ->get();

                if ($willingness) {
                    Skill::where('maid_id', $maid->id)
                        ->where('is_willingness', true)->delete();
                }

                Skill::insert($dataWilling);
            }

            if ($dataOther) {
                $other = Other::where('maid_id', $maid->id)
                    ->get();

                if ($other) {
                    Other::where('maid_id', $maid->id)->delete();
                }

                Other::insert($dataOther);
            }

            $dataDocument = Document::where('id', $maid->id)
                ->first();

            if ($dataDocument) {
                Document::find($dataDocument->id)->update([
                    'is_generate'   =>  false,
                ]);
            } else {
                Document::create([
                    'maid_id'   =>  $maid->id,
                    'location_file'   =>  'assets/pdf/',
                    'file_name'   =>  $maid->code_maid . ' - ' . $maid->full_name . '.pdf',
                ]);
            }

            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  "Data successfully added",
                    'dataMaid'  =>  $maid->code_maid
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  "Data failed add"
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function updateWorkExperience(Request $request, $id)
    {
        if (intval($request->start) > intval($request->end)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'End Work Experience must bigger than From Work Experience'
                ]
            ]);
        }

        $data = [];

        if ($request->country == 'SG') {
            $data = [
                'maid_id'   =>  Maid::where('code_maid', $request->maid)->country($request->country)->first('id')->id,
                'year_start'    =>  $request->start,
                'year_end'    =>  $request->end,
                'country'   =>  $request->location,
                'description'   =>  Str::upper($request->description),
                'employeer_singapore' =>  Str::upper($request->employer),
                'employeer_singapore_feedback' =>  Str::upper($request->feedback),
                'remarks' =>  Str::upper($request->remarks),
                'work_singapore'    => $request->workSingapore,
                convertCountry($request->country)   =>  true,
            ];
        } else {
            $data = [
                'maid_id'   =>  Maid::where('code_maid', $request->maid)->country($request->country)->first('id')->id,
                'year_start'    =>  $request->start,
                'year_end'    =>  $request->end,
                'country'   =>  $request->location,
                'description'   =>  Str::upper($request->description),
                'work_overseas' =>  $request->overseas,
                convertCountry($request->country)   =>  true,
            ];
        }


        if (WorkExperience::find($id)->update($data)) {
            DetailWorkExperience::where('work_experience_id', $id)->delete();
            $dataQuestion = Question::where('is_active', true)
                ->where('is_work_experience', true)
                ->where(convertCountry($request->country), true)
                ->get();

            if ($dataQuestion) {
                foreach ($dataQuestion as $key => $value) {
                    foreach ($request->workExperience as $workKey => $work) {
                        if ($value->id == $workKey) {
                            if ($value->is_check && $work != null) {
                                $data = [
                                    'work_experience_id'   =>  $id,
                                    'question_id'   =>  $value->id,
                                    'answer'   =>  true,
                                    'note'   =>  null,
                                ];

                                DetailWorkExperience::create($data);
                            }
                            if ($value->is_input && $work != null) {
                                $data = [
                                    'work_experience_id'   =>  $id,
                                    'question_id'   =>  $value->id,
                                    'answer'   =>  true,
                                    'note'   =>  $work,
                                ];

                                DetailWorkExperience::create($data);
                            }
                        }
                    }
                }
            }
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data is successfuly updated'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Data is failed update'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maid  $maid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maid $maid)
    {
        if (Maid::where('id', $maid->id)->update([
            'is_trash'  =>  true,
            'user_trashed'  =>  auth()->user()->id,
            'trashed_at'    => Carbon::now('Asia/Jakarta')->isoFormat('YYYY-MM-DD HH:mm:ss')
        ])) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data is successfuly trashed'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  true,
                'message'   =>  'Data is failed delete'
            ]
        ]);
    }

    public function destroyWorkExperience($id)
    {
        if (WorkExperience::where('id', $id)->delete()) {
            DetailWorkExperience::where('work_experience_id', $id)->delete();

            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Data is successfuly deleted'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  true,
                'message'   =>  'Data is failed delete'
            ]
        ]);
    }

    public function generateCounter(Request $request)
    {
        // $dataCounter = createCounter(Str::upper($request->maid), 'maid');
        // $dataCounter = columnToID('maid', 'code_maid', $request->maid);
        $dataCounter = Maid::where('code_maid', $request->maid)
            ->first();

        if ($request->country === 'HK') $country = 'is_hongkong';
        if ($request->country === 'SG') $country = 'is_singapore';
        if ($request->country === 'TW') $country = 'is_taiwan';
        if ($request->country === 'MY') $country = 'is_malaysia';
        if ($request->country === 'BR') $country = 'is_brunei';
        if ($request->country === 'FM') $country = 'is_all_format';

        if ($dataCounter) {
            if ($dataCounter->is_trash) {
                return response()->json([
                    'data'  =>  [
                        'status'    =>  false,
                        'message'   =>  'Data with Code <b>' . $dataCounter->code_maid . '</b> is in Trash. Please Delete or Activated the data'
                    ]
                ]);
            }

            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  'Data with Code <b>' . $dataCounter->code_maid . '</b> is registered. Please change the Code'
                ]
            ]);
        }

        if (Maid::create([
            'code_maid' =>  Str::upper($request->maid),
            $country =>  true,
            'is_active' => true,
            'user_created'  =>  auth()->user()->id,
        ])) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'codeMaid' => Str::upper($request->maid)
                ]
            ]);
        } else {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message' => "Something wrong while get code"
                ]
            ]);
        }
    }

    public function getCountry(Request $request)
    {
        return response()->json(Country::firstWhere('id', $request->country));
    }

    public function getWorkExperience(Request $request)
    {
        $dataWork = WorkExperience::whereHas('maid', fn ($query) => ($query->where('code_maid', $request->maid)->country($request->country)))
            ->get();

        $results = array();

        if ($dataWork) {
            foreach ($dataWork as $key => $value) {
                $detailWork = '';
                if (collect($value->detailWork)->count() > 0) {
                    $detailWork = '<ul>';
                    foreach ($value->detailWork as $keyDW => $dw) {
                        $detailWork .= '<li>';
                        if ($dw->question->is_input) {
                            $detailWork .= $dw->question->question . ' ' . $dw->note;
                            switch ($dw->question->additional_note) {
                                case 'baby':
                                    $detailWork .= ' month old baby';
                                    break;

                                case 'child':
                                    $detailWork .= ' year old child';
                                    break;

                                case 'ahkong':
                                    $detailWork .= ' year old ahkong';
                                    break;

                                case 'ahma':
                                    $detailWork .= ' year old ahma';
                                    break;

                                default:
                                    $detailWork .= ' years';
                                    break;
                            }
                        }

                        if ($dw->question->is_check) {
                            $detailWork .= $dw->question->question;
                        }
                        $detailWork .= '</li>';
                    }
                    $detailWork .= '</ul>';
                }

                if ($request->country == 'SG') {
                    $results[] = [
                        $value->year_start,
                        $value->year_end,
                        $value->country,
                        $value->employeer_singapore,
                        $detailWork ? $detailWork : $value->description,
                        $value->remarks,
                        '<div class="d-flex gap-2">
                            <a href="javascript:;" onClick="fnFormMaid.onEditWork(\'' . $value->id . '\')" class="btn btn-outline-warning"><i class="fa-solid fa-edit"></i></a>
                            <a href="javascript:;" onClick="fnFormMaid.onDeleteWork(\'' . $value->id . '\',\'' . csrf_token() . '\')" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                        </div>'
                    ];
                } else {
                    $results[] = [
                        $key + 1,
                        $value->year_start,
                        $value->year_end,
                        $value->country,
                        $detailWork ? $detailWork : $value->description,
                        '<div class="d-flex gap-2">
                            <a href="javascript:;" onClick="fnFormMaid.onEditWork(\'' . $value->id . '\')" class="btn btn-outline-warning"><i class="fa-solid fa-edit"></i></a>
                            <a href="javascript:;" onClick="fnFormMaid.onDeleteWork(\'' . $value->id . '\',\'' . csrf_token() . '\')" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                        </div>'
                    ];
                }
            }
        }
        return response()->json(['data' => $results]);
    }

    public function getWorkFeedback(Request $request)
    {
        $dataWork = WorkExperience::whereHas('maid', fn ($query) => ($query->where('code_maid', $request->maid)->country($request->country)))
            ->whereNotNull('employeer_singapore')
            ->where('work_singapore', true)
            ->get();

        $results = array();

        if ($dataWork) {
            foreach ($dataWork as $key => $value) {
                $displayNone = auth()->user()->role->slug == "super-admin" ? '' : 'd-none';

                if ($request->country == 'SG') {
                    $results[] = [
                        $value->employeer_singapore,
                        $value->employeer_singapore_feedback == '' ? 'N/A' : $value->employeer_singapore_feedback,
                    ];
                } else {
                    $results[] = [
                        $key + 1,
                        $value->year_start,
                        $value->year_end,
                        $value->country,
                        $value->description,
                        '<div class="d-flex gap-2">
                            <a href="javascript:;" onClick="fnFormMaid.onEditWork(\'' . $value->id . '\')" class="btn btn-outline-warning"><i class="fa-solid fa-edit"></i></a>
                            <a href="javascript:;" onClick="fnFormMaid.onDeleteWork(\'' . $value->id . '\',\'' . csrf_token() . '\')" class="btn btn-outline-danger ' . $displayNone . '"><i class="fa-solid fa-trash"></i></a>
                        </div>'
                    ];
                }
            }
        }
        return response()->json(['data' => $results]);
    }

    public function getEmployeeSkill(Request $request)
    {
        $dataSkill = Skill::whereHas('maid', fn ($query) => ($query->where('code_maid', $request->maid)->country($request->country)))
            ->country($request->country)
            ->get();

        $results = array();

        if ($dataSkill) {
            foreach ($dataSkill as $key => $value) {
                $dataQuestion = Question::where('id', $value->question_id)
                    ->first();

                $rate = $value->rate === 0 ? 'N/A' : $value->rate;
                $title = $dataQuestion->id == 38 ? 'Please specify age range:' : '';
                $results[] = [
                    $key + 1,
                    '<div>' . $dataQuestion->question . '</div>
                    <div>' . $title . '</div>
                    <div>' . $value->note . '</div>',
                    $value->answer ? 'Yes' : 'No',
                    $value->is_experience ? $value->note_experience : 'No',
                    '<div>Rate : ' . $rate . '</div>
                    <div>' . $value->note_observation . '</div>',
                    '<div class="d-flex gap-2">
                            <a href="javascript:;" onClick="fnFormMaid.onEditSkill(\'' . $value->id . '\',\'' . $value->question_id . '\')" class="btn btn-outline-warning"><i class="fa-solid fa-edit"></i></a>
                        </div>'
                ];
            }
        }

        return response()->json(['data' => $results]);
    }

    public function downloadData(Request $request)
    {
        set_time_limit(0);
        $dataMaid = Maid::where('code_maid', $request->maid)
            ->country($request->country)
            ->first();

        $language = Question::questionMaid($dataMaid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $skill = Question::specialityMaid($dataMaid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->where('is_child', false)
            ->orderBy('id')
            ->get();

        $willingness = Question::willingnessMaid($dataMaid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $other = Question::otherMaid($dataMaid->id)
            ->where('is_active', true)
            ->country($request->country)
            ->get();

        $medical = Question::medicalMaid($dataMaid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $medicaltotal = collect(Question::medicalMaid($dataMaid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->where('is_check', true)
            ->country($request->country)
            ->orderBy('id')
            ->get())->count();

        $medicalLeft = Question::medicalMaid($dataMaid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->where('is_check', true)
            ->country($request->country)
            ->orderBy('id')
            ->limit(ceil($medicaltotal / 2))
            ->get();

        $medicalRight = Question::medicalMaid($dataMaid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->where('is_check', true)
            ->country($request->country)
            ->orderBy('id')
            ->skip(ceil($medicaltotal / 2))
            ->limit($medicaltotal - ceil($medicaltotal / 2))
            ->get();

        $method = Question::methodMaid($dataMaid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $interview = Question::interviewMaid($dataMaid->id)
            ->where('is_active', true)
            ->where('is_child', false)
            ->country($request->country)
            ->orderBy('id')
            ->get();

        $workOverseases = WorkExperience::where('maid_id', $dataMaid->id)
            ->country($request->country)
            ->where('work_overseas', true)
            ->get();

        $workDomestics = WorkExperience::where('maid_id', $dataMaid->id)
            ->country($request->country)
            ->where('work_overseas', false)
            ->get();

        $workExperience = WorkExperience::where('maid_id', $dataMaid->id)
            ->country($request->country)
            ->get();

        // dd($workExperience);

        $path = public_path('assets/image/header/header.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $dataLogo = file_get_contents($path);
        $baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($dataLogo);

        $view = 'master.maid.pdf.other';

        if ($request->country == 'SG') {
            $view = 'master.maid.pdf.singapore';
        }

        if ($request->country == 'FM') {
            if (substr($dataMaid->code_maid, 0, 1) == "M") {
                $view = 'master.maid.pdf.allFormatA';
            } else {
                $view = 'master.maid.pdf.allFormatB';
            }
        }

        $photoPath = $dataMaid->picture_name ? public_path('assets/image/maids/photos/' . $dataMaid->picture_name) : public_path('assets/image/web/no_content.jpg');
        $photoType = pathinfo($photoPath, PATHINFO_EXTENSION);
        $dataPhoto = file_get_contents($photoPath);
        $basePhoto = 'data:image/' . $photoType . ';base64,' . base64_encode($dataPhoto);

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $html = view($view, [
            'title' =>  $dataMaid->code_maid,
            'maid'  =>  $dataMaid,
            'languages'  =>  $language,
            'specialities'  =>  $skill,
            'willingnesses'  =>  $willingness,
            'others'  =>  $other,
            'header'    =>  $baseLogo,
            'photo'    =>  $basePhoto,
            'overseases'    =>  $workOverseases,
            'domestics'    =>  $workDomestics,
            'medicals'  =>  $medical,
            'medicalsLeft'  =>  $medicalLeft,
            'medicalsRight'  =>  $medicalRight,
            'methods'   =>  $method,
            'interviews'    =>  $interview,
            'workExperience'    =>  $workExperience,
            'pdf'   =>  $pdf,
        ]);

        if (File::exists(public_path('assets/pdf/' . $dataMaid->code_maid . ' - ' . $dataMaid->full_name . '.pdf'))) {
            File::delete(public_path('assets/pdf/' . $dataMaid->code_maid . ' - ' . $dataMaid->full_name . '.pdf'));
        }

        PDF::createPDF($html, $dataMaid->code_maid . ' - ' . $dataMaid->full_name . '.pdf', false);
        exit;

        // return response()->download(public_path('assets/pdf/' . $dataMaid->code_maid . ' - ' . $dataMaid->full_name . '.pdf'));
    }

    public function getTrashedData(Request $request)
    {
        $dataMaid = Maid::with(['userCreated', 'userUpdated'])
            ->where('is_active', true)
            ->where('is_trash', true)
            ->where('is_blacklist', false)
            ->where('is_delete', false)
            ->latest()
            ->filter(['search' => request('search', 'country')])
            ->paginate(10);
    }

    public function sendMail()
    {
        return view('master.maid.mail.index', [
            'title' =>  'Available Worker Mail',
            'pageTitle' =>  'Available Worker Mail',
            'js'    =>  ['assets/js/apps/master/maid/mail/app.js'],
        ]);
    }

    public function sendingMail(Request $request)
    {
        $data = array();
        $arrWorker = array();
        $docs = array();

        $agencies = explode(',', $request->agencies);

        foreach ($agencies as $key => $agency) {
            foreach ($request->workers as $key => $worker) {
                $dataWorker = Maid::where('id', $worker)->first();

                $arrWorker[] = $dataWorker;
                $docs[] = '/assets/pdf/' . $dataWorker->code_maid . ' - ' . $dataWorker->full_name . '.pdf';
                $this->generateDocument($dataWorker);
            }
            $data[] = [
                'email' =>  Str::remove(' ', $agency),
                'files_all' =>  json_encode($docs),
                'maid_all'  =>  json_encode($arrWorker),
                'title' =>  'Available Workers',
                'created_at'    =>  Carbon::now('Asia/Jakarta'),
                'is_blast'  =>  true,
            ];
        }

        if (EmailSending::insert($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  "Email success to send",
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  "Email fail to send",
            ]
        ]);
    }

    public function generateDocument($maidData)
    {
        if ($maidData) {
            $country = 'FM';

            if ($maidData->is_hongkong) $country = 'HK';
            if ($maidData->is_taiwan) $country = 'TW';
            if ($maidData->is_singapore) $country = 'SG';
            if ($maidData->is_malaysia) $country = 'MY';
            if ($maidData->is_brunei) $country = 'BN';

            $language = Question::questionMaid($maidData->id)
                ->where('is_active', true)
                ->country($country)
                ->orderBy('id')
                ->get();

            $skill = Question::specialityMaid($maidData->id)
                ->where('is_active', true)
                ->country($country)
                ->where('is_child', false)
                ->orderBy('id')
                ->get();

            $willingness = Question::willingnessMaid($maidData->id)
                ->where('is_active', true)
                ->country($country)
                ->orderBy('id')
                ->get();

            $other = Question::otherMaid($maidData->id)
                ->where('is_active', true)
                ->country($country)
                ->get();

            $medical = Question::medicalMaid($maidData->id)
                ->where('is_active', true)
                ->where('is_child', false)
                ->country($country)
                ->orderBy('id')
                ->get();

            $medicaltotal = collect(Question::medicalMaid($maidData->id)
                ->where('is_active', true)
                ->where('is_child', false)
                ->where('is_check', true)
                ->country($country)
                ->orderBy('id')
                ->get())->count();

            $medicalLeft = Question::medicalMaid($maidData->id)
                ->where('is_active', true)
                ->where('is_child', false)
                ->where('is_check', true)
                ->country($country)
                ->orderBy('id')
                ->limit(ceil($medicaltotal / 2))
                ->get();

            $medicalRight = Question::medicalMaid($maidData->id)
                ->where('is_active', true)
                ->where('is_child', false)
                ->where('is_check', true)
                ->country($country)
                ->orderBy('id')
                ->skip(ceil($medicaltotal / 2))
                ->limit($medicaltotal - ceil($medicaltotal / 2))
                ->get();

            $method = Question::methodMaid($maidData->id)
                ->where('is_active', true)
                ->where('is_child', false)
                ->country($country)
                ->orderBy('id')
                ->get();

            $interview = Question::interviewMaid($maidData->id)
                ->where('is_active', true)
                ->where('is_child', false)
                ->country($country)
                ->orderBy('id')
                ->get();

            $workOverseases = WorkExperience::where('maid_id', $maidData->id)
                ->country($country)
                ->where('work_overseas', true)
                ->get();

            $workDomestics = WorkExperience::where('maid_id', $maidData->id)
                ->country($country)
                ->where('work_overseas', false)
                ->get();

            $path = public_path('assets/image/header/header.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $dataLogo = file_get_contents($path);
            $baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($dataLogo);

            $view = 'master.maid.pdf.other';

            if ($country == 'SG') {
                $view = 'master.maid.pdf.singapore';
            }

            if ($country == 'FM') {
                if (substr($maidData->code_maid, 0, 1) == "M") {
                    $view = 'master.maid.pdf.allFormatA';
                } else {
                    $view = 'master.maid.pdf.allFormatB';
                }
            }

            $photoPath = $maidData->picture_name ? public_path('assets/image/maids/photos/' . $maidData->picture_name) : public_path('assets/image/web/no_content.jpg');
            $photoType = pathinfo($photoPath, PATHINFO_EXTENSION);
            $dataPhoto = file_get_contents($photoPath);
            $basePhoto = 'data:image/' . $photoType . ';base64,' . base64_encode($dataPhoto);

            $pdf = app('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);

            $html = view($view, [
                'title' =>  $maidData->code_maid,
                'maid'  =>  $maidData,
                'languages'  =>  $language,
                'specialities'  =>  $skill,
                'willingnesses'  =>  $willingness,
                'others'  =>  $other,
                'header'    =>  $baseLogo,
                'photo'    =>  $basePhoto,
                'overseases'    =>  $workOverseases,
                'domestics'    =>  $workDomestics,
                'medicals'  =>  $medical,
                'medicalsLeft'  =>  $medicalLeft,
                'medicalsRight'  =>  $medicalRight,
                'methods'   =>  $method,
                'interviews'    =>  $interview,
                'pdf'   =>  $pdf,
            ]);

            if (File::exists(public_path('assets/pdf/' . $maidData->code_maid . ' - ' . $maidData->full_name . '.pdf'))) {
                File::delete(public_path('assets/pdf/' . $maidData->code_maid . ' - ' . $maidData->full_name . '.pdf'));
            }

            PDF::createDownloadPDF($html, $maidData->code_maid . ' - ' . $maidData->full_name . '.pdf', false);

            return true;
        }
    }

    public function exportExcel(Request $request)
    {
        if ($request->country != "FM" && $request->country != "SG") {
            (new ExcelOtherController)->exportExcel($request);
        }

        if ($request->country == "SG") {
            (new ExcelSingaporeController)->exportExcel($request);
        }

        if ($request->country == "FM") {
            (new ExcelFormalController)->exportExcel($request);
        }
    }
}
