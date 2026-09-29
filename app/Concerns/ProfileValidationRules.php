<?php

namespace App\Concerns;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ProfileValidationRules
{
    //สำหรับตรวจสอบข้อมูล Profile ของ User
    // $userId เป็น string เพราะ user_id ของเราเป็น CHAR(10)
    // ถ้าไม่ได้ส่ง userId มา จะมีค่าเป็น null
    protected function profileRules(?string $userId = null): array
    {
        return [
            'name' => $this->nameRules(),
            'email' => $this->emailRules($userId),
        ];
    }

    // กำหนดกฎตรวจสอบชื่อ
    protected function nameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    protected function emailRules(?string $userId = null): array
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            // ถ้ายังไม่มี userId แสดงว่าเป็นการสมัครสมาชิกใหม่
            $userId === null
                ? Rule::unique(User::class)
                // ถ้ามี userId แสดงว่าเป็นการแก้ไขข้อมูลของ User เดิม
                // ให้ตรวจ Email ซ้ำ แต่ไม่นับ User คนปัจจุบัน
                : Rule::unique(User::class)->ignore($userId),
        ];
    }
}