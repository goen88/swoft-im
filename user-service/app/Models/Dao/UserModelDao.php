<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/15 0015
 * Time: 下午 12:40
 */

namespace App\Models\Dao;


use App\Models\Entity\User;
use ServiceComponents\Common\Message;
use Swoft\Bean\Annotation\Bean;

/**
 * Class UserDao
 * @package App\Models\Dao
 * @Bean()
 */
class UserModelDao
{
    public function getUser($where,$single = false)
    {
        if($single)
            return User::findOne($where)->getResult();
        return User::findAll($where)->getResult();
    }
    public function newUser($data)
    {
        $user = new User();
        $result = $user->fill($data)->save()->getResult();
        return $result;
    }
    public function updateByWhere($attr , $condition,$single = true)
    {
        if($single)
            return User::updateOne($attr, $condition)->getResult();
        return User::updateAll($attr,$condition)->getResult();

    }
    public function updateUser($id,$data)
    {
        return User::updateOne($data, ['id' => $id])->getResult();
    }
    public function getUserByNumbers($numbers)
    {
        $data = [];
        foreach ($numbers as $k => $v)
        {
            $data[] = User::findOne(['number' => $v])->getResult();
        }
        return $data;
    }
    public function getNumberById($id)
    {
        $user = User::findById($id)->getResult();
        return $user['number'];
    }
    public function getUserById($id)
    {
        return User::findById($id)->getResult();
    }
    public function getAllUser()
    {
        return User::findAll()->getResult();
    }
    public function searchUser($value , $page = null)
    {
        if(!$value)
            return User::findAll()->getResult();
        return User::query()
            ->orWhere('number','like','%'.$value.'%')
            ->orWhere('nickname','like','%'.$value.'%')
            ->orWhere('phone','like','%'.$value.'%')
            ->orWhere('email','like','%'.$value.'%')
            ->get()->getResult();
    }
}