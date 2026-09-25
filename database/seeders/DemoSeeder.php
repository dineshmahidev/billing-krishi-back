<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Invoice;
use App\Models\Parameter;
use App\Models\Report;
use App\Models\ReportResult;
use App\Models\ReportType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    private array $resultValues = [
        'pH' => '7.4',
        'Total Hardness (TH)' => '185',
        'Total Suspended Solids (TSS)' => '42',
        'Total Dissolved Solids (TDS)' => '430',
        'Turbidity' => '0.8',
        'Free Fatty Acids' => '0.32',
        'Free Fatty Acid (FFA)' => '0.41',
        'Moisture Value' => '0.12',
        'Iodine Value' => '92.4',
        'Specific Gravity' => '0.915',
        'Peroxide Value' => '6.5',
        'Rancidity' => 'Negative',
        'Oil Content (OC)' => '11.4',
        'Total Ash' => '5.4',
        'Fiber' => '8.7',
        'Protein' => '16.2',
        'Moisture' => '9.1',
    ];

    public function run(): void
    {
        $admin = $this->seedUsers();
        $types = $this->seedTypes();
        $group = $this->seedGroup();
        $customers = $this->seedCustomers($group);
        $this->seedReports($admin, $types, $customers);
    }

    private function seedUsers(): User
    {
        $defs = [
            ['email' => 'demo@krishilab.com', 'name' => 'Demo Administrator', 'role' => 'admin', 'permissions' => null],
            ['email' => 'staff-demo@krishilab.com', 'name' => 'Demo Staff', 'role' => 'staff',
             'permissions' => ['create_report', 'view_reports', 'generate_pdf', 'print_report']],
        ];

        $admin = null;
        foreach ($defs as $d) {
            $user = User::query()->firstOrCreate(
                ['email' => $d['email']],
                array_filter([
                    'name' => $d['name'],
                    'password' => Hash::make('Demo123!'),
                    'role' => $d['role'],
                    'status' => 'active',
                    'permissions' => $d['permissions'],
                    'is_demo' => 1,
                ], fn ($v) => $v !== null)
            );
            if (!$user->is_demo) {
                $user->forceFill(['is_demo' => 1])->save();
            }
            if ($d['role'] === 'admin') {
                $admin = $user;
            }
        }

        return $admin;
    }

    private function seedTypes(): array
    {
        $defs = [
            ['name' => 'Potable Water', 'title' => 'CERTIFICATE OF ANALYSIS', 'params' => [
                ['name' => 'pH', 'unit' => '', 'specification' => '6.5 - 8.5', 'price' => 150],
                ['name' => 'Total Hardness (TH)', 'unit' => 'mg/l', 'specification' => '200 Max', 'price' => 200],
                ['name' => 'Total Suspended Solids (TSS)', 'unit' => 'mg/l', 'specification' => '-', 'price' => 150],
                ['name' => 'Total Dissolved Solids (TDS)', 'unit' => 'mg/l', 'specification' => '500 Max', 'price' => 180],
                ['name' => 'Turbidity', 'unit' => 'NTU', 'specification' => '1 Max', 'price' => 120],
            ]],
            ['name' => 'Edible Oil', 'title' => 'CERTIFICATE OF ANALYSIS', 'params' => [
                ['name' => 'Free Fatty Acids', 'unit' => '%', 'specification' => '0.50 % Max', 'price' => 250],
                ['name' => 'Moisture Value', 'unit' => '%', 'specification' => '0.20 % Max', 'price' => 200],
                ['name' => 'Iodine Value', 'unit' => '', 'specification' => '80 To 100', 'price' => 220],
                ['name' => 'Specific Gravity', 'unit' => '', 'specification' => '0.910 To 0.920', 'price' => 180],
                ['name' => 'Peroxide Value', 'unit' => '', 'specification' => '10 Max', 'price' => 200],
                ['name' => 'Rancidity', 'unit' => '', 'specification' => 'Negative', 'price' => 100],
            ]],
            ['name' => 'Cattle Feed', 'title' => 'ANALYSIS REPORT', 'params' => [
                ['name' => 'Oil Content (OC)', 'unit' => '%', 'specification' => '-', 'price' => 200],
                ['name' => 'Free Fatty Acid (FFA)', 'unit' => '%', 'specification' => '-', 'price' => 200],
                ['name' => 'Total Ash', 'unit' => '%', 'specification' => '-', 'price' => 150],
                ['name' => 'Fiber', 'unit' => '%', 'specification' => '-', 'price' => 150],
                ['name' => 'Protein', 'unit' => '%', 'specification' => '-', 'price' => 250],
                ['name' => 'Moisture', 'unit' => '%', 'specification' => '-', 'price' => 120],
                ['name' => 'Rancidity', 'unit' => '', 'specification' => 'Negative', 'price' => 100],
            ]],
        ];

        $out = [];
        foreach ($defs as $d) {
            $rt = ReportType::query()->where('is_demo', 1)->where('name', $d['name'])->first()
                ?? ReportType::create([
                    'name' => $d['name'],
                    'title' => $d['title'],
                    'active' => true,
                    'is_demo' => 1,
                ]);

            foreach ($d['params'] as $i => $p) {
                Parameter::query()->firstOrCreate(
                    ['report_type_id' => $rt->id, 'name' => $p['name']],
                    array_merge($p, ['display_order' => $i + 1, 'active' => true, 'is_demo' => 1])
                );
            }

            $out[$d['name']] = $rt;
        }

        return $out;
    }

    private function seedGroup(): CustomerGroup
    {
        return CustomerGroup::query()->where('is_demo', 1)->where('name', 'Demo Traders')->first()
            ?? CustomerGroup::create(['name' => 'Demo Traders', 'is_demo' => 1]);
    }

    private function seedCustomers(CustomerGroup $group): array
    {
        $defs = [
            ['name' => 'Ravi Traders', 'company_name' => 'Ravi Agro Products', 'contact_person' => 'Ravi Kumar',
             'phone' => '+91 98765 41001', 'email' => 'ravi@demotraders.in', 'city' => 'Erode',
             'state' => 'Tamil Nadu', 'gstin' => '33ABCDE1234F1Z5', 'address' => '12, Market Road, Erode - 638001'],
            ['name' => 'Sri Lakshmi Foods', 'company_name' => 'Sri Lakshmi Foods Pvt Ltd', 'contact_person' => 'Lakshmi Devi',
             'phone' => '+91 98765 41002', 'email' => 'orders@slfoods.demo', 'city' => 'Coimbatore',
             'state' => 'Tamil Nadu', 'gstin' => '33AAACB5678G1ZP', 'address' => '44, Trichy Road, Coimbatore - 641018'],
            ['name' => 'Green Valley Farms', 'company_name' => 'Green Valley Farms', 'contact_person' => 'Mani Rajan',
             'phone' => '+91 98765 41003', 'email' => 'mani@greenvalley.demo', 'city' => 'Karur',
             'state' => 'Tamil Nadu', 'gstin' => '33AFGPQ9012H1ZK', 'address' => 'Plot 7, Dairy Colony, Karur - 639001'],
            ['name' => 'Anand Mills', 'company_name' => 'Anand Spinning Mills', 'contact_person' => 'S. Anand',
             'phone' => '+91 98765 41004', 'email' => 'purchase@anandmills.demo', 'city' => 'Tiruppur',
             'state' => 'Tamil Nadu', 'gstin' => '33AACCA3456J1ZQ', 'address' => 'SIDCO Industrial Estate, Tiruppur - 641604'],
            ['name' => 'Kumar Oil Industries', 'company_name' => 'Kumar Oil Industries', 'contact_person' => 'V. Kumar',
             'phone' => '+91 98765 41005', 'email' => 'kumar@oilindustries.demo', 'city' => 'Madurai',
             'state' => 'Tamil Nadu', 'gstin' => '33AADFK7890L1ZR', 'address' => '8, Oil Mill Lane, Madurai - 625009'],
            ['name' => 'VetCare Feeds', 'company_name' => 'VetCare Animal Nutrition', 'contact_person' => 'Dr. Priya N',
             'phone' => '+91 98765 41006', 'email' => 'priya@vetcare.demo', 'city' => 'Salem',
             'state' => 'Tamil Nadu', 'gstin' => '33AAECV2234M1ZT', 'address' => '3, Factory Road, Salem - 636009'],
        ];

        $out = [];
        foreach ($defs as $d) {
            $c = Customer::query()->where('is_demo', 1)->where('name', $d['name'])->first()
                ?? Customer::create(array_merge($d, [
                    'group_id' => $group->id,
                    'is_active' => true,
                    'is_demo' => 1,
                ]));
            $out[$d['name']] = $c;
        }

        return $out;
    }

    private function seedReports(User $admin, array $types, array $customers): void
    {
        // no, type, customer, days ago, sample, status, invoice status, gst on
        $defs = [
            ['DEM-0001', 'Potable Water', 'Ravi Traders', 0, 'Ground Water - Borewell', 'completed', 'paid', true],
            ['DEM-0002', 'Potable Water', 'Green Valley Farms', 0, 'Potable Water Supply', 'completed', 'unpaid', false],
            ['DEM-0003', 'Edible Oil', 'Kumar Oil Industries', 3, 'Crude Palm Oil', 'completed', 'paid', true],
            ['DEM-0004', 'Potable Water', 'Anand Mills', 6, 'Effluent Water', 'completed', 'unpaid', false],
            ['DEM-0005', 'Cattle Feed', 'VetCare Feeds', 9, 'Cattle Feed - Layer', 'completed', 'partial', true],
            ['DEM-0006', 'Edible Oil', 'Sri Lakshmi Foods', 14, 'Refined Sunflower Oil', 'completed', 'paid', true],
            ['DEM-0007', 'Potable Water', 'Ravi Traders', 20, 'Treated Water', 'completed', 'unpaid', false],
            ['DEM-0008', 'Cattle Feed', 'VetCare Feeds', 25, 'Broiler Starter Feed', 'draft', 'unpaid', false],
        ];

        $invoiceSeq = 0;
        foreach ($defs as $i => $row) {
            [$no, $typeKey, $custKey, $daysAgo, $sampleName, $status, $invoiceStatus, $gstOn] = $row;

            $type = $types[$typeKey];
            $cust = $customers[$custKey];
            $date = now()->subDays($daysAgo);

            $report = Report::query()->where('report_no', $no)->first();
            if ($report) {
                continue;
            }

            $report = Report::create([
                'report_no' => $no,
                'report_type_id' => $type->id,
                'customer_id' => $cust->id,
                'sample_date' => $date->toDateString(),
                'coa_date' => $date->copy()->addDay()->toDateString(),
                'party_name' => $cust->company_name ?? $cust->name,
                'customer_name' => $cust->name,
                'sample_name' => $sampleName,
                'nature_of_sample' => $typeKey,
                'vehicle_no' => 'TN38 BX ' . (4500 + $i * 7),
                'bill_no' => 'BILL-DEMO-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'bags_tons' => (10 + $i * 3) . ' Bags / ' . (2 + $i) . ' Tons',
                'buyer' => $cust->company_name ?? $cust->name,
                'seller' => 'KRISHI ANALYTICAL LAB',
                'remarks' => 'Seeded demonstration data',
                'status' => $status,
                'created_by' => $admin->id,
                'is_demo' => 1,
            ]);
            $report->forceFill(['created_at' => $date, 'updated_at' => $date])->save();

            foreach ($type->parameters->values() as $pi => $param) {
                ReportResult::create([
                    'report_id' => $report->id,
                    'parameter_id' => $param->id,
                    'result' => $this->resultValues[$param->name] ?? '12.5',
                    'specification' => $param->specification,
                    'display_order' => $pi + 1,
                    'enabled' => true,
                ]);
            }

            if ($status !== 'completed') {
                continue;
            }

            $invoiceSeq++;
            $invoice = Invoice::create([
                'report_id' => $report->id,
                'invoice_no' => 'DEM-INV-' . str_pad($invoiceSeq, 4, '0', STR_PAD_LEFT),
                'party_name' => $cust->company_name ?? $cust->name,
                'customer_name' => $cust->name,
                'subtotal' => 0,
                'gst_percent' => 18,
                'gst_amount' => 0,
                'total_amount' => 0,
                'gst_enabled' => $gstOn,
                'status' => $invoiceStatus,
                'is_demo' => 1,
            ]);
            $invoice->syncItems($report);
            $invoice->recalcTotals();
            $invoice->forceFill(['created_at' => $date, 'updated_at' => $date])->save();
        }
    }
}
