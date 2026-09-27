<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Parameter;
use App\Models\Report;
use App\Models\ReportResult;
use App\Models\ReportType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    private array $sampleValues = [
        // Water
        'pH' => ['7.2', '7.4', '7.8', '8.1', '6.9', '7.5'],
        'Total Hardness (TH)' => ['140', '165', '185', '210', '190', '175'],
        'Total Suspended Solids (TSS)' => ['35', '42', '28', '48', '50', '32'],
        'Total Dissolved Solids (TDS)' => ['380', '420', '450', '490', '395', '410'],
        'Turbidity' => ['0.6', '0.8', '0.9', '1.1', '0.7', '0.5'],
        'Electrical Conductivity' => ['620', '710', '680', '740', '590'],
        'Chloride (as Cl)' => ['45.0', '62.5', '58.0', '72.0', '40.5'],
        'Sulphate (as SO4)' => ['32.0', '45.0', '38.5', '50.0', '28.0'],
        'Alkalinity (Total)' => ['120', '145', '160', '135', '150'],

        // Oil & Ghee
        'Free Fatty Acids' => ['0.28', '0.35', '0.41', '0.48', '0.32', '0.25'],
        'Free Fatty Acid (FFA)' => ['0.30', '0.42', '0.55', '0.38', '0.45', '0.29'],
        'Moisture Value' => ['0.08', '0.12', '0.14', '0.10', '0.11', '0.09'],
        'B.R Reading @40 C' => ['1.4485', '1.4490', '1.4495', '1.4488', '1.4482'],
        'Iodine Value' => ['88.5', '92.4', '95.0', '85.2', '91.0', '89.5'],
        'Specific Gravity' => ['0.914', '0.916', '0.918', '0.915', '0.917'],
        'Peroxide Value' => ['4.5', '6.2', '7.0', '5.8', '8.1', '5.0'],
        'Reichert Meissel Value' => ['29.5', '30.2', '28.8', '31.0', '29.0'],
        'Polenske Value' => ['1.2', '1.5', '1.8', '1.4', '1.6'],
        'Baudouin Test' => ['Negative', 'Negative', 'Negative'],
        'Pass / Fail' => ['Pass', 'Pass', 'Pass'],
        'Test for Mineral' => ['Negative', 'Negative', 'Negative'],
        'Rancidity' => ['Negative', 'Negative', 'Negative'],
        'Saponification Value' => ['192.5', '195.0', '189.0', '194.2'],
        'Acid Value' => ['0.60', '0.75', '0.82', '0.55', '0.68'],

        // Feed & Rice Bran
        'Oil Content (OC)' => ['9.8', '11.4', '12.5', '10.2', '11.9', '10.8'],
        'Sand & Silica (SS)' => ['0.8', '1.2', '1.5', '0.9', '1.1', '0.7'],
        'Total Ash' => ['4.8', '5.4', '6.1', '5.0', '5.7', '5.2'],
        'Fiber' => ['7.5', '8.7', '9.2', '8.0', '8.4', '7.9'],
        'Protein' => ['15.5', '16.2', '17.8', '16.8', '18.1', '16.0'],
        'Moisture' => ['8.5', '9.1', '9.8', '8.9', '9.4', '8.7'],
        'Urea Content' => ['Nil', 'Nil', 'Nil', 'Nil'],
        'Aflatoxin B1' => ['< 5 ppb', '< 10 ppb', '< 5 ppb', '< 2 ppb'],

        // Soil & Fertilizer
        'Organic Carbon' => ['0.65', '0.78', '0.82', '0.59', '0.72'],
        'Available Nitrogen' => ['185', '210', '245', '195', '220'],
        'Available Phosphorus' => ['18.5', '24.0', '21.2', '16.8', '22.5'],
        'Available Potassium' => ['280', '320', '360', '295', '340'],
        'Total Nitrogen (N)' => ['19.5', '20.2', '18.8', '20.0'],
        'Total Phosphate (P2O5)' => ['19.8', '20.5', '19.2', '20.1'],
        'Water Soluble Potash' => ['19.4', '20.0', '19.6', '20.2'],

        // Dairy / Milk
        'Fat Content' => ['4.2', '4.5', '4.8', '3.9', '4.6'],
        'Solids Not Fat (SNF)' => ['8.6', '8.8', '8.9', '8.5', '8.7'],
        'Acidity (as Lactic Acid)' => ['0.13', '0.14', '0.15', '0.13'],
        'Added Water' => ['Nil', 'Nil', 'Nil', 'Nil'],
    ];

    public function run(): void
    {
        // 1. Purge previous reports and invoices cleanly
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        InvoiceItem::truncate();
        Invoice::truncate();
        ReportResult::truncate();
        Report::truncate();
        Customer::truncate();
        CustomerGroup::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Admin & Staff users
        $admin = $this->seedUsers();

        // 3. Complete Report Types & Parameters
        $types = $this->seedTypes();

        // Seed data for both is_demo=0 (standard accounts) and is_demo=1 (demo accounts)
        foreach ([0, 1] as $isDemo) {
            // Groups
            $groupA = CustomerGroup::create(['name' => 'Kongu Agro Consortium' . ($isDemo ? ' (Demo)' : ''), 'is_demo' => $isDemo]);
            $groupB = CustomerGroup::create(['name' => 'Sri Murugan Feeds Group' . ($isDemo ? ' (Demo)' : ''), 'is_demo' => $isDemo]);
            $groupC = CustomerGroup::create(['name' => 'Tamil Nadu Dairy Federation' . ($isDemo ? ' (Demo)' : ''), 'is_demo' => $isDemo]);

            // Companies
            $customers = $this->seedCustomers($groupA, $groupB, $groupC, $isDemo);

            // Generate reports & invoices
            $this->seedComprehensiveReports($admin, $types, $customers, $isDemo);
        }
    }

    private function seedUsers(): User
    {
        $defs = [
            ['email' => 'admin@krishilab.com', 'name' => 'Administrator', 'role' => 'admin', 'permissions' => null, 'is_demo' => 0],
            ['email' => 'staff@krishilab.com', 'name' => 'Lab Staff', 'role' => 'staff',
             'permissions' => ['create_report', 'view_reports', 'generate_pdf', 'print_report'], 'is_demo' => 0],
            ['email' => 'demo@krishilab.com', 'name' => 'Demo Administrator', 'role' => 'admin', 'permissions' => null, 'is_demo' => 1],
            ['email' => 'staff-demo@krishilab.com', 'name' => 'Demo Staff', 'role' => 'staff',
             'permissions' => ['create_report', 'view_reports', 'generate_pdf', 'print_report'], 'is_demo' => 1],
        ];

        $admin = null;
        foreach ($defs as $d) {
            $user = User::query()->firstOrCreate(
                ['email' => $d['email']],
                [
                    'name' => $d['name'],
                    'password' => Hash::make('Password123!'),
                    'role' => $d['role'],
                    'status' => 'active',
                    'permissions' => $d['permissions'],
                    'is_demo' => $d['is_demo'],
                ]
            );
            if ($d['role'] === 'admin' && !$admin) {
                $admin = $user;
            }
        }

        return $admin ?? User::first();
    }

    private function seedTypes(): array
    {
        $defs = [
            ['name' => 'Water', 'title' => 'CERTIFICATE OF ANALYSIS', 'show_specification' => true, 'custom_columns' => [], 'params' => [
                ['name' => 'pH', 'unit' => '', 'specification' => '6.5 - 8.5', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Total Hardness (TH)', 'unit' => 'mg/l', 'specification' => '200 Max', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Total Suspended Solids (TSS)', 'unit' => 'mg/l', 'specification' => '-', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Total Dissolved Solids (TDS)', 'unit' => 'mg/l', 'specification' => '500 Max', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Turbidity', 'unit' => 'NTU', 'specification' => '1 Max', 'price' => 120, 'hsn_code' => '998346'],
                ['name' => 'Electrical Conductivity', 'unit' => 'µS/cm', 'specification' => '1000 Max', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Chloride (as Cl)', 'unit' => 'mg/l', 'specification' => '250 Max', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Sulphate (as SO4)', 'unit' => 'mg/l', 'specification' => '200 Max', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Alkalinity (Total)', 'unit' => 'mg/l', 'specification' => '200 Max', 'price' => 160, 'hsn_code' => '998346'],
            ]],
            ['name' => 'Edible Oil', 'title' => 'CERTIFICATE OF ANALYSIS', 'show_specification' => true, 'custom_columns' => [], 'params' => [
                ['name' => 'Free Fatty Acids', 'unit' => '%', 'specification' => '0.50 % Max', 'price' => 250, 'hsn_code' => '998346'],
                ['name' => 'Moisture Value', 'unit' => '%', 'specification' => '0.20 % Max', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'B.R Reading @40 C', 'unit' => '', 'specification' => '1.4480 To 1.4500', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Iodine Value', 'unit' => '', 'specification' => '80 To 100', 'price' => 220, 'hsn_code' => '998346'],
                ['name' => 'Specific Gravity', 'unit' => '', 'specification' => '0.910 To 0.920', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Peroxide Value', 'unit' => 'meq/kg', 'specification' => '10 Max', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Saponification Value', 'unit' => 'mg KOH/g', 'specification' => '188 - 196', 'price' => 220, 'hsn_code' => '998346'],
                ['name' => 'Acid Value', 'unit' => 'mg KOH/g', 'specification' => '0.6 Max', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Test for Mineral', 'unit' => '', 'specification' => 'Negative', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Rancidity', 'unit' => '', 'specification' => 'Negative', 'price' => 100, 'hsn_code' => '998346'],
            ]],
            ['name' => 'Ghee', 'title' => 'CERTIFICATE OF ANALYSIS', 'show_specification' => true, 'custom_columns' => [], 'params' => [
                ['name' => 'Free Fatty Acids', 'unit' => '%', 'specification' => '0.50 % Max', 'price' => 250, 'hsn_code' => '998346'],
                ['name' => 'Moisture Value', 'unit' => '%', 'specification' => '0.15 % Max', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'B.R Reading @40 C', 'unit' => '', 'specification' => '1.4480 To 1.4500', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Reichert Meissel Value', 'unit' => '', 'specification' => '28 Min', 'price' => 300, 'hsn_code' => '998346'],
                ['name' => 'Polenske Value', 'unit' => '', 'specification' => '1.0 To 2.0', 'price' => 220, 'hsn_code' => '998346'],
                ['name' => 'Baudouin Test', 'unit' => '', 'specification' => 'Negative', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Pass / Fail', 'unit' => '', 'specification' => 'Pass', 'price' => 100, 'hsn_code' => '998346'],
            ]],
            ['name' => 'Cattle Feed', 'title' => 'ANALYSIS REPORT', 'show_specification' => false, 'custom_columns' => [], 'params' => [
                ['name' => 'Oil Content (OC)', 'unit' => '%', 'specification' => '-', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Free Fatty Acid (FFA)', 'unit' => '%', 'specification' => '-', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Sand & Silica (SS)', 'unit' => '%', 'specification' => '-', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Total Ash', 'unit' => '%', 'specification' => '-', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Fiber', 'unit' => '%', 'specification' => '-', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Protein', 'unit' => '%', 'specification' => '-', 'price' => 250, 'hsn_code' => '998346'],
                ['name' => 'Moisture', 'unit' => '%', 'specification' => '-', 'price' => 120, 'hsn_code' => '998346'],
                ['name' => 'Urea Content', 'unit' => '%', 'specification' => 'Nil', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Aflatoxin B1', 'unit' => 'ppb', 'specification' => '20 ppb Max', 'price' => 350, 'hsn_code' => '998346'],
                ['name' => 'Rancidity', 'unit' => '', 'specification' => 'Negative', 'price' => 100, 'hsn_code' => '998346'],
            ]],
            ['name' => 'Rice Bran', 'title' => 'ANALYSIS REPORT', 'show_specification' => true, 'custom_columns' => ['Colour', 'Texture'], 'params' => [
                ['name' => 'Oil Content (OC)', 'unit' => '%', 'specification' => '14.0 % Min', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Free Fatty Acid (FFA)', 'unit' => '%', 'specification' => '5.0 % Max', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Sand & Silica (SS)', 'unit' => '%', 'specification' => '2.5 % Max', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Fiber', 'unit' => '%', 'specification' => '12.0 % Max', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Moisture', 'unit' => '%', 'specification' => '10.0 % Max', 'price' => 120, 'hsn_code' => '998346'],
            ]],
            ['name' => 'Soil & Agriculture', 'title' => 'CERTIFICATE OF ANALYSIS', 'show_specification' => true, 'custom_columns' => [], 'params' => [
                ['name' => 'pH', 'unit' => '', 'specification' => '6.5 - 7.5', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Electrical Conductivity', 'unit' => 'dS/m', 'specification' => '< 1.0 Normal', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Organic Carbon', 'unit' => '%', 'specification' => '> 0.75 High', 'price' => 200, 'hsn_code' => '998346'],
                ['name' => 'Available Nitrogen', 'unit' => 'kg/ha', 'specification' => '280 - 560 Medium', 'price' => 250, 'hsn_code' => '998346'],
                ['name' => 'Available Phosphorus', 'unit' => 'kg/ha', 'specification' => '11 - 22 Medium', 'price' => 220, 'hsn_code' => '998346'],
                ['name' => 'Available Potassium', 'unit' => 'kg/ha', 'specification' => '110 - 280 Medium', 'price' => 220, 'hsn_code' => '998346'],
            ]],
            ['name' => 'Fertilizer', 'title' => 'ANALYSIS REPORT', 'show_specification' => true, 'custom_columns' => [], 'params' => [
                ['name' => 'Total Nitrogen (N)', 'unit' => '%', 'specification' => '19.0 % Min', 'price' => 250, 'hsn_code' => '998346'],
                ['name' => 'Total Phosphate (P2O5)', 'unit' => '%', 'specification' => '19.0 % Min', 'price' => 250, 'hsn_code' => '998346'],
                ['name' => 'Water Soluble Potash', 'unit' => '%', 'specification' => '19.0 % Min', 'price' => 250, 'hsn_code' => '998346'],
                ['name' => 'Moisture', 'unit' => '%', 'specification' => '1.5 % Max', 'price' => 150, 'hsn_code' => '998346'],
            ]],
            ['name' => 'Milk & Dairy', 'title' => 'CERTIFICATE OF ANALYSIS', 'show_specification' => true, 'custom_columns' => [], 'params' => [
                ['name' => 'Fat Content', 'unit' => '%', 'specification' => '4.5 % Min', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Solids Not Fat (SNF)', 'unit' => '%', 'specification' => '8.5 % Min', 'price' => 180, 'hsn_code' => '998346'],
                ['name' => 'Acidity (as Lactic Acid)', 'unit' => '%', 'specification' => '0.12 - 0.16 %', 'price' => 150, 'hsn_code' => '998346'],
                ['name' => 'Added Water', 'unit' => '%', 'specification' => 'Nil', 'price' => 120, 'hsn_code' => '998346'],
            ]],
        ];

        $out = [];
        foreach ($defs as $d) {
            $rt = ReportType::updateOrCreate(
                ['name' => $d['name']],
                [
                    'title' => $d['title'],
                    'active' => true,
                    'show_specification' => $d['show_specification'],
                    'custom_columns' => $d['custom_columns'],
                ]
            );

            foreach ($d['params'] as $i => $p) {
                Parameter::updateOrCreate(
                    ['report_type_id' => $rt->id, 'name' => $p['name']],
                    array_merge($p, ['display_order' => $i + 1, 'active' => true])
                );
            }

            $out[$d['name']] = $rt;
        }

        return $out;
    }

    private function seedCustomers(CustomerGroup $groupA, CustomerGroup $groupB, CustomerGroup $groupC, int $isDemo): array
    {
        $defs = [
            // Kongu Agro Consortium
            [
                'name' => 'Ravi Traders' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Ravi Agro Products Pvt Ltd' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'Ravi Kumar',
                'phone' => '+91 98422 12001',
                'email' => 'ravi@raviagro.com',
                'city' => 'Erode',
                'state' => 'Tamil Nadu',
                'gstin' => '33ABCDE1234F1Z5',
                'address' => '12, Bazaar Street, Kangeyam Road, Erode - 638001',
                'group_id' => $groupA->id,
            ],
            [
                'name' => 'Sri Lakshmi Foods' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Sri Lakshmi Agro Foods' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'Lakshmi Devi',
                'phone' => '+91 98422 12002',
                'email' => 'orders@lakshmifoods.in',
                'city' => 'Coimbatore',
                'state' => 'Tamil Nadu',
                'gstin' => '33AAACB5678G1ZP',
                'address' => '44, Trichy Road, Singanallur, Coimbatore - 641018',
                'group_id' => $groupA->id,
            ],
            [
                'name' => 'Anand Spinning Mills' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Anand Cotton & Oil Mills' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'S. Anand',
                'phone' => '+91 98422 12003',
                'email' => 'purchase@anandmills.in',
                'city' => 'Tiruppur',
                'state' => 'Tamil Nadu',
                'gstin' => '33AACCA3456J1ZQ',
                'address' => 'SIDCO Industrial Estate, Tiruppur - 641604',
                'group_id' => $groupA->id,
            ],

            // Sri Murugan Feeds Group
            [
                'name' => 'Murugan Feed Mills' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Murugan Animal Feeds Pvt Ltd' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'M. Murugan',
                'phone' => '+91 98422 12004',
                'email' => 'murugan@muruganfeeds.in',
                'city' => 'Namakkal',
                'state' => 'Tamil Nadu',
                'gstin' => '33AAAFM9921B1Z3',
                'address' => '5, Salem Main Road, Namakkal - 637001',
                'group_id' => $groupB->id,
            ],
            [
                'name' => 'VetCare Nutrition' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'VetCare Feeds & Animal Nutrition' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'Dr. Priya N',
                'phone' => '+91 98422 12005',
                'email' => 'priya@vetcarefeeds.com',
                'city' => 'Salem',
                'state' => 'Tamil Nadu',
                'gstin' => '33AAECV2234M1ZT',
                'address' => '8, SIPCOT Complex, Salem - 636009',
                'group_id' => $groupB->id,
            ],

            // Tamil Nadu Dairy Federation Group
            [
                'name' => 'Ganga Dairy Products' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Ganga Milk & Dairy Foods' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'G. Gangadharan',
                'phone' => '+91 98422 12008',
                'email' => 'contact@gangadairy.in',
                'city' => 'Dindigul',
                'state' => 'Tamil Nadu',
                'gstin' => '33AABCG1234K1Z8',
                'address' => '22, Dairy Road, Dindigul - 624001',
                'group_id' => $groupC->id,
            ],
            [
                'name' => 'Kaveri Milk Union' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Kaveri District Milk Producers Union Ltd' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'K. Rangarajan',
                'phone' => '+91 98422 12009',
                'email' => 'procurement@kaverimilk.org',
                'city' => 'Trichy',
                'state' => 'Tamil Nadu',
                'gstin' => '33AABCK5678M1Z2',
                'address' => '100, Junction Road, Trichy - 620001',
                'group_id' => $groupC->id,
            ],

            // Standalone Companies
            [
                'name' => 'Kumar Oil Industries' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Kumar Oil Refineries & Copra Extractors' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'V. Kumar',
                'phone' => '+91 98422 12006',
                'email' => 'kumar@kumaroil.com',
                'city' => 'Kangeyam',
                'state' => 'Tamil Nadu',
                'gstin' => '33AADFK7890L1ZR',
                'address' => '18, Mill Road, Kangeyam - 638701',
                'group_id' => null,
            ],
            [
                'name' => 'Green Valley Farms' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Green Valley Dairy & Organics Ltd' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'Mani Rajan',
                'phone' => '+91 98422 12007',
                'email' => 'mani@greenvalleydairy.com',
                'city' => 'Karur',
                'state' => 'Tamil Nadu',
                'gstin' => '33AFGPQ9012H1ZK',
                'address' => 'Plot 7, Dairy Complex, Karur - 639001',
                'group_id' => null,
            ],
            [
                'name' => 'Bala Bio Fertilizers' . ($isDemo ? ' [Demo]' : ''),
                'company_name' => 'Bala Organic Bio Fertilizers & Soil Care' . ($isDemo ? ' (Demo)' : ''),
                'contact_person' => 'Bala Subramaniam',
                'phone' => '+91 98422 12010',
                'email' => 'info@balabio.in',
                'city' => 'Pollachi',
                'state' => 'Tamil Nadu',
                'gstin' => '33AABCB9900N1Z5',
                'address' => '14, Palani Road, Pollachi - 642001',
                'group_id' => null,
            ],
        ];

        $out = [];
        foreach ($defs as $d) {
            $c = Customer::create(
                array_merge($d, ['is_active' => true, 'is_demo' => $isDemo])
            );
            $key = str_replace([' [Demo]', ' (Demo)'], '', $d['name']);
            $out[$key] = $c;
        }

        return $out;
    }

    private function seedComprehensiveReports(User $admin, array $types, array $customers, int $isDemo): void
    {
        // 36 diverse real-world scenario reports spanning multiple test types, dates, GST modes, and quantities
        $reportScenarios = [
            // Ravi Agro Products (Kongu Agro Group)
            ['Ravi Traders', 'Edible Oil', 'Refined Coconut Oil - Tanker Lot 1', 'TN38 BX 4512', '45 Bags / 22.50 Tons', 1, 'completed', 'paid', true],
            ['Ravi Traders', 'Water', 'RO Treated Process Water - Plant 1', 'TN38 CA 8812', '1 Sample Bottle (500ml)', 3, 'completed', 'paid', false],
            ['Ravi Traders', 'Cattle Feed', 'Cotton Seed Cake Premium - Batch A', 'TN38 DE 1920', '80 Bags / 4.00 Tons', 6, 'completed', 'unpaid', false],
            ['Ravi Traders', 'Rice Bran', 'De-Oiled Rice Bran Cake - Export Lot', 'TN38 FG 3341', '120 Bags / 6.00 Tons', 9, 'completed', 'unpaid', true],
            ['Ravi Traders', 'Soil & Agriculture', 'Agricultural Farm Soil Sample - Field 2', '-', '1 Sample Bag (2 Kgs)', 15, 'completed', 'paid', true],

            // Sri Lakshmi Agro Foods (Kongu Agro Group)
            ['Sri Lakshmi Foods', 'Ghee', 'Pure Cow Ghee - Agmark Special Grade', 'TN33 AB 5510', '50 Tins / 15 Kgs each', 2, 'completed', 'paid', true],
            ['Sri Lakshmi Foods', 'Edible Oil', 'Refined Sunflower Oil - Bulk Shipment', 'TN33 CD 7714', '60 Drums / 30.00 Tons', 5, 'completed', 'partial', true],
            ['Sri Lakshmi Foods', 'Water', 'Borewell Raw Water Supply', 'TN33 EF 9920', '1 Sample Can (2 Ltrs)', 8, 'completed', 'unpaid', false],
            ['Sri Lakshmi Foods', 'Ghee', 'Buffalo Ghee Sample - Batch 104', 'TN33 GH 1210', '25 Tins / 15 Kgs each', 14, 'completed', 'paid', true],

            // Anand Cotton & Oil Mills (Kongu Agro Group)
            ['Anand Spinning Mills', 'Edible Oil', 'Cotton Seed Crude Oil - Crushed Lot', 'TN39 KK 1120', '35.00 Tons Tanker', 4, 'completed', 'paid', true],
            ['Anand Spinning Mills', 'Cattle Feed', 'Cotton Seed Meal - High Protein', 'TN39 LM 4410', '100 Bags / 5.00 Tons', 7, 'completed', 'unpaid', false],
            ['Anand Spinning Mills', 'Water', 'Boiler Feed Soft Water', 'TN39 NO 6612', '1 Sample Bottle', 11, 'completed', 'unpaid', false],
            ['Anand Spinning Mills', 'Fertilizer', 'Organic Compost Fertilizer Pellets', 'TN39 PQ 8890', '40 Bags / 2.00 Tons', 20, 'completed', 'paid', true],

            // Murugan Animal Feeds (Sri Murugan Feeds Group)
            ['Murugan Feed Mills', 'Cattle Feed', 'Layer Mash Poultry Feed - Special', 'TN28 AA 8840', '150 Bags / 7.50 Tons', 1, 'completed', 'paid', true],
            ['Murugan Feed Mills', 'Rice Bran', 'Raw Rice Bran - Grade 1 Solvents', 'TN28 BB 9912', '200 Bags / 10.00 Tons', 4, 'completed', 'paid', false],
            ['Murugan Feed Mills', 'Water', 'Poultry Farm Bore Water Supply', 'TN28 CC 4410', '1 Sample Jar', 8, 'completed', 'unpaid', false],
            ['Murugan Feed Mills', 'Cattle Feed', 'Broiler Finisher Feed Pellets', 'TN28 DD 7720', '120 Bags / 6.00 Tons', 16, 'completed', 'paid', true],

            // VetCare Feeds & Nutrition (Sri Murugan Feeds Group)
            ['VetCare Nutrition', 'Cattle Feed', 'Dairy Cattle High-Yield Concentrate', 'TN27 XX 1209', '120 Bags / 6.00 Tons', 2, 'completed', 'paid', true],
            ['VetCare Nutrition', 'Rice Bran', 'Solvent Extracted Rice Bran - Premium', 'TN27 YY 3314', '180 Bags / 9.00 Tons', 6, 'completed', 'partial', true],
            ['VetCare Nutrition', 'Water', 'Lab Filtered Drinking Water', 'TN27 ZZ 5520', '1 Sample Bottle', 10, 'completed', 'unpaid', false],
            ['VetCare Nutrition', 'Cattle Feed', 'Calf Starter Milk Mash', 'TN27 AB 9901', '80 Bags / 4.00 Tons', 22, 'completed', 'paid', true],

            // Ganga Milk & Dairy Foods (Tamil Nadu Dairy Federation)
            ['Ganga Dairy Products', 'Milk & Dairy', 'Standardized Cow Milk - Morning Tanker', 'TN57 AA 2310', '15,000 Litres Tanker', 2, 'completed', 'paid', true],
            ['Ganga Dairy Products', 'Ghee', 'Pure Desi Butter Ghee - Grade A', 'TN57 BB 4520', '60 Tins / 15 Kgs each', 7, 'completed', 'paid', true],
            ['Ganga Dairy Products', 'Water', 'Dairy CIP Rinse Water Sample', 'TN57 CC 6730', '1 Sample Bottle', 12, 'completed', 'unpaid', false],

            // Kaveri District Milk Union (Tamil Nadu Dairy Federation)
            ['Kaveri Milk Union', 'Milk & Dairy', 'Full Cream Buffalo Milk - Bulk Lot', 'TN45 DD 1102', '12,000 Litres Tanker', 3, 'completed', 'paid', true],
            ['Kaveri Milk Union', 'Ghee', 'Commercial Table Ghee Sample', 'TN45 EE 3314', '80 Tins / 15 Kgs each', 9, 'completed', 'partial', true],
            ['Kaveri Milk Union', 'Water', 'Chilling Center Raw Bore Water', 'TN45 FF 5520', '1 Sample Can', 18, 'completed', 'unpaid', false],

            // Kumar Oil Refineries (Standalone)
            ['Kumar Oil Industries', 'Edible Oil', 'Virgin Coconut Oil - Cold Pressed', 'TN42 AA 1008', '40 Drums / 8.00 Tons', 1, 'completed', 'paid', true],
            ['Kumar Oil Industries', 'Edible Oil', 'Crude Palm Kernel Oil - Import Lot', 'TN42 BB 2219', '30.00 Tons Tanker', 5, 'completed', 'unpaid', true],
            ['Kumar Oil Industries', 'Ghee', 'Agmark Special Table Ghee', 'TN42 CC 3340', '80 Tins', 9, 'completed', 'paid', false],
            ['Kumar Oil Industries', 'Edible Oil', 'Groundnut Oil Filtered Grade 1', 'TN42 DD 4450', '50 Drums / 10.00 Tons', 17, 'completed', 'paid', true],

            // Green Valley Dairy & Organics (Standalone)
            ['Green Valley Farms', 'Water', 'Dairy Plant Main Borewell Water', 'TN47 DD 8812', '1 Sample Can (2 Ltrs)', 2, 'completed', 'paid', true],
            ['Green Valley Farms', 'Ghee', 'Organic Farm Butter Ghee Sample', 'TN47 EE 9920', '40 Tins / 15 Kgs each', 7, 'completed', 'unpaid', false],
            ['Green Valley Farms', 'Cattle Feed', 'Organic Cattle Feed Pellets - Stage 1', 'TN47 FF 1140', '60 Bags / 3.00 Tons', 12, 'completed', 'unpaid', false],
            ['Green Valley Farms', 'Soil & Agriculture', 'Organic Orchard Soil Test', '-', '1 Sample Bag', 25, 'completed', 'paid', false],

            // Bala Bio Fertilizers (Standalone)
            ['Bala Bio Fertilizers', 'Fertilizer', 'NPK 19:19:19 Water Soluble Complex', 'TN41 AA 9012', '100 Bags / 5.00 Tons', 3, 'completed', 'paid', true],
            ['Bala Bio Fertilizers', 'Soil & Agriculture', 'Red Soil Fertility Profile Analysis', '-', '1 Sample Bag (2 Kgs)', 8, 'completed', 'unpaid', true],
            ['Bala Bio Fertilizers', 'Water', 'Agricultural Irrigation Well Water', 'TN41 BB 1240', '1 Sample Jar', 14, 'completed', 'paid', false],
        ];

        $prefix = $isDemo ? 'DEM-' : 'KLA-';
        $invPrefix = $isDemo ? 'DEM-INV-' : 'INV-';

        $reportSeq = 100;
        $invoiceSeq = 200;

        foreach ($reportScenarios as $i => $sc) {
            [$custName, $typeKey, $sampleName, $vehNo, $qty, $daysAgo, $status, $invStatus, $gstOn] = $sc;

            $cust = $customers[$custName] ?? null;
            $type = $types[$typeKey] ?? null;
            if (!$cust || !$type) continue;

            $reportSeq++;
            $reportNo = $prefix . date('Y') . '-' . str_pad($reportSeq, 4, '0', STR_PAD_LEFT);
            $billNo = ($isDemo ? 'DEM-BILL-' : 'BILL-') . str_pad($reportSeq, 4, '0', STR_PAD_LEFT);
            $date = now()->subDays($daysAgo);

            $companyName = $cust->company_name ?: $cust->name;

            $rep = Report::create([
                'report_no' => $reportNo,
                'report_type_id' => $type->id,
                'customer_id' => $cust->id,
                'sample_date' => $date->toDateString(),
                'coa_date' => $date->copy()->addDay()->toDateString(),
                'party_name' => $companyName,
                'customer_name' => $cust->name,
                'sample_name' => $sampleName,
                'nature_of_sample' => $typeKey,
                'vehicle_no' => $vehNo === '-' ? '' : $vehNo,
                'bill_no' => $billNo,
                'bags_tons' => $qty,
                'buyer' => $companyName,
                'seller' => 'KRISHI ANALYTICAL LAB',
                'remarks' => '',
                'status' => $status,
                'created_by' => $admin->id,
                'is_demo' => $isDemo,
            ]);
            $rep->forceFill(['created_at' => $date, 'updated_at' => $date])->save();

            // Populate test parameters
            $typeParams = $type->parameters()->where('active', true)->orderBy('display_order')->get();
            foreach ($typeParams as $pi => $param) {
                $possibleVals = $this->sampleValues[$param->name] ?? ['10.5'];
                $val = $possibleVals[($i + $pi) % count($possibleVals)];

                ReportResult::create([
                    'report_id' => $rep->id,
                    'parameter_id' => $param->id,
                    'result' => $val,
                    'specification' => $param->specification,
                    'display_order' => $pi + 1,
                    'enabled' => true,
                ]);
            }

            // Create Invoice
            $invoiceSeq++;
            $invNo = $invPrefix . date('Y') . '-' . str_pad($invoiceSeq, 4, '0', STR_PAD_LEFT);

            $inv = Invoice::create([
                'report_id' => $rep->id,
                'invoice_no' => $invNo,
                'party_name' => $companyName,
                'customer_name' => $cust->name,
                'subtotal' => 0,
                'gst_percent' => 18,
                'gst_amount' => 0,
                'total_amount' => 0,
                'gst_enabled' => $gstOn,
                'status' => $invStatus,
                'is_demo' => $isDemo,
            ]);

            $inv->syncItems($rep);
            $inv->recalcTotals();
            $inv->forceFill(['created_at' => $date, 'updated_at' => $date])->save();
        }
    }
}
