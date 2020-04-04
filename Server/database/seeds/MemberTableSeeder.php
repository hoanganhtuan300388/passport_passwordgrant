<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert([
            'username'      => 'hoanganhtuan_300388',
            'password'      => bcrypt('123@123Aa'),
            'name'          => 'Hoàng Anh Tuấn',
            'avatar'        => '',
            'city'          => 'Hà Nội',
            'country'       => 'Việt Nam',
            'birthday'      => date('Y-m-d', strtotime('1988/03/30')),
            'gender'        => 'male',
            'status'        => 'active',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('member_contacts')->insert([
            'member_id'     => 1,
            'email'         => 'hoanganhtuan.30388@gmail.com',
            'mobile_phone'  => '84948305166',
            'home_phone'    => '',
            'office_phone'  => '',
            'address1'      => '',
            'address2'      => '',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('member_settings')->insert([
            'member_id'         => 1,
            'display_location'  => 1,
            'display_contact'   => 1,
            'offline_email'     => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s')
        ]);
    }
}
