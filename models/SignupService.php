<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\IndexForm;
use app\models\ProfileForm;

class SignupService
{
    
    public function signup(IndexForm $form)
    {
        $user = new User();
        $user->name = $form->name;
        $user->surname = $form->surname;
        $user->email = $form->email;
        $user->setPassword($form->password);
        $user->generateAuthKey();
        $user->status = User::STATUS_WAIT;
        $user->save();
        if(!$user->save()){
            throw new \RuntimeException('Saving error.');
        }
        
        return $user;
    }
    
    public function sendMail(User $user) {
        // Set layout params
        \Yii::$app->mailer->getView()->params['userName'] = $user->name;
        \Yii::$app->mailer->getView()->params['authKey'] = $user->auth_key;
        
        $result = \Yii::$app->mailer->compose([
            'html' => 'views/email-html',
            'text' => 'views/email-text',
        ])->setTo([$user->email => $user->name])
        ->setSubject('Подтверждение регистрации')
        ->send();
        
        if (!$result) {
            throw new \RuntimeException('Sending error.');
        }
        
        // Reset layout params
        \Yii::$app->mailer->getView()->params['userName'] = null;
        
        return $result;
    }
    
    
    public function confirmation($token)
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }
        
        $user = User::findOne(['auth_key' => $token]);
        if (!$user) {
            throw new \DomainException('User is not found.');
        }
        
        $user->auth_key = null;
        $user->status = User::STATUS_ACTIVE;
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
        $profile = new ProfileForm;
        $profile->name = $user->name;
        $profile->surname = $user->surname;
        $profile->email = $user->email;
        $session = Yii::$app->session;
        $session['name'] = $user->name;
        $session['surname'] = $user->surname;
        $session['email'] = $user->email;
        $session['status'] = $user->status;
        return $profile;
    }
    
    public function initFromSession()
    {
        $session = Yii::$app->session;
        $profile = new ProfileForm;
        $profile->name = $session['name'];
        $profile->surname = $session['surname'];
        $profile->email = $session['email'];
        return $profile;
    }
    
}