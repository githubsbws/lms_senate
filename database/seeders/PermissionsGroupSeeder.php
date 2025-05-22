<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionGroup;

class PermissionsGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $permissions = [
            ['key' => 'admin', 'label_th' => 'หน้าแรก', 'group_name' => null, 'sort_order' => 1],
            ['key' => 'dashboard', 'label_th' => 'ภาพรวมเว็บไซต์', 'group_name' => null, 'sort_order' => 2],
            ['key' => 'document_request', 'label_th' => 'คำขอเอกสาร', 'group_name' => null, 'sort_order' => 3],
            ['key' => 'setting', 'label_th' => 'จัดการเมนู', 'group_name' => null, 'sort_order' => 4],

            // จัดการเอกสาร
            ['key' => 'document', 'label_th' => 'เอกสาร', 'group_name' => 'จัดการเอกสาร', 'sort_order' => 1],
            ['key' => 'document_file', 'label_th' => 'แก้เอกสาร', 'group_name' => 'จัดการเอกสาร', 'sort_order' => 2],
            ['key' => 'document_import', 'label_th' => 'นำเข้าเอกสาร', 'group_name' => 'จัดการเอกสาร', 'sort_order' => 3],
            ['key' => 'document_period', 'label_th' => 'เอกสารสมัยประชุม', 'group_name' => 'จัดการเอกสาร', 'sort_order' => 4],
            ['key' => 'document_type', 'label_th' => 'ประเภทเอกสาร', 'group_name' => 'จัดการเอกสาร', 'sort_order' => 5],

            // จัดการบัญชีผู้ใช้งาน
            ['key' => 'permission_type', 'label_th' => 'สิทธิ์ผู้ดูแล', 'group_name' => 'จัดการบัญชีผู้ใช้งาน', 'sort_order' => 1],
            ['key' => 'permission', 'label_th' => 'กำหนดสิทธิ์ผู้ดูแล', 'group_name' => 'จัดการบัญชีผู้ใช้งาน', 'sort_order' => 2],

            // จัดการแบบสำรวจ
            ['key' => 'survey', 'label_th' => 'แบบสำรวจความพึงพอใจ', 'group_name' => 'จัดการแบบสำรวจ', 'sort_order' => 1],

            // รายงาน
            ['key' => 'request', 'label_th' => 'รายงานผู้ขอรับเอกสาร', 'group_name' => 'รายงาน', 'sort_order' => 1],
            ['key' => 'approved', 'label_th' => 'รายงานการอนุมัติเอกสาร', 'group_name' => 'รายงาน', 'sort_order' => 2],
        ];

        foreach ($permissions as $permission) {
            PermissionGroup::updateOrCreate(
                ['key' => $permission['key']],
                $permission
            );
        }
    }
}
