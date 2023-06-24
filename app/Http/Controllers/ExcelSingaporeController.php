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
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFit;

class ExcelSingaporeController extends Controller
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(0);
        $spreadsheet->getActiveSheet()->setTitle("$dataMaid->full_name - $dataMaid->code_maid");
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri Light');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        $columns = excelColumn("A", "ZZ");

        foreach ($columns as $key => $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setWidth(3);
            if ($column == 'S') {
                $spreadsheet->getActiveSheet()->getColumnDimension($column)->setWidth(1);
            }
        }

        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Header');
        $drawing->setDescription('Header');
        $drawing->setPath(public_path('assets/image/header/header.png'));
        $drawing->setHeight(125);

        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $sheet->setCellValue("A9", "BIO-DATA OF FOREIGN DOMESTIC WORKER (FDW)");
        $sheet->mergeCells("A9:AK9");

        $spreadsheet->getActiveSheet()->getStyle('A9:AK9')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  14
            ],
        ]);

        $sheet->setCellValue("A11", "*Please ensure that you run through the information within the biodata as it is an important document to help you select a suitable FDW");
        $sheet->mergeCells("A11:AK11");

        $spreadsheet->getActiveSheet()->getStyle('A11:O11')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $spreadsheet->getActiveSheet()->getStyle("A11")->getAlignment()->setWrapText(true);

        $sheet->setCellValue("A13", "(A) PROFILE OF FWD");
        $sheet->mergeCells("A13:AK13");

        $spreadsheet->getActiveSheet()->getStyle('A13:AK13')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12,
                'underline' =>  true,
            ],
        ]);

        $sheet->setCellValue("A15", "A1 Personal Information");
        $sheet->mergeCells("A15:R15");

        $spreadsheet->getActiveSheet()->getStyle('A15:R15')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12
            ],
        ]);

        $sheet->setCellValue("A16", "1. Code : " . $dataMaid->code_maid);
        $sheet->mergeCells("A16:R16");

        $sheet->setCellValue("A17", "2. Name : " . $dataMaid->full_name);
        $sheet->mergeCells("A17:R17");

        $sheet->setCellValue("A18", "3. Date of birth : " . Carbon::parse($dataMaid->date_of_birth)->isoFormat("DD MMMM YYYY"));
        $sheet->mergeCells("A18:K18");

        $sheet->setCellValue("M18", "Age : " . Carbon::parse($dataMaid->date_of_birth)->age);
        $sheet->mergeCells("M18:R18");

        $sheet->setCellValue("A19", "4. Place of birth : " . $dataMaid->place_of_birth);
        $sheet->mergeCells("A19:R19");

        $sheet->setCellValue("A20", "5. Height & Weight : " . $dataMaid->height . " cm   " . $dataMaid->weight . " kg");
        $sheet->mergeCells("A20:R20");

        $sheet->setCellValue("A21", "6. Nationality : " . $dataMaid->nationality);
        $sheet->mergeCells("A21:R21");

        $sheet->setCellValue("A22", "7. Residential address in home country : " . $dataMaid->address);
        $sheet->mergeCells("A22:R22");
        $spreadsheet->getActiveSheet()->getStyle('A22:R22')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ]);
        $spreadsheet->getActiveSheet()->getRowDimension(22)->setRowHeight(36);
        $spreadsheet->getActiveSheet()->getStyle("A22")->getAlignment()->setWrapText(true);

        $sheet->setCellValue("A23", "8. Name of port / airport to be repatriated to : " . $dataMaid->port_airport_name);
        $sheet->mergeCells("A23:R23");
        $spreadsheet->getActiveSheet()->getStyle('A23:R23')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ]);
        $spreadsheet->getActiveSheet()->getRowDimension(23)->setRowHeight(36);
        $spreadsheet->getActiveSheet()->getStyle("A23")->getAlignment()->setWrapText(true);

        $sheet->setCellValue("A24", "9. Contact number in home country : " . $dataMaid->contact);
        $sheet->mergeCells("A24:R24");
        $spreadsheet->getActiveSheet()->getStyle('A24:R24')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ]);
        $spreadsheet->getActiveSheet()->getRowDimension(24)->setRowHeight(36);
        $spreadsheet->getActiveSheet()->getStyle("A24")->getAlignment()->setWrapText(true);

        $sheet->setCellValue("A25", "10. Religion : " . convertReligion($dataMaid->religion));
        $sheet->mergeCells("A25:R25");

        $sheet->setCellValue("A26", "11. Education Level : " . convertEducation($dataMaid->education));
        $sheet->mergeCells("A26:R26");

        $sheet->setCellValue("A27", "12. Number of siblings : " . $dataMaid->number_of_siblings);
        $sheet->mergeCells("A27:R27");

        $sheet->setCellValue("A28", "13. Marital status : " . convertMaritalStatus($dataMaid->marital));
        $sheet->mergeCells("A28:R28");

        $sheet->setCellValue("A29", "14. Number of children : " . $dataMaid->number_of_children);
        $sheet->mergeCells("A29:R29");

        $sheet->setCellValue("A30", "-. Age(s) of children (if any) : " . $dataMaid->children_ages);
        $sheet->mergeCells("A30:R30");

        $spreadsheet->getActiveSheet()->getStyle('A16:R30')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ]);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Photo');
        $drawing->setDescription('Photo');
        $drawing->setPath(public_path('assets/image/maids/photos/' . $dataMaid->picture_name));
        $drawing->setCoordinates('T15');
        $drawing->setHeight(400);

        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $sheet->setCellValue("A32", "A2 Medical History/Dietary Restrictions");
        $sheet->mergeCells("A32:AK32");

        $spreadsheet->getActiveSheet()->getStyle('A32:AK32')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12
            ],
        ]);

        $baris = 34;
        $startBaris = 34;

        $no = 1;
        foreach ($medical as $key => $value) {
            $medicalChilds = Question::medicalMaid($dataMaid->id)
                ->where('is_active', true)
                ->where('is_child', true)
                ->where('parent_id', $value->id)
                ->country($request->country)
                ->orderBy('id')
                ->get();

            if ($value->is_input) {
                $sheet->setCellValue("A$baris", ($value->question . " : " . ($value->note ? $value->note : 'N/A')));
            } elseif ($value->is_check) {
                $sheet->setCellValue("B$baris", (integerToRoman($no) . ". " . $value->question));
                $sheet->setCellValue("C" . ($baris + 1), ($value->answer == 1 ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("C" . ($baris + 1))->applyFromArray([
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
                $sheet->setCellValue("E" . ($baris + 1), ("Yes"));
                $sheet->setCellValue("G" . ($baris + 1), ($value->answer == 1 ? "" : "V"));
                $spreadsheet->getActiveSheet()->getStyle("G" . ($baris + 1))->applyFromArray([
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
                $sheet->setCellValue("I" . ($baris + 1), ("No"));
                $baris++;
                $no++;
            } else {
                $sheet->setCellValue("A" . ($baris), $value->question);
            }

            foreach ($medicalChilds as $key => $mc) {
                if ($mc->is_check) {
                    $sheet->setCellValue("B" . ($baris + 1), ($mc->answer == 1 ? "V" : ""));
                    $sheet->setCellValue("C" . ($baris + 1), ($mc->question));
                    $spreadsheet->getActiveSheet()->getStyle("B" . ($baris + 1))->applyFromArray([
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
                if ($mc->is_input) {
                    $sheet->setCellValue("B" . ($baris + 1), ($mc->question . " : " . ($mc->note ? $mc->note : 'N/A')));
                }
                $baris++;
            }

            $baris++;
        }

        $baris += 2;

        $sheet->setCellValue("A$baris", "A3 Other");
        $sheet->mergeCells("A$baris:AK$baris");

        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        foreach ($other as $key => $value) {
            $sheet->setCellValue("B$baris", $value->question . " : " . ($value->note ? $value->note : 'N/A'));
            $sheet->mergeCells("B$baris:AJ$baris");
            $baris++;
        }

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "(B) SKILLS OF FDW");
        $sheet->mergeCells("A$baris:AK$baris");

        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  14,
                'underline' =>  true
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "B1 Method of Evaluation Skills");
        $sheet->mergeCells("A$baris:AK$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12,
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        foreach ($method as $key => $value) {
            $methodChilds = Question::methodMaid($dataMaid->id)
                ->where('is_active', true)
                ->country(request('country'))
                ->where('is_child', true)
                ->where('parent_id', $value->id)
                ->orderBy('id')
                ->get();

            $sheet->setCellValue("B$baris", ($value->answer == 1 ? "V" : ""));
            $sheet->setCellValue("D" . ($baris), ($value->question));
            $spreadsheet->getActiveSheet()->getStyle("B" . ($baris))->applyFromArray([
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

            foreach ($methodChilds as $key => $mc) {
                $sheet->setCellValue("D" . ($baris), ($mc->answer == 1 ? "V" : ""));
                $sheet->setCellValue("F" . ($baris), ($mc->question));
                $spreadsheet->getActiveSheet()->getStyle("D" . ($baris))->applyFromArray([
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
            }
        }

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "S/No");
        $sheet->mergeCells("A$baris:C" . ($baris + 6));
        $sheet->setCellValue("D$baris", "Areas of Work");
        $sheet->mergeCells("D$baris:J" . ($baris + 6));
        $sheet->setCellValue("K$baris", "Willingness\nYes/No");
        $sheet->mergeCells("K$baris:Q" . ($baris + 6));
        $sheet->setCellValue("R$baris", "Experience\nYes/No\If yes, state the\nno. of years");
        $sheet->mergeCells("R$baris:Y" . ($baris + 6));
        $sheet->setCellValue("Z$baris", "Assessment/Observation\nPlease state qualitative observations of FDW and/or rate\nthe FDW (indicate N.A. Of no evaluation was done)\nPoor..................Excellent...N.A\n1 2 3 4 5 N.A");
        $sheet->mergeCells("Z$baris:AK" . ($baris + 6));
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 6))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 6))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font'  =>  [
                'bold'  =>  true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9',
                ],
            ],
        ]);

        $baris += 7;
        $startBaris = $baris;

        foreach ($skill as $key => $value) {
            $sheet->setCellValue("A$baris", ($key + 1));
            $sheet->mergeCells("A$baris:C" . ($baris));
            if ($value->id == 38) {
                $sheet->setCellValue("D$baris", $value->question . "\nPlease specify age range:\n" . ($value->note ? $value->note : "N/A"));
                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(50);
            }

            if ($value->id == 42) {
                $sheet->setCellValue("D$baris", $value->question . "\nPlease specify cuisines:\n" . ($value->note ? $value->note : "N/A"));
                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(50);
            }

            if ($value->id == 43) {
                $sheet->setCellValue("D$baris", $value->question . "\nPlease specify:\n" . ($value->note ? $value->note : "N/A"));
                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(50);
            }

            if ($value->id == 44) {
                $sheet->setCellValue("D$baris", $value->question . "\nPlease specify:\n" . ($value->note ? $value->note : "N/A"));
                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(50);
            }

            if ($value->id != 38 && $value->id != 42 && $value->id != 43 && $value->id != 44) {
                $sheet->setCellValue("D$baris", $value->question);
            }
            $sheet->mergeCells("D$baris:J" . ($baris));

            $sheet->setCellValue("K$baris", ($value->willingness == 1 ? "YES" : "NO"));
            $sheet->mergeCells("K$baris:Q" . ($baris));

            $sheet->setCellValue("R$baris", ($value->experience == 1 ? $value->note_experience : ""));
            $sheet->mergeCells("R$baris:Y" . ($baris));

            $sheet->setCellValue("Z$baris", "Rate : " . ($value->rate == 1 ? $value->rate : "0") . "\n" . $value->note_observetion);
            $sheet->mergeCells("Z$baris:AK" . ($baris));
            $baris++;
        }

        $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AK" . ($baris - 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AK" . ($baris - 1))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "(C) EMPLOYMENT HISTORY OF FDW");
        $sheet->mergeCells("A$baris:AK$baris");

        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  14,
                'underline' =>  true
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "C1 Employment History Overseas");
        $sheet->mergeCells("A$baris:AK$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12,
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "Date");
        $sheet->mergeCells("A$baris:D" . ($baris));
        $sheet->setCellValue("A" . ($baris + 1), "From");
        $sheet->mergeCells("A" . ($baris + 1) . ":B" . ($baris + 1));
        $sheet->setCellValue("C" . ($baris + 1), "To");
        $sheet->mergeCells("C" . ($baris + 1) . ":D" . ($baris + 1));
        $sheet->setCellValue("E$baris", "Country (including FDW's home country)");
        $sheet->mergeCells("E$baris:L" . ($baris + 1));
        $sheet->setCellValue("M$baris", "Employer");
        $sheet->mergeCells("M$baris:T" . ($baris + 1));
        $sheet->setCellValue("U$baris", "Work Duties");
        $sheet->mergeCells("U$baris:AC" . ($baris + 1));
        $sheet->setCellValue("AD$baris", "Remarks");
        $sheet->mergeCells("AD$baris:AK" . ($baris + 1));
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font'  =>  [
                'bold'  =>  true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9',
                ],
            ],
        ]);

        $baris += 2;
        $startBaris = $baris;

        if (collect($dataMaid->workExperience)->count() > 0) {
            foreach ($dataMaid->workExperience as $key => $value) {
                $sheet->setCellValue("A$baris", $value->year_start);
                $sheet->mergeCells("A$baris:B$baris");
                $sheet->setCellValue("C$baris", $value->year_end);
                $sheet->mergeCells("C$baris:D$baris");
                $sheet->setCellValue("E$baris", $value->country);
                $sheet->mergeCells("E$baris:L$baris");
                $sheet->setCellValue("M$baris", $value->employeer_singapore);
                $sheet->mergeCells("M$baris:T$baris");
                $sheet->setCellValue("U$baris", $value->description);
                $sheet->mergeCells("U$baris:AC$baris");
                $sheet->setCellValue("AD$baris", $value->remarks);
                $sheet->mergeCells("AD$baris:AK$baris");

                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(50);
                $baris++;
            }
        } else {
            $sheet->mergeCells("A$baris:B$baris");
            $sheet->mergeCells("C$baris:D$baris");
            $sheet->mergeCells("E$baris:L$baris");
            $sheet->mergeCells("M$baris:T$baris");
            $sheet->mergeCells("U$baris:AC$baris");
            $sheet->mergeCells("AD$baris:AK$baris");
            $baris++;
        }

        $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AK" . ($baris - 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AK" . ($baris - 1))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $baris += 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "C2 Employment History in Singapore");
        $sheet->mergeCells("A$baris:AK$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12,
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "Previous working experience in Singapore");
        $sheet->mergeCells("A$baris:R$baris");
        $sheet->setCellValue("T$baris", ($dataMaid->work_singapore == 1 ? "V" : ""));
        $spreadsheet->getActiveSheet()->getStyle("T$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        $sheet->setCellValue("V$baris", "Yes");
        $sheet->mergeCells("V$baris:W$baris");

        $sheet->setCellValue("Y$baris", ($dataMaid->work_singapore == 0 ? "V" : ""));
        $spreadsheet->getActiveSheet()->getStyle("Y$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        $sheet->setCellValue("AA$baris", "No");
        $sheet->mergeCells("AA$baris:AB$baris");

        $baris += 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "(The EA is required to obtain the FDW’s employment history from MOM and furnish the employer with the employment history of the FDW. The employer may also verify the FDW’s employment history in Singapore through WPOL using SingPass)");
        $sheet->mergeCells("A$baris:AK" . ($baris + 1));
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ]);

        $baris += 3;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "C2 Feedback from previous employers in Singapore");
        $sheet->mergeCells("A$baris:AK$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12,
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "Feedback was/was not obtained by the EA from the previous employers. If feedback was obtained (attach testimonial if possible), please indicate the feedback in the table below:");
        $sheet->mergeCells("A$baris:AK" . ($baris + 1));
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "Date");
        $sheet->mergeCells("A$baris:S" . ($baris));
        $sheet->setCellValue("T" . ($baris), "Country (including FDW's home country)");
        $sheet->mergeCells("T" . ($baris) . ":AK" . ($baris));
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font'  =>  [
                'bold'  =>  true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9',
                ],
            ],
        ]);

        $baris += 1;
        $startBaris = $baris;

        if (collect($dataMaid->workExperience)->count() > 0) {
            foreach ($dataMaid->workExperience as $key => $value) {
                $sheet->setCellValue("A$baris", "Employeer " . ($key + 1) . " " . $value->employeer_singapore);
                $sheet->mergeCells("A$baris:S$baris");
                $sheet->setCellValue("T$baris", $value->employeer_singapore_feedback);
                $sheet->mergeCells("T$baris:AK$baris");

                $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(40);
                $baris++;
            }
        } else {
            $sheet->mergeCells("A$baris:S$baris");
            $sheet->mergeCells("T$baris:AK$baris");
            $baris++;
        }

        $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AK" . ($baris - 1))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AK" . ($baris - 1))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $baris += 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "(D) AVAILABILITY OF FDW TO BE INTERVIEWED BY PROSPECTIVE EMPLOYER");
        $sheet->mergeCells("A$baris:AK$baris");

        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  14,
                'underline' =>  true
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        foreach ($interview as $key => $value) {
            $sheet->setCellValue("B$baris", ($value->answer == 1 ? "V" : ""));
            $sheet->setCellValue("D" . ($baris), ($value->question));
            $spreadsheet->getActiveSheet()->getStyle("B" . ($baris))->applyFromArray([
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
        }

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "(E) OTHER REMARKS");
        $sheet->mergeCells("A$baris:AK$baris");

        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  14,
                'underline' =>  true
            ],
        ]);

        $baris = $baris + 2;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", $dataMaid->note);
        $sheet->mergeCells("A$baris:AK" . ($baris + 4));
        $spreadsheet->getActiveSheet()->getStyle("A" . ($baris) . ":AK" . ($baris + 4))->applyFromArray([
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

        $baris = $baris + 10;
        $startBaris = $baris;

        $sheet->mergeCells("A$baris:O$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:O$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $sheet->mergeCells("V$baris:AG$baris");
        $spreadsheet->getActiveSheet()->getStyle("V$baris:AG$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "FDW Name and Signature");
        $sheet->mergeCells("A$baris:O$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:O$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->setCellValue("V$baris", "EA Personnel Name and Registration Number");
        $sheet->mergeCells("V$baris:AG$baris");
        $spreadsheet->getActiveSheet()->getStyle("V$baris:AG$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "Date :");
        $sheet->mergeCells("A$baris:O$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:O$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->setCellValue("V$baris", "Date :");
        $sheet->mergeCells("V$baris:AG$baris");
        $spreadsheet->getActiveSheet()->getStyle("V$baris:AG$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $baris = $baris + 3;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "I have gone through the 4 page biodata of this FDW and confirm that I would like to employ her");
        $sheet->mergeCells("A$baris:AK$baris");

        $baris = $baris + 10;
        $startBaris = $baris;

        $sheet->mergeCells("A$baris:O$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:O$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "Employer Name and NRIC No.");
        $sheet->mergeCells("A$baris:O$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:O$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "Date :");
        $sheet->mergeCells("A$baris:O$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:O$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $baris = $baris + 3;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "***************");
        $sheet->mergeCells("A$baris:AK$baris");
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $baris = $baris + 3;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "IMPORTANT NOTES FOR EMPLOYERS WHEN USING THE SERVICES OF AN EA");
        $sheet->mergeCells("A$baris:AK$baris");

        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK$baris")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
                'size'  =>  12,
            ],
        ]);

        $baris = $baris + 1;
        $startBaris = $baris;

        $sheet->setCellValue("A$baris", "1. Do consider asking for an FDW who is able to communicate in a language you require, and interview her (in person/phone/videoconference) to ensure that she can communicate adequately.");
        $sheet->mergeCells("A$baris:AK$baris");
        $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(30);

        $sheet->setCellValue("A" . ($baris + 1), "2. Do consider requesting for an FDW who has a proven ability to perform the chores you require, for example, performing household chores (especially if she is required to hang laundry from a high-rise unit), cooking and caring for young children or the elderly.");
        $sheet->mergeCells("A" . ($baris + 1) . ":AK" . ($baris + 1));
        $spreadsheet->getActiveSheet()->getRowDimension($baris + 1)->setRowHeight(30);

        $sheet->setCellValue("A" . ($baris + 2), "3. Do work together with the EA to ensure that a suitable FDW is matched to you according to your needs and requirements.");
        $sheet->mergeCells("A" . ($baris + 2) . ":AK" . ($baris + 2));
        $spreadsheet->getActiveSheet()->getRowDimension($baris + 2)->setRowHeight(30);

        $sheet->setCellValue("A" . ($baris + 3), "4. You may wish to pay special attention to your prospective FDW’s employment history and feedback from the FDW’s previous employer(s) before employing her.");
        $sheet->mergeCells("A" . ($baris + 3) . ":AK" . ($baris + 3));
        $spreadsheet->getActiveSheet()->getRowDimension($baris + 3)->setRowHeight(30);

        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 3))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A$baris:AK" . ($baris + 3))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.25);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

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
