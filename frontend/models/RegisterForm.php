<?php
namespace frontend\models;

use yii\base\Model;
use common\models\SpUser;

/**
 * Register form
 */
class RegisterForm extends Model
{
	public $name;
	public $email;
	public $sex;
	public $password;
	public $_csrf;

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\common\models\SpUser', 'message' => 'This username has already been taken.'],
            ['name', 'string', 'min' => 2, 'max' => 30],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 50],
            ['email', 'unique', 'targetClass' => '\common\models\SpUser', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function load($arr, $formName = NULL)
    {
    	if (count($arr) < 1) {
    		return false;
    	}

    	foreach ($arr as $key => $value) {
    		if (property_exists($this, $key)) {
    			$this->$key = $value;
    		}
    	}

    	return true;

    }

    /**
     * Register.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            exit(json_encode($this->errors));
        }

        $user = new SpUser();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->sex = $this->sex;
        $user->setPassword($this->password);
        
        return $user->save() ? $user : null;
    }

}