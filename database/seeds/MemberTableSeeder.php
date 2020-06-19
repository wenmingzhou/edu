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
        //
        //生成faker实例
        $faker = \Faker\Factory::create('zh_CN');
        $data  = [];
        for ($i = 0; $i < 500; $i++) {
            $data[] = [
                'username' => $faker->userName,             //生成用户名
                'password' => bcrypt('password'),    //生成密码
                'gender' => rand(1, 3),                     //性别随机
                'mobile' => $faker->phoneNumber,            //生成手机号
                'email' => $faker->email,
                'avatar' => '/statics/avatar.jpg',          //头像
                'created_at' => date('Y-m-d H:i:s'), //创建时间
                'type' => rand(1, 2),
                'status' => rand(1, 2),
            ];
        }
        //写入数据表
        DB::table('member')->insert($data);
    }
}
