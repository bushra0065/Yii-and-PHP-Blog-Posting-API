<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 * @property string $verification_token
 * @property string $verified
 */
class User extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return static the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password', 'required'),
			array('verified', 'numerical', 'integerOnly'=>true),
			array('username, email, password, verification_token', 'length', 'max'=>255),
            array('username', 'unique', 'message' => 'This username is already taken.'),
            array('email', 'email'),
            array('email', 'unique', 'message' => 'This email address is already taken.'),
            array('password', 'length', 'min'=>3),
            array('profile', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, password, verification_token, verified', 'safe', 'on'=>'search'),
		);
	}

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'profile' => 'Profile',
            'verified'=>'Is verified'
        );
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     * @throws CException
     */
    public function validatePassword($password)
    {
        return CPasswordHelper::verifyPassword($password,$this->password);
    }

    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     * @throws CException
     */
    public function hashPassword($password)
    {
        return CPasswordHelper::hashPassword($password);
    }
    public function generateVerificationToken()
    {
        $this->verification_token = sha1(uniqid($this->email, true));
        $this->save(false); // Save without validation to avoid potential issues
    }

    public function verifyEmail($token)
    {
        $user = self::model()->findByAttributes(array('verification_token' => $token));
        if ($user) {
            $user->verification_token = null; // Clear the token
            return $user->save(false); // Save without validation
        }
        return false;
    }

}
