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

class ExcelFormalController extends Controller
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
        }

        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Header');
        $drawing->setDescription('Header');
        $drawing->setPath(public_path('assets/image/header/header.png'));
        $drawing->setHeight(110);

        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        if (Str::startsWith($dataMaid->code_maid, 'M')) {
            $sheet->setCellValue("A7", "PERSONAL BIODATA");
            $sheet->mergeCells("A7:AF7");
            $spreadsheet->getActiveSheet()->getStyle('A7:AF7')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                    'color' => array('argb' => 'FF8D3F3F')
                ]
            ]);

            $sheet->setCellValue("A8", "B I O D A T A");
            $sheet->mergeCells("A8:AF8");
            $spreadsheet->getActiveSheet()->getStyle('A8:AF8')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                    'color' => array('argb' => 'FF16365C'),
                ],
                'fill'  =>  [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb'  =>  'FF8DB5E2'
                    ]
                ],
                'borders'   => [
                    'top'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ],
            ]);

            $sheet->setCellValue("A10", "Application number");
            $sheet->mergeCells("A10:M10");
            $sheet->setCellValue("N10", ":");
            $sheet->setCellValue("O10", $dataMaid->code_maid);
            $sheet->mergeCells("O10:AF10");
            $spreadsheet->getActiveSheet()->getStyle("O10:AF10")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("A11", "Name");
            $sheet->mergeCells("A11:M11");
            $sheet->setCellValue("N11", ":");
            $sheet->setCellValue("O11", $dataMaid->full_name);
            $sheet->mergeCells("O11:AF11");
            $spreadsheet->getActiveSheet()->getStyle("O11:AF11")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("A12", "Place, date of birth");
            $sheet->mergeCells("A12:M12");
            $sheet->setCellValue("N12", ":");
            $sheet->setCellValue("O12", $dataMaid->place_of_birth . ", " . Carbon::parse($dataMaid->date_of_birth)->isoFormat("DD MMMM YYYY"));
            $sheet->mergeCells("O12:AF12");
            $spreadsheet->getActiveSheet()->getStyle("O12:AF12")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("A13", "Height");
            $sheet->mergeCells("A13:M13");
            $sheet->setCellValue("N13", ":");
            $sheet->setCellValue("O13", $dataMaid->height . " cm");
            $sheet->mergeCells("O13:Q13");
            $spreadsheet->getActiveSheet()->getStyle("O13:Q13")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("R13", "Weight");
            $sheet->mergeCells("R13:U13");
            $sheet->setCellValue("V13", $dataMaid->weight . " kg");
            $sheet->mergeCells("V13:X13");
            $spreadsheet->getActiveSheet()->getStyle("V13:X13")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("Y13", "Weight");
            $sheet->mergeCells("Y13:AB13");
            $sheet->setCellValue("AC13", convertReligion($dataMaid->religion));
            $sheet->mergeCells("AC13:AE13");
            $spreadsheet->getActiveSheet()->getStyle("AC13:AE13")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("A14", "Address");
            $sheet->mergeCells("A14:M14");
            $sheet->setCellValue("N14", ":");
            $sheet->setCellValue("O14", $dataMaid->address);
            $sheet->mergeCells("O14:AF14");
            $spreadsheet->getActiveSheet()->getStyle("O14:AF14")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("A15", "Brother & Sister");
            $sheet->mergeCells("A15:M15");
            $sheet->setCellValue("N15", ":");
            $sheet->setCellValue("O15", $dataMaid->number_of_siblings);
            $sheet->mergeCells("O15:Q15");
            $spreadsheet->getActiveSheet()->getStyle("O15:Q15")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("R15", "I'm number");
            $sheet->mergeCells("R15:U15");
            $sheet->setCellValue("V15", $dataMaid->number_in_family);
            $sheet->mergeCells("V15:X15");
            $spreadsheet->getActiveSheet()->getStyle("V15:X15")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("Y15", "Telp");
            $sheet->mergeCells("Y15:AB15");
            $sheet->setCellValue("AC15", "'" . $dataMaid->contact);
            $sheet->mergeCells("AC15:AE15");
            $spreadsheet->getActiveSheet()->getStyle("AC15:AE15")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $sheet->setCellValue("A16", "Marital status");
            $sheet->mergeCells("A16:M16");
            $marital = [
                1 => 'Single',
                2 => 'Married',
                3 => 'Divorced',
                4 => 'Widowed',
            ];
            $column = 14;
            $baris = 16;
            $startBaris = $baris;
            foreach ($marital as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($key == $dataMaid->marital ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   => [
                        'allBorders'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ],
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value);
                $sheet->mergeCells($columExcel . $baris . ":" . (columnLetter($column + 3)) . $baris);
                $column += 4;
            }

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Heir name");
            $sheet->mergeCells("A$baris:M$baris");
            $sheet->setCellValue("N$baris", ":");
            $sheet->setCellValue("O$baris", $dataMaid->hobby);
            $sheet->mergeCells("O$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("O$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $baris++;
            $startBaris = $baris;

            $sheet->setCellValue("A$baris", "Number and ages of children");
            $sheet->mergeCells("A$baris:M$baris");
            $sheet->setCellValue("N$baris", ":");
            $sheet->setCellValue("O$baris", $dataMaid->number_of_children . ", " . $dataMaid->children_ages);
            $sheet->mergeCells("O$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("O$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'color' => array('argb' => 'FF007AC0'),
                ],
                'borders'   => [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' =>  array('argb' => 'FF000000'),
                    ]
                ],
            ]);

            $education = [
                1 => 'Kindergarten',
                2 => 'Primary School',
                3 => 'Junior High School',
                4 => 'Senior High School',
                5 => 'Bachelor',
                6 => 'Master',
                7 => 'Doctor',
            ];
            $column = 14;
            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Education");
            foreach ($education as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($key == $dataMaid->education ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   => [
                        'allBorders'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ],
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value);
                $sheet->mergeCells($columExcel . $baris . ":" . (columnLetter($column + 4)) . $baris);
                $column += 5;
                if ($column > 27) {
                    $baris++;
                    $column = 14;
                }
            }
            $sheet->mergeCells("A$startBaris:M$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$startBaris:M$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $column = 14;
            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Language");
            foreach ($language as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($value->answer == 1 ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   => [
                        'allBorders'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ],
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value->question);
                $sheet->mergeCells($columExcel . $baris . ":" . (columnLetter($column + 4)) . $baris);
                $column += 5;
                if ($column > 27) {
                    $baris++;
                    $column = 14;
                }
            }
            $sheet->mergeCells("A$startBaris:M$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$startBaris:M$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $column = 14;
            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Cooking ability");
            foreach ($skill as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($value->answer == 1 ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   => [
                        'allBorders'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ],
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value->question);
                $sheet->mergeCells($columExcel . $baris . ":" . (columnLetter($column + 4)) . $baris);
                $column += 5;
                if ($column > 27) {
                    $baris++;
                    $column = 14;
                }
            }
            $sheet->mergeCells("A$startBaris:M$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$startBaris:M$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $baris++;
            $startBaris = $baris;
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(3);
            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "I CAN SERVE YOU BETTER");
            $sheet->mergeCells("A$baris:M$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris:M$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  12,
                    'bold'  =>  true,
                    'color' => array('argb' => 'FF000000'),
                ],
                'fill'  =>  [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb'  =>  'FFA6A6A6'
                    ]
                ],
                'borders'   => [
                    'top'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ],
            ]);

            $sheet->setCellValue("O$baris", "WORK CHOSEN");
            $sheet->mergeCells("O$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("O$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                    'color' => array('argb' => 'FF000000'),
                ],
                'fill'  =>  [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb'  =>  'FF8DB5E2'
                    ]
                ],
                'borders'   => [
                    'top'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ],
            ]);

            $baris++;
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(3);

            $baris++;
            $startBaris = $baris;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Photo');
            $drawing->setDescription('Photo');
            $drawing->setPath(public_path('assets/image/maids/photos/' . $dataMaid->picture_name));
            $drawing->setCoordinates("A$baris");
            $drawing->setHeight(360);

            $drawing->setWorksheet($spreadsheet->getActiveSheet());

            $column = 15;
            $sheet->setCellValue("O$baris", "Cooking ability");
            foreach ($willingness as $key => $value) {
                $columExcel = columnLetter($column);
                if ($value->is_check) {
                    $sheet->setCellValue("$columExcel$baris", ($value->answer == 1 ? "V" : ""));
                    $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders'   => [
                            'allBorders'   =>  [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ]
                        ],
                    ]);
                }

                if ($value->is_input) {
                    $sheet->setCellValue("$columExcel$baris", $value->question);
                    $sheet->mergeCells(columnLetter($column) . $baris . ":" . columnLetter($column + 3) . $baris);
                    $column += 3;
                }
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($value->is_check ? $value->question : ($value->note ? $value->note : ".......................")));
                $sheet->mergeCells($columExcel . $baris . ":" . (columnLetter($column + 4)) . $baris);
                $column += 5;
                if ($column > 30) {
                    $baris++;
                    $column = 15;
                }
            }

            $baris++;
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(3);

            $baris++;
            $startBaris = $baris;

            $sheet->setCellValue("O$baris", "INTERVIEW APPRAISAL");
            $sheet->mergeCells("O$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("O$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                    'color' => array('argb' => 'FF000000'),
                ],
                'fill'  =>  [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb'  =>  'FF8DB5E2'
                    ]
                ],
                'borders'   => [
                    'top'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ],
            ]);

            $baris++;
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(3);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("V$baris", "Fair");
            $sheet->mergeCells("V$baris:X$baris");
            $spreadsheet->getActiveSheet()->getStyle("V$baris:X$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("Y$baris", "Good");
            $sheet->mergeCells("Y$baris:AA$baris");
            $spreadsheet->getActiveSheet()->getStyle("Y$baris:AA$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("AB$baris", "Excelent");
            $sheet->mergeCells("AB$baris:AD$baris");
            $spreadsheet->getActiveSheet()->getStyle("AB$baris:AD$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $column = 15;
            $baris++;
            $startBaris = $baris;

            foreach ($interview as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value->question);
                $sheet->mergeCells(columnLetter($column) . $baris . ":" . columnLetter($column + 6) . $baris);
                $column += 7;
                for ($i = 1; $i <= 7; $i++) {
                    $columExcel = columnLetter($column);
                    if ($value->rate == $i) {
                        $sheet->setCellValue("$columExcel$baris", "V");
                    }
                    $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ]
                        ]
                    ]);
                    $column++;
                }
                $baris++;
                $column = 15;
            }

            $baris++;
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(3);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("O$baris", "REMARKS");
            $sheet->mergeCells("O$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("O$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                    'color' => array('argb' => 'FF000000'),
                ],
                'fill'  =>  [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb'  =>  'FF8DB5E2'
                    ]
                ],
                'borders'   => [
                    'top'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ],
            ]);

            $baris++;
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(3);

            $baris++;
            $startBaris = $baris;

            $work = "";
            foreach ($dataMaid->workExperience as $key => $value) {
                $work .= $value->country . " (" . $value->year_start . " - " . $value->year_end . ")\n" . $value->description . "\n";
            }
            $work .= $dataMaid->note;
            $sheet->setCellValue("O$baris", $work);
            $sheet->mergeCells("O$baris:AF" . ($baris + 6));

            $spreadsheet->getActiveSheet()->getStyle("O$baris")->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle("O$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);
        }

        if (Str::start($dataMaid->code_maid, "B")) {
            $marital = [
                1 => 'Single',
                2 => 'Married',
                3 => 'Divorced',
                4 => 'Widowed',
            ];

            $education = [
                1 => 'Kindergarten',
                2 => 'Primary School',
                3 => 'Junior High School',
                4 => 'Senior High School',
                5 => 'Bachelor',
                6 => 'Master',
                7 => 'Doctor',
            ];

            $sheet->setCellValue("A7", "APPLICATION'S INFORMATION");
            $sheet->mergeCells("A7:AF7");
            $spreadsheet->getActiveSheet()->getStyle('A7:AF7')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                ],
                'borders'   =>  [
                    'outline'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ]
            ]);

            $spreadsheet->getActiveSheet()->getRowDimension(8)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle('A8:AF8')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ]
            ]);

            $sheet->setCellValue("B9", "Name");
            $sheet->mergeCells("B9:G9");
            $sheet->setCellValue("H9", ":");
            $sheet->setCellValue("I9", $dataMaid->full_name);
            $sheet->mergeCells("I9:W9");
            $spreadsheet->getActiveSheet()->getStyle("I9:W9")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("B10", "Address");
            $sheet->mergeCells("B10:G10");
            $sheet->setCellValue("H10", ":");
            $sheet->setCellValue("I10", $dataMaid->address);
            $sheet->mergeCells("I10:W10");
            $spreadsheet->getActiveSheet()->getStyle("I10:W10")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);
            $sheet->setCellValue("Y10", "CODE");
            $sheet->mergeCells("Y10:AE10");
            $spreadsheet->getActiveSheet()->getStyle("Y10:AE10")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'outline'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("B11", "Contact");
            $sheet->mergeCells("B11:G11");
            $sheet->setCellValue("H11", ":");
            $sheet->setCellValue("I11", $dataMaid->contact);
            $sheet->mergeCells("I11:W11");
            $spreadsheet->getActiveSheet()->getStyle("I11:W11")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);
            $sheet->setCellValue("Y11", $dataMaid->code_maid);
            $sheet->mergeCells("Y11:AE11");
            $spreadsheet->getActiveSheet()->getStyle("Y11:AE11")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'outline'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $spreadsheet->getActiveSheet()->getStyle("A9:AF12")->applyFromArray([
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ]
            ]);

            $spreadsheet->getActiveSheet()->getRowDimension(12)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle('A12:AF12')->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'size'  =>  14,
                    'bold'  =>  true,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ]
                ]
            ]);

            $baris = 13;
            $startBaris = $baris;

            $sheet->setCellValue("A$baris", "Place Of Birth");
            $sheet->mergeCells("A$baris:J$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris:J$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("K$baris", "Date Of Birth");
            $sheet->mergeCells("K$baris:T$baris");
            $spreadsheet->getActiveSheet()->getStyle("K$baris:T$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("U$baris", "Age");
            $sheet->mergeCells("U$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("U$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $baris++;

            $sheet->setCellValue("A$baris", $dataMaid->place_of_birth);
            $sheet->mergeCells("A$baris:J$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris:J$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("K$baris", Carbon::parse($dataMaid->date_of_birth)->isoFormat("DD MMMM YYYY"));
            $sheet->mergeCells("K$baris:T$baris");
            $spreadsheet->getActiveSheet()->getStyle("K$baris:T$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("U$baris", Carbon::parse($dataMaid->date_of_birth)->age);
            $sheet->mergeCells("U$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("U$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $baris++;

            $sheet->mergeCells("A$baris:J$baris");
            $sheet->mergeCells("K$baris:T$baris");
            $sheet->mergeCells("U$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'vertical'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Status");
            $sheet->mergeCells("A$baris:G$baris");

            $column = 8;
            foreach ($marital as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($key == $dataMaid->marital ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   =>  [
                        'outline'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ]
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value);
                $sheet->mergeCells("$columExcel$baris:" . columnLetter($column + 4) . $baris);
                $column += 5;
            }

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $sheet->setCellValue("A$baris", "Height");
            $sheet->mergeCells("A$baris:J$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris:J$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("K$baris", "Weight");
            $sheet->mergeCells("K$baris:T$baris");
            $spreadsheet->getActiveSheet()->getStyle("K$baris:T$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("U$baris", "Religion");
            $sheet->mergeCells("U$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("U$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $baris++;

            $sheet->setCellValue("A$baris", $dataMaid->height);
            $sheet->mergeCells("A$baris:J$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris:J$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("K$baris", $dataMaid->weight);
            $sheet->mergeCells("K$baris:T$baris");
            $spreadsheet->getActiveSheet()->getStyle("K$baris:T$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("U$baris", convertReligion($dataMaid->religion));
            $sheet->mergeCells("U$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("U$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;

            $sheet->mergeCells("A$baris:J$baris");
            $sheet->mergeCells("K$baris:T$baris");
            $sheet->mergeCells("U$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'vertical'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $sheet->setCellValue("A$baris", "Language");
            $sheet->mergeCells("A$baris:G$baris");

            $column = 8;
            foreach ($language as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($value->answer == 1 ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   =>  [
                        'outline'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ]
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value->question);
                $sheet->mergeCells("$columExcel$baris:" . columnLetter($column + 4) . $baris);
                $column += 5;
                if ($column > 30) {
                    $baris++;
                    $column = 8;
                }
            }

            $spreadsheet->getActiveSheet()->getStyle("A" . ($startBaris) . ":AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $sheet->mergeCells("A$startBaris:G$baris");

            $baris++;
            $startBaris = $baris;

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $sheet->setCellValue("A$baris", "Passport");
            $sheet->mergeCells("A$baris:H$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris:H$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("I$baris", "Issued");
            $sheet->mergeCells("I$baris:P$baris");
            $spreadsheet->getActiveSheet()->getStyle("I$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("Q$baris", "Issued Date");
            $sheet->mergeCells("Q$baris:Y$baris");
            $spreadsheet->getActiveSheet()->getStyle("Q$baris:Y$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $sheet->setCellValue("Z$baris", "Expired Date");
            $sheet->mergeCells("Z$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("Z$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            $baris++;

            $sheet->setCellValue("A$baris", $dataMaid->paspor_no);
            $sheet->mergeCells("A$baris:H$baris");
            $spreadsheet->getActiveSheet()->getStyle("A$baris:H$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("I$baris", $dataMaid->paspor_issue);
            $sheet->mergeCells("I$baris:P$baris");
            $spreadsheet->getActiveSheet()->getStyle("I$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("Q$baris", ($dataMaid->paspor_date ? Carbon::parse($dataMaid->paspor_date)->isoFormat('DD MMMM YYYY') : ''));
            $sheet->mergeCells("Q$baris:Y$baris");
            $spreadsheet->getActiveSheet()->getStyle("Q$baris:Y$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $sheet->setCellValue("Z$baris", ($dataMaid->expire_date ? Carbon::parse($dataMaid->expire_date)->isoFormat('DD MMMM YYYY') : ''));
            $sheet->mergeCells("Z$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getStyle("Z$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;

            $sheet->mergeCells("A$baris:H$baris");
            $sheet->mergeCells("I$baris:P$baris");
            $sheet->mergeCells("Q$baris:Y$baris");
            $sheet->mergeCells("Z$baris:AF$baris");
            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'vertical'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $column = 1;
            foreach ($medical as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value->question);
                $sheet->mergeCells("$columExcel$baris:" . columnLetter($column + 4) . $baris);
                $column += 5;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($value->answer == 1 ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   =>  [
                        'outline'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ]
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", "Y");
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($value->answer == 1 ? "" : "V"));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   =>  [
                        'outline'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ]
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", "N");
                if ($column > 30) {
                    $baris++;
                    $column = 8;
                }
                $column += 2;
            }

            $spreadsheet->getActiveSheet()->getStyle("A" . ($startBaris) . ":AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$baris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            $sheet->setCellValue("A$baris", "Education");
            $sheet->mergeCells("A$baris:G$baris");

            $column = 8;
            foreach ($education as $key => $value) {
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", ($key == $dataMaid->education ? "V" : ""));
                $spreadsheet->getActiveSheet()->getStyle("$columExcel$baris")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'borders'   =>  [
                        'outline'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ]
                ]);
                $column++;
                $columExcel = columnLetter($column);
                $sheet->setCellValue("$columExcel$baris", $value);
                $sheet->mergeCells("$columExcel$baris:" . columnLetter($column + 4) . $baris);
                $column += 5;
                if ($column > 30) {
                    $baris++;
                    $column = 8;
                }
            }

            $baris++;

            $spreadsheet->getActiveSheet()->getRowDimension($baris)->setRowHeight(4);

            $spreadsheet->getActiveSheet()->getStyle("A$startBaris:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $sheet->mergeCells("A$startBaris:G$baris");

            $baris++;
            $startBaris = $baris;
            $startBarisRight = $baris;

            $sheet->setCellValue("A$baris", "Family Background");
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Father");
            $sheet->mergeCells("A$baris:D$baris");
            $sheet->setCellValue("E$baris", "Age");
            $sheet->mergeCells("E$baris:H$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:H$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $sheet->setCellValue("I$baris", "Mother");
            $sheet->mergeCells("I$baris:L$baris");
            $sheet->setCellValue("M$baris", "Age");
            $sheet->mergeCells("M$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("I$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", $dataMaid->father_name);
            $sheet->mergeCells("A$baris:D$baris");
            $sheet->setCellValue("E$baris", $dataMaid->father_age);
            $sheet->mergeCells("E$baris:H$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:H$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $sheet->setCellValue("I$baris", $dataMaid->mother_name);
            $sheet->mergeCells("I$baris:L$baris");
            $sheet->setCellValue("M$baris", $dataMaid->mother_age);
            $sheet->mergeCells("M$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("I$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Spouse Name : " . $dataMaid->spouse_name);
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Age : " . $dataMaid->spouse_age);
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Number Brother/Sister : " . $dataMaid->number_of_siblings);
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Number In Family : " . $dataMaid->number_in_family);
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Number Children : " . $dataMaid->number_of_children);
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Age : " . $dataMaid->children_ages);
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;
            $sheet->setCellValue("A$baris", "Experience");
            $sheet->mergeCells("A$baris:P$baris");

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $baris++;
            $startBaris = $baris;

            // dd($dataMaid->workExperience);
            foreach ($dataMaid->workExperience as $key => $value) {
                $sheet->setCellValue("A$baris", $value->country . " (" . $value->year_start . " - " . $value->year_end . ")\n" . $value->description . "\nNote : " . $value->note);
                $sheet->mergeCells("A$baris:P" . ($baris + 9));

                $spreadsheet->getActiveSheet()->getStyle("A$baris:P" . ($baris + 9))->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                    'borders'   =>  [
                        'left'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        ],
                        'right'   =>  [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                        ],
                    ]
                ]);
                $baris += 10;
            }

            $spreadsheet->getActiveSheet()->getStyle("A$baris:P$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'left'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $spreadsheet->getActiveSheet()->getStyle("Q$startBarisRight:AF$baris")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders'   =>  [
                    'outline'   =>  [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ]
            ]);

            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Photo');
            $drawing->setDescription('Photo');
            $drawing->setPath(public_path('assets/image/maids/photos/' . $dataMaid->picture_name));
            $drawing->setCoordinates("R" . ($startBarisRight + 1));
            $drawing->setHeight(360);

            $drawing->setWorksheet($spreadsheet->getActiveSheet());
        }

        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.25);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.25);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(1);

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
