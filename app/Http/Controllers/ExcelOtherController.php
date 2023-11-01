<?php

namespace App\Http\Controllers;

use App\Models\Master\Maid\Maid;
use App\Models\Master\Maid\WorkExperience;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelOtherController extends Controller
{
    public function exportExcel(Request $request)
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(0);
        $spreadsheet->getActiveSheet()->setTitle("$dataMaid->code_maid");
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri Light');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        $columns = excelColumn("A", "ZZ");

        foreach ($columns as $key => $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setWidth(3);
            if ($column == 'P') {
                $spreadsheet->getActiveSheet()->getColumnDimension($column)->setWidth(1);
            }
        }

        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Header');
        $drawing->setDescription('Header');
        $drawing->setPath(public_path('assets/image/header/header.png'));
        $drawing->setHeight(108);

        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        if ($request->country != 'SG' && $request->country != 'FM') {
            $sheet->setCellValue("A8", "女傭履歷表 / Biodata");
            $sheet->mergeCells("A8:O8");

            $spreadsheet->getActiveSheet()->getStyle('A8:O8')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $sheet->setCellValue("A9", "編號 / Code");
            $sheet->mergeCells("A9:G9");
            $sheet->setCellValue("H9", ":");
            $sheet->setCellValue("I9", $dataMaid->code_maid);
            $sheet->mergeCells("I9:O9");

            $sheet->setCellValue("A10", "姓名 / Name");
            $sheet->mergeCells("A10:G10");
            $sheet->setCellValue("H10", ":");
            $sheet->setCellValue("I10", Str::upper($dataMaid->full_name));
            $sheet->mergeCells("I10:O10");

            $sheet->setCellValue("A11", "國家 / Country");
            $sheet->mergeCells("A11:G11");
            $sheet->setCellValue("H11", ":");
            $sheet->setCellValue("I11", Str::upper($dataMaid->country));
            $sheet->mergeCells("I11:O11");

            $sheet->setCellValue("A12", "始訓日期 / Start Training");
            $sheet->mergeCells("A12:G12");
            $sheet->setCellValue("H12", ":");
            $sheet->setCellValue("I12", Carbon::parse($dataMaid->date_training)->isoFormat('DD MMMM YYYY'));
            $sheet->mergeCells("I12:O12");

            $sheet->setCellValue("A13", "年齡 / Age");
            $sheet->mergeCells("A13:G13");
            $sheet->setCellValue("H13", ":");
            $sheet->setCellValue("I13", Carbon::parse($dataMaid->date_of_birth)->age . " 年/Years");
            $sheet->mergeCells("I13:O13");

            $sheet->setCellValue("A14", "出生地點 / Place of Birth");
            $sheet->mergeCells("A14:G14");
            $sheet->setCellValue("H14", ":");
            $sheet->setCellValue("I14", $dataMaid->place_of_birth);
            $sheet->mergeCells("I14:O14");

            $sheet->setCellValue("A15", "出生日期 / Date of Birth");
            $sheet->mergeCells("A15:G15");
            $sheet->setCellValue("H15", ":");
            $sheet->setCellValue("I15", Carbon::parse($dataMaid->date_of_birth)->isoFormat("DD MMMM YYYY"));
            $sheet->mergeCells("I15:O15");

            $sheet->setCellValue("A16", "身高 / Height");
            $sheet->mergeCells("A16:G16");
            $sheet->setCellValue("H16", ":");
            $sheet->setCellValue("I16", $dataMaid->height . " cm");
            $sheet->mergeCells("I16:O16");

            $sheet->setCellValue("A17", "體重 / Weight");
            $sheet->mergeCells("A17:G17");
            $sheet->setCellValue("H17", ":");
            $sheet->setCellValue("I17", $dataMaid->weight . " kg");
            $sheet->mergeCells("I17:O17");

            $sheet->setCellValue("A18", "學歷 / Education Background");
            $sheet->mergeCells("A18:G18");
            $sheet->setCellValue("H18", ":");
            $sheet->setCellValue("I18", convertEducation($dataMaid->education));
            $sheet->mergeCells("I18:O18");

            $sheet->setCellValue("A19", "宗教 / Religion");
            $sheet->mergeCells("A19:G19");
            $sheet->setCellValue("H19", ":");
            $sheet->setCellValue("I19", convertReligion($dataMaid->religion));
            $sheet->mergeCells("I19:O19");

            $sheet->setCellValue("A20", "婚姻 / Marital Status");
            $sheet->mergeCells("A20:G20");
            $sheet->setCellValue("H20", ":");
            $sheet->setCellValue("I20", convertMaritalStatus($dataMaid->marital));
            $sheet->mergeCells("I20:O20");

            $sheet->setCellValue("A21", "家中排行 / Position In Family");
            $sheet->mergeCells("A21:G21");
            $sheet->setCellValue("H21", ":");
            $sheet->setCellValue("I21", $dataMaid->number_in_family);
            $sheet->mergeCells("I21:O21");

            $spreadsheet->getActiveSheet()->getStyle("I21")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $sheet->setCellValue("A22", "姐妹 / Sister");
            $sheet->mergeCells("A22:G22");
            $sheet->setCellValue("H22", ":");
            $sheet->setCellValue("I22", ($dataMaid->sister == null ? 0 : $dataMaid->sister));
            $sheet->mergeCells("I22:O22");

            $spreadsheet->getActiveSheet()->getStyle("I22")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $sheet->setCellValue("A23", "兄弟 / Brother");
            $sheet->mergeCells("A23:G23");
            $sheet->setCellValue("H23", ":");
            $sheet->setCellValue("I23", ($dataMaid->brother == null ? 0 : $dataMaid->brother));
            $sheet->mergeCells("I23:O23");

            $spreadsheet->getActiveSheet()->getStyle("I23")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $sheet->setCellValue("A24", "家庭背景 / Family Background");
            $sheet->mergeCells("A24:G24");
            $sheet->setCellValue("H24", ":");
            $sheet->setCellValue("I24", ($dataMaid->family_background == null ? "'-" : $dataMaid->family_background));
            $sheet->mergeCells("I24:O24");

            $sheet->setCellValue("A25", "兒女數目 / Number of Children");
            $sheet->mergeCells("A25:G25");
            $sheet->setCellValue("H25", ":");
            $sheet->setCellValue("I25", ($dataMaid->number_of_children == null ? "'-" : $dataMaid->number_of_children));
            $sheet->mergeCells("I25:O25");

            $spreadsheet->getActiveSheet()->getStyle("I25")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $sheet->setCellValue("A26", "兒女年齡 / Age");
            $sheet->mergeCells("A26:G26");
            $sheet->setCellValue("H26", ":");
            $sheet->setCellValue("I26", ($dataMaid->children_ages == null ? "'-" : $dataMaid->children_ages));
            $sheet->mergeCells("I26:O26");

            $spreadsheet->getActiveSheet()->getStyle("I26")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $sheet->setCellValue("A27", ($dataMaid->sex == 1 ? '妻子的名字' : ($dataMaid->sex == 2 ? '丈夫姓名' : '配偶的姓名') . " / " . ($dataMaid->sex == 1 ? 'Wife Name' : ($dataMaid->sex == 2 ? 'Husband Name' : 'Spouse Name'))));
            $sheet->mergeCells("A27:G27");
            $sheet->setCellValue("H27", ":");
            $sheet->setCellValue("I27", ($dataMaid->spouse_name == null ? "'-" : $dataMaid->spouse_name));
            $sheet->mergeCells("I27:O27");


            $sheet->setCellValue("A28", "丈夫年齡/ Age");
            $sheet->mergeCells("A28:G28");
            $sheet->setCellValue("H28", ":");
            $sheet->setCellValue("I28", ($dataMaid->spouse_passed_away == 1 ? "Passed Away" : ($dataMaid->spouse_age == null ? "'-" : $dataMaid->spouse_age)));
            $sheet->mergeCells("I28:O28");

            $spreadsheet->getActiveSheet()->getStyle("I28")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $sheet->setCellValue("A29", "父親姓名 / Father Name");
            $sheet->mergeCells("A29:G29");
            $sheet->setCellValue("H29", ":");
            $sheet->setCellValue("I29", ($dataMaid->father_name == null ? "'" : $dataMaid->father_name));
            $sheet->mergeCells("I29:O29");

            $sheet->setCellValue("A30", "丈夫年齡/ Age");
            $sheet->mergeCells("A30:G30");
            $sheet->setCellValue("H30", ":");
            $sheet->setCellValue("I30", ($dataMaid->father_passed_away == 1 ? "Passed Away" : ($dataMaid->father_age == null ? "'-" : $dataMaid->father_age)));
            $sheet->mergeCells("I30:O30");

            $spreadsheet->getActiveSheet()->getStyle("I30")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $sheet->setCellValue("A31", "母親姓名 / Mother Name");
            $sheet->mergeCells("A31:G31");
            $sheet->setCellValue("H31", ":");
            $sheet->setCellValue("I31", ($dataMaid->mother_name == null ? "'-" : $dataMaid->mother_name));
            $sheet->mergeCells("I31:O31");

            $sheet->setCellValue("A32", "丈夫年齡/ Age");
            $sheet->mergeCells("A32:G32");
            $sheet->setCellValue("H32", ":");
            $sheet->setCellValue("I32", ($dataMaid->mother_passed_away == 1 ? "Passed Away" : ($dataMaid->mother_age == null ? "'-" : $dataMaid->mother_age)));
            $sheet->mergeCells("I32:O32");

            $spreadsheet->getActiveSheet()->getStyle("I32")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ]);

            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Photo');
            $drawing->setDescription('Photo');
            $drawing->setPath(public_path('assets/image/maids/photos/' . $dataMaid->picture_name));
            $drawing->setCoordinates('A33');
            $drawing->setHeight(460);

            $drawing->setWorksheet($spreadsheet->getActiveSheet());

            $sheet->setCellValue("Q8", "工作經驗 / Working Experience");
            $sheet->mergeCells("Q8:AG8");

            $spreadsheet->getActiveSheet()->getStyle('Q8:AG8')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $sheet->setCellValue("Q9", "國外工作經驗 / Overseas Experience :");
            $sheet->mergeCells("Q9:AG9");

            $baris = 10;
            if (collect($workOverseases)->count() == 0) {
                $sheet->mergeCells("Q10:AG14");
                $spreadsheet->getActiveSheet()->getStyle('Q10:AG14')->applyFromArray([
                    'borders' => [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        ],
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $baris = 14;
            } else {
                $work = null;
                if (collect($workOverseases)->count() > 0) {
                    foreach ($workOverseases as $key => $overseas) {
                        $work .= $overseas->country . "(" . $overseas->year_start . " - " . $overseas->year_end . ")\n" . $overseas->description;
                    }
                }

                if (collect($workExperience)->count() > 0) {
                    foreach ($workExperience as $key => $we) {
                        $detailWork = null;
                        $work .= $we->country . "(" . $we->year_start . " - " . $we->year_end . ")";
                        if (collect($we->detailWork)->count() > 0) {
                            if ($we->country != 'Indonesia') {
                                foreach ($we->detailWork as $kd => $dw) {
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

                                    if ($detailWork != null && $kd == (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= '.';
                                    }

                                    if ($detailWork != null && $kd != (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= ',';
                                    }
                                }
                            }
                        }
                        $work .= "/n" . $detailWork;

                        if (collect($we->detailWork)->count() > 0) {
                            if ($we->country != 'Indonesia') {
                                foreach ($we->detailWork as $kd => $dw) {
                                    if ($dw->question->is_input) {
                                        $detailWork .= $dw->question->question_hk . ' ' . $dw->note;

                                        switch ($dw->question->additional_note) {
                                            case 'baby':
                                                $detailWork .= ' 月';
                                                break;

                                            case 'child':
                                                $detailWork .= ' 年';
                                                break;

                                            case 'ahkong':
                                                $detailWork .= ' 年';
                                                break;

                                            case 'ahma':
                                                $detailWork .= ' 年';
                                                break;

                                            default:
                                                $detailWork .= ' 年';
                                                break;
                                        }
                                    }

                                    if ($dw->question->is_check) {
                                        $detailWork .= $dw->question->question_hk;
                                    }

                                    if ($detailWork != null && $kd == (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= '.';
                                    }

                                    if ($detailWork != null && $kd != (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= ',';
                                    }
                                }
                            }
                        }
                        $work .= "/n" . $detailWork;
                    }
                }
                $sheet->setCellValue("Q$baris", $work);
                $spreadsheet->getActiveSheet()->getStyle("Q$baris")->getAlignment()->setWrapText(true);
                $baris = $baris + (4 * collect($workOverseases)->count());
                $sheet->mergeCells("Q10:AG" . ($baris));
                $spreadsheet->getActiveSheet()->getStyle('Q10:AG' . ($baris))->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
            }

            $baris = $baris + 1;
            $startBaris = $baris + 1;

            $sheet->setCellValue("Q$baris", "國內工作經驗 / Domestic Experience :");
            $sheet->mergeCells("Q$baris:AG$baris");

            $baris = $baris + 1;
            $startBaris = $baris;
            if (collect($workDomestics)->count() == 0) {
                $sheet->mergeCells("Q$startBaris:AG" . ($baris + 4));
                $spreadsheet->getActiveSheet()->getStyle("Q$startBaris:AG" . ($baris + 4))->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $baris += 4;
            } else {
                $work = null;
                foreach ($workDomestics as $key => $domestic) {
                    if ($domestic->description != null) {
                        $work .= $domestic->country . "(" . $domestic->year_start . " - " . $domestic->year_end . ")\n" . $domestic->description;
                    }
                }

                if (collect($workExperience)->count() > 0) {
                    foreach ($workExperience as $key => $we) {
                        $detailWork = null;
                        $work .= $we->country . "(" . $we->year_start . " - " . $we->year_end . ")";
                        if (collect($we->detailWork)->count() > 0) {
                            if ($we->country == 'Indonesia') {
                                foreach ($we->detailWork as $kd => $dw) {
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

                                    if ($detailWork != null && $kd == (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= '.';
                                    }

                                    if ($detailWork != null && $kd != (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= ',';
                                    }
                                }
                            }
                        }
                        $work .= "/n" . $detailWork;

                        if (collect($we->detailWork)->count() > 0) {
                            if ($we->country == 'Indonesia') {
                                foreach ($we->detailWork as $kd => $dw) {
                                    if ($dw->question->is_input) {
                                        $detailWork .= $dw->question->question_hk . ' ' . $dw->note;

                                        switch ($dw->question->additional_note) {
                                            case 'baby':
                                                $detailWork .= ' 月';
                                                break;

                                            case 'child':
                                                $detailWork .= ' 年';
                                                break;

                                            case 'ahkong':
                                                $detailWork .= ' 年';
                                                break;

                                            case 'ahma':
                                                $detailWork .= ' 年';
                                                break;

                                            default:
                                                $detailWork .= ' 年';
                                                break;
                                        }
                                    }

                                    if ($dw->question->is_check) {
                                        $detailWork .= $dw->question->question_hk;
                                    }

                                    if ($detailWork != null && $kd == (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= '.';
                                    }

                                    if ($detailWork != null && $kd != (collect($we->detailWork)->count() - 1)) {
                                        $detailWork .= ',';
                                    }
                                }
                            }
                        }
                        $work .= "/n" . $detailWork;
                    }
                }

                $sheet->setCellValue("Q$baris", $work);
                $spreadsheet->getActiveSheet()->getStyle("Q$baris")->getAlignment()->setWrapText(true);
                $baris = $baris + (4 * collect($workDomestics)->count());
                $sheet->mergeCells("Q$startBaris:AG" . ($baris));
                $spreadsheet->getActiveSheet()->getStyle("Q$startBaris:AG" . ($baris))->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
            }

            $baris = $baris + 2;

            $sheet->setCellValue("Q$baris", "外語能力/ Languages");
            $sheet->mergeCells("Q$baris:AG$baris");

            $spreadsheet->getActiveSheet()->getStyle("Q$baris:AG$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $baris++;

            foreach ($language as $key => $l) {
                if ($l->is_check) {
                    $sheet->setCellValue("Q$baris", $l->question_hk . ' / ' . $l->question);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $lo = null;
                    switch ($l->rate) {
                        case '1':
                            $lo = "差劲 / Poor";
                            break;

                        case '2':
                            $lo = "公平的 / Fair";
                            break;

                        case '3':
                            $lo = "好的 / Good";
                            break;

                        case '4':
                            $lo = "很好 / Very Good";
                            break;

                        case '5':
                            $lo = "出色的 / Excelent";
                            break;
                    }
                    $sheet->setCellValue("AA$baris", $lo);
                    $sheet->mergeCells("AA$baris:AG$baris");
                }

                if ($l->is_input) {
                    $sheet->setCellValue("Q$baris", $l->note);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $lo = null;
                    switch ($l->rate) {
                        case '1':
                            $lo = "差劲 / Poor";
                            break;

                        case '2':
                            $lo = "公平的 / Fair";
                            break;

                        case '3':
                            $lo = "好的 / Good";
                            break;

                        case '4':
                            $lo = "很好 / Very Good";
                            break;

                        case '5':
                            $lo = "出色的 / Excelent";
                            break;
                    }
                    $sheet->setCellValue("AA$baris", $lo);
                    $sheet->mergeCells("AA$baris:AG$baris");
                }
                $baris++;
            }

            $baris = $baris + 1;

            $sheet->setCellValue("Q$baris", "女傭是否同意以下條件 / Willingness");
            $sheet->mergeCells("Q$baris:AG$baris");

            $spreadsheet->getActiveSheet()->getStyle("Q$baris:AG$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $baris = $baris + 1;

            foreach ($willingness as $key => $w) {
                if ($w->is_check) {
                    $sheet->setCellValue("Q$baris", $w->question_hk . ' / ' . $w->question);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $sheet->setCellValue("AA$baris", "是/Yes");
                    $sheet->mergeCells("AA$baris:AB$baris");
                    $sheet->setCellValue("AC$baris", ($w->answer == 1 ? "V" : ""));
                    $spreadsheet->getActiveSheet()->getStyle("AC$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                    $sheet->setCellValue("AE$baris", "不/No");
                    $sheet->mergeCells("AE$baris:AF$baris");
                    $sheet->setCellValue("AG$baris", ($w->answer == 1 ? "" : "V"));
                    $spreadsheet->getActiveSheet()->getStyle("AG$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                }

                if ($w->is_input) {
                    $sheet->setCellValue("Q$baris", $w->note);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $sheet->setCellValue("AA$baris", $w->note);
                    $sheet->mergeCells("AA$baris:AG$baris");
                }

                $baris++;
            }

            $baris = $baris + 1;

            $sheet->setCellValue("Q$baris", "女傭特殊工作經驗 / Speciality");
            $sheet->mergeCells("Q$baris:AG$baris");

            $spreadsheet->getActiveSheet()->getStyle("Q$baris:AG$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $baris = $baris + 1;

            foreach ($skill as $key => $s) {
                if ($s->is_check) {
                    $sheet->setCellValue("Q$baris", $s->question_hk . ' / ' . $s->question);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $sheet->setCellValue("AA$baris", "是/Yes");
                    $sheet->mergeCells("AA$baris:AB$baris");
                    $sheet->setCellValue("AC$baris", ($s->answer == 1 ? "V" : ""));
                    $spreadsheet->getActiveSheet()->getStyle("AC$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                    $sheet->setCellValue("AE$baris", "不/No");
                    $sheet->mergeCells("AE$baris:AF$baris");
                    $sheet->setCellValue("AG$baris", ($s->answer == 1 ? "" : "V"));
                    $spreadsheet->getActiveSheet()->getStyle("AG$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                }

                if ($s->is_input) {
                    $sheet->setCellValue("Q$baris", $s->note);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $sheet->setCellValue("AA$baris", $s->note);
                    $sheet->mergeCells("AA$baris:AG$baris");
                }

                $baris++;
            }

            $baris = $baris + 1;

            $sheet->setCellValue("Q$baris", "其他 / Other");
            $sheet->mergeCells("Q$baris:AG$baris");

            $spreadsheet->getActiveSheet()->getStyle("Q$baris:AG$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $baris = $baris + 1;

            foreach ($other as $key => $o) {
                if ($o->is_check) {
                    $sheet->setCellValue("Q$baris", $o->question_hk . ' / ' . $o->question);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $sheet->setCellValue("AA$baris", "是/Yes");
                    $sheet->mergeCells("AA$baris:AB$baris");
                    $sheet->setCellValue("AC$baris", ($o->answer == 1 ? "V" : ""));
                    $spreadsheet->getActiveSheet()->getStyle("AC$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                    $sheet->setCellValue("AE$baris", "不/No");
                    $sheet->mergeCells("AE$baris:AF$baris");
                    $sheet->setCellValue("AG$baris", ($o->answer == 1 ? "" : "V"));
                    $spreadsheet->getActiveSheet()->getStyle("AG$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                }

                if ($o->is_input) {
                    $sheet->setCellValue("Q$baris", $o->note);
                    $sheet->mergeCells("Q$baris:Y$baris");
                    $sheet->setCellValue("Z$baris", ":");
                    $sheet->setCellValue("AA$baris", $o->note);
                    $sheet->mergeCells("AA$baris:AG$baris");
                }

                $baris++;
            }

            $baris = $baris + 1;

            $sheet->setCellValue("Q$baris", "其他 / Remarks");
            $sheet->mergeCells("Q$baris:AG$baris");

            $spreadsheet->getActiveSheet()->getStyle("Q$baris:AG$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);

            $baris = $baris + 1;

            $remarks = null;

            if ($dataMaid->address) {
                $remarks .= "Address : " . $dataMaid->address . "\n";
            }

            if ($dataMaid->contact) {
                $remarks .= "Contact : " . $dataMaid->contact . "\n";
            }

            if ($dataMaid->note) {
                $remarks .= "Note : " . $dataMaid->note . "\n";
            }

            $sheet->setCellValue("Q$baris", $remarks);
            $sheet->mergeCells("Q$baris:AG" . ($baris + 4));

            $spreadsheet->getActiveSheet()->getStyle("Q$baris:AG" . ($baris + 4))->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]);
            $spreadsheet->getActiveSheet()->getStyle("Q$baris")->getAlignment()->setWrapText(true);

            $baris = $baris + 7;

            $sheet->setCellValue("A$baris", "Foreign Domestic Worker Declaration (外籍家庭傭工聲明 )");
            $sheet->mergeCells("A$baris:AG$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris")->getAlignment()->setWrapText(true);

            $baris = $baris + 2;

            $sheet->setCellValue("A$baris", "I hereby declare that all information given above are true, correct, and complete. The Agency Shall Not Liable If It Is Subsequently Established That The FDW Had Lied About Herself In
            The FDW's Biodata.");
            $sheet->mergeCells("A$baris:AG$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris")->getAlignment()->setWrapText(true);

            $baris = $baris + 2;

            $sheet->setCellValue("A$baris", ".......................................");
            $sheet->mergeCells("A$baris:AG$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris")->getAlignment()->setWrapText(true);

            $baris = $baris + 2;

            $sheet->setCellValue("A$baris", "Foreign Domestic Worker's Signature (外籍家庭傭工簽署 )");
            $sheet->mergeCells("A$baris:AG$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris")->getAlignment()->setWrapText(true);

            $baris = $baris + 2;
            $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.25);
            $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.25);
            $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.25);
            $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.25);
            $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
            $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(1);
        }

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $dataMaid->full_name . ' - ' . $dataMaid->code_maid . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
