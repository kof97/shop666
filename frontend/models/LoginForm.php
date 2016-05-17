<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\SpUser;

/**
 * Signup form
 */
class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user;
    private $_csrf;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 50],

            // password is validated by validatePassword()
            ['password', 'required'],            
            ['password', 'string', 'min' => 6],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        [
            'username' => 'email',
            'password' => '密码',
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
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            exit(json_encode($this->errors));
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = SpUser::findByEmail($this->email);
        }

        return $this->_user;
    }
}
