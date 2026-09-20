<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ReportType;
use App\Models\Parameter;
use App\Models\LabSetting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(['email'=>'admin@krishilab.com'], [
            'name'=>'Admin',
            'password'=>Hash::make('Password123!'),
            'role'=>'admin',
            'status'=>'active',
        ]);
        User::firstOrCreate(['email'=>'master@krishilab.com'], [
            'name'=>'Master Admin',
            'password'=>Hash::make('Password123!'),
            'role'=>'admin',
            'status'=>'active',
        ]);
        // Staff example
        User::firstOrCreate(['email'=>'staff@krishilab.com'], [
            'name'=>'Lab Staff',
            'password'=>Hash::make('Password123!'),
            'role'=>'staff',
            'status'=>'active',
            'permissions'=>json_encode(['create_report','view_reports','generate_pdf','print_report']),
        ]);

        LabSetting::firstOrCreate(['lab_name'=>'KRISHI ANALYTICAL LAB'], [
            'tagline'=>'Discovering Solutions, One Test at a Time',
            'address'=>'182-B, Reliance Trends Near, Tiruppur Road, Kangeyam - 638701, Tiruppur Dist, Tamil Nadu',
            'phone'=>'+91 63793 12357',
            'email'=>'info@krishianalyticallab.com',
        ]);

        $types = [
            ['name'=>'Water','title'=>'CERTIFICATE OF ANALYSIS','active'=>true],
            ['name'=>'Oil','title'=>'CERTIFICATE OF ANALYSIS','active'=>true],
            ['name'=>'Ghee','title'=>'CERTIFICATE OF ANALYSIS','active'=>true],
            ['name'=>'Animal Feed','title'=>'ANALYSIS REPORT','active'=>true],
            ['name'=>'Rice Bran','title'=>'ANALYSIS REPORT','active'=>true],
        ];
        foreach ($types as $t) {
            ReportType::firstOrCreate(['name'=>$t['name']], $t);
        }

        $rtWater = ReportType::where('name','Water')->first();
        $rtOil = ReportType::where('name','Oil')->first();
        $rtGhee = ReportType::where('name','Ghee')->first();
        $rtFeed = ReportType::where('name','Animal Feed')->first();
        $rtRice = ReportType::where('name','Rice Bran')->first();

        $this->seedParams($rtWater, [
            ['name'=>'pH','unit'=>'','specification'=>'6.5 - 8.5'],
            ['name'=>'Total Hardness (TH)','unit'=>'mg/l','specification'=>'200 Max'],
            ['name'=>'Total Suspended Solids (TSS)','unit'=>'mg/l','specification'=>'-'],
            ['name'=>'Total Dissolved Solids (TDS)','unit'=>'mg/l','specification'=>'500 Max'],
            ['name'=>'Turbidity','unit'=>'NTU','specification'=>'1 Max'],
        ]);
        $this->seedParams($rtGhee, [
            ['name'=>'Free Fatty Acids','unit'=>'%','specification'=>'0.50 % Max'],
            ['name'=>'Moisture Value','unit'=>'%','specification'=>'0.15 % Max'],
            ['name'=>'B.R Reading @40 C','unit'=>'','specification'=>'1.4480 To 1.4500'],
            ['name'=>'Peroxide Value','unit'=>'','specification'=>'-'],
            ['name'=>'Reichert Meissel Value','unit'=>'','specification'=>'28 Min'],
            ['name'=>'Polenske Value','unit'=>'','specification'=>'1.0 To 2.0'],
            ['name'=>'Baudouin Test','unit'=>'','specification'=>'Negative'],
            ['name'=>'Double Wash RM','unit'=>'','specification'=>'-'],
            ['name'=>'Pass / Fail','unit'=>'','specification'=>'-'],
        ]);
        $this->seedParams($rtOil, [
            ['name'=>'Free Fatty Acids','unit'=>'%','specification'=>'0.50 % Max'],
            ['name'=>'Moisture Value','unit'=>'%','specification'=>'0.20 % Max'],
            ['name'=>'B.R Reading @40 C','unit'=>'','specification'=>'1.4480 To 1.4500'],
            ['name'=>'Iodine Value','unit'=>'','specification'=>'80 To 100'],
            ['name'=>'Specific Gravity','unit'=>'','specification'=>'0.910 To 0.920'],
            ['name'=>'Peroxide Value','unit'=>'','specification'=>'10 Max'],
            ['name'=>'Test for Mineral','unit'=>'','specification'=>'Negative'],
            ['name'=>'Rancidity','unit'=>'','specification'=>'Negative'],
        ]);
        $feedParams = [
            ['name'=>'Oil Content (OC)','unit'=>'%','specification'=>'-'],
            ['name'=>'Free Fatty Acid (FFA)','unit'=>'%','specification'=>'-'],
            ['name'=>'Sand & Silica (SS)','unit'=>'%','specification'=>'-'],
            ['name'=>'Total Ash','unit'=>'%','specification'=>'-'],
            ['name'=>'Fiber','unit'=>'%','specification'=>'-'],
            ['name'=>'Protein','unit'=>'%','specification'=>'-'],
            ['name'=>'Moisture','unit'=>'%','specification'=>'-'],
            ['name'=>'Rancidity','unit'=>'','specification'=>'Negative'],
        ];
        $this->seedParams($rtFeed, $feedParams);
        $this->seedParams($rtRice, $feedParams);
    }

    private function seedParams($reportType, array $params): void
    {
        if (!$reportType) return;
        foreach ($params as $i => $p) {
            Parameter::firstOrCreate(
                ['report_type_id'=>$reportType->id, 'name'=>$p['name']],
                array_merge($p, ['display_order'=>$i+1, 'active'=>true])
            );
        }
    }
}
