<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\Master\Maid\Maid;
use App\Models\Master\Maid\WorkExperience;
use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use PDF;

class GenerateDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dataMaid = Document::getData()
            ->get();

        if (collect($dataMaid)->count() > 0) {
            foreach ($dataMaid as $key => $value) {
                $maid = Maid::find($value->id);

                if ($maid) {
                    $country = 'FM';

                    if ($maid->is_hongkong) $country = 'HK';
                    if ($maid->is_taiwan) $country = 'TW';
                    if ($maid->is_singapore) $country = 'SG';
                    if ($maid->is_malaysia) $country = 'MY';
                    if ($maid->is_brunei) $country = 'BN';

                    $language = Question::questionMaid($maid->id)
                        ->where('is_active', true)
                        ->country($country)
                        ->orderBy('id')
                        ->get();

                    $skill = Question::specialityMaid($maid->id)
                        ->where('is_active', true)
                        ->country($country)
                        ->where('is_child', false)
                        ->orderBy('id')
                        ->get();

                    $willingness = Question::willingnessMaid($maid->id)
                        ->where('is_active', true)
                        ->country($country)
                        ->orderBy('id')
                        ->get();

                    $other = Question::otherMaid($maid->id)
                        ->where('is_active', true)
                        ->country($country)
                        ->get();

                    $medical = Question::medicalMaid($maid->id)
                        ->where('is_active', true)
                        ->where('is_child', false)
                        ->country($country)
                        ->orderBy('id')
                        ->get();

                    $medicaltotal = collect(Question::medicalMaid($maid->id)
                        ->where('is_active', true)
                        ->where('is_child', false)
                        ->where('is_check', true)
                        ->country($country)
                        ->orderBy('id')
                        ->get())->count();

                    $medicalLeft = Question::medicalMaid($maid->id)
                        ->where('is_active', true)
                        ->where('is_child', false)
                        ->where('is_check', true)
                        ->country($country)
                        ->orderBy('id')
                        ->limit(ceil($medicaltotal / 2))
                        ->get();

                    $medicalRight = Question::medicalMaid($maid->id)
                        ->where('is_active', true)
                        ->where('is_child', false)
                        ->where('is_check', true)
                        ->country($country)
                        ->orderBy('id')
                        ->skip(ceil($medicaltotal / 2))
                        ->limit($medicaltotal - ceil($medicaltotal / 2))
                        ->get();

                    $method = Question::methodMaid($maid->id)
                        ->where('is_active', true)
                        ->where('is_child', false)
                        ->country($country)
                        ->orderBy('id')
                        ->get();

                    $interview = Question::interviewMaid($maid->id)
                        ->where('is_active', true)
                        ->where('is_child', false)
                        ->country($country)
                        ->orderBy('id')
                        ->get();

                    $workOverseases = WorkExperience::where('maid_id', $maid->id)
                        ->country($country)
                        ->where('work_overseas', true)
                        ->get();

                    $workDomestics = WorkExperience::where('maid_id', $maid->id)
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
                        if (substr($maid->code_maid, 0, 1) == "M") {
                            $view = 'master.maid.pdf.allFormatA';
                        } else {
                            $view = 'master.maid.pdf.allFormatB';
                        }
                    }

                    $photoPath = $maid->picture_name ? public_path('assets/image/maids/photos/' . $maid->picture_name) : public_path('assets/image/web/no_content.jpg');
                    $photoType = pathinfo($photoPath, PATHINFO_EXTENSION);
                    $dataPhoto = file_get_contents($photoPath);
                    $basePhoto = 'data:image/' . $photoType . ';base64,' . base64_encode($dataPhoto);

                    $pdf = app('dompdf.wrapper');
                    $pdf->getDomPDF()->set_option("enable_php", true);

                    $html = view($view, [
                        'title' =>  $maid->code_maid,
                        'maid'  =>  $maid,
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

                    if (File::exists(public_path('assets/pdf/' . $maid->code_maid . ' - ' . $maid->full_name . '.pdf'))) {
                        File::delete(public_path('assets/pdf/' . $maid->code_maid . ' - ' . $maid->full_name . '.pdf'));
                    }

                    PDF::createDownloadPDF($html, $maid->code_maid . ' - ' . $maid->full_name . '.pdf', false);

                    Document::create([
                        'maid_id'   =>  $maid->id,
                        'location_file' =>  'assets/pdf/',
                        'file_name' =>  $maid->code_maid . ' - ' . $maid->full_name . '.pdf',
                        'is_generate'   =>  true,
                    ]);

                    $this->info('Generate Document For ' . $maid->code_maid);
                }
            }
        }
        $this->info('Data is null');
    }
}
