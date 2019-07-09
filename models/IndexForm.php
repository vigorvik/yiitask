<?php

namespace app\models;

use yii\base\Model;

class IndexForm extends Model
{
    public $surname;
    public $name;
    public $email;
    public $password;
    public $confirmation;
    
    private $_user = false;
    
    public function rules()
    {
        return [
			['name', 'required', 'message' => 'Поле "Имя" не должно быть пустым.'],
			['surname', 'required', 'message' => 'Поле "Фамилия" не должно быть пустым.'],
			['email', 'required', 'message' => 'Поле "E-mail" не должно быть пустым.'],
            ['email', 'email', 'message' => 'Некорректно введен адрес электронной почты.'],
			['password', 'required', 'message' => 'Поле "Пароль" не должно быть пустым.'],
			['confirmation', 'required', 'message' => 'Поле "Подтверждение пароля" не должно быть пустым.'],
			['confirmation', 'compare', 'compareAttribute' => 'password', 'message' => "Введенные пароли не совпадают"],
            // password is validated by validatePassword()
           // ['password', 'validatePassword'],
            // built-in "compare" validator that is used in "register" scenario only
            
            
        ];
    }
}
