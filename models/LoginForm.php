<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
			
			if(!$user)
			{
			$this->addError('username', 'Incorrect Email');	
			}
			else
			{
			if($user->is_active == 0)
			{
				
			$this->addError('password', 'User is Inactive. Please contact administrator.');	
			}
			
			elseif($user->is_deleted == 1)
			{
			
				$this->addError('password', 'User does not exists');
			}
			elseif($user->is_verified == 0)
			{
					
				$this->addError('password', 'Please verify your email');
			}
			
			
            elseif (!$user->validatePassword($this->password)) {
				

			$this->addError('password', 'Incorrect password');
				
            }
		}
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {	
    	
        if ($this->validate()) {
        	
        	$session = \Yii::$app->session;
        	$session['logged_username'] = $this->getUser()->attributes['useremail'];
        	$session['logged_usertype']= $this->getUser()->attributes['usertype'];
        	$session['logged_id']= $this->getUser()->attributes['user_id'];
        	$session->set('logged_status', true);
        	
        	if($session['logged_usertype'] == 1)
        	{
        	$permissions = \Yii::$app->Permission->getloggeduserpermission($session['logged_id']);
        	$session['logged_permissions']=$permissions;
        	}
        	
            return true;
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = TblAcaUsers::findByUsername($this->username);
        }
        return $this->_user;
    }
    
    
}
