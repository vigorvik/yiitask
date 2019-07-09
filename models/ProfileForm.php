<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ProfileForm extends Model
{
    public $surname;
    public $name;
    public $email;
    
    public function rules()
    {
        return [
			['name', 'required', 'message' => 'Поле "Имя" не должно быть пустым.'],
			['surname', 'required', 'message' => 'Поле "Фамилия" не должно быть пустым.'],
			['email', 'required', 'message' => 'Поле "E-mail" не должно быть пустым.'],
            ['email', 'email', 'message' => 'Некорректно введен адрес электронной почты.'],
        ];
    }
    
    public function updateUser()
    {
        $user = User::findOne(['email' => $this->email]);
        $user->surname = $this->surname;
        $user->name = $this->name;
        $user->save();
    }
    
    public function updateSession()
    {
        $session = Yii::$app->session;
        $session['surname'] = $this->surname;
        $session['name'] = $this->name;
		$session['email'] = $this->email;
    }
    
    public function deleteUser()
    {
        $user = User::findOne(['email' => $this->email]);
        $user->delete();
    }
}