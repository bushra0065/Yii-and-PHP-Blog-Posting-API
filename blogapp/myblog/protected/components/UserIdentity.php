<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     * @throws CException
     */

    public function authenticate()
    {
        // Check if the username exists in the database
        $user = User::model()->findByAttributes(array('username' => $this->username));

        if ($user === null) {
            // Username not found
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$user->validatePassword($this->password)) {
            // Password does not match
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            // Authentication successful
            $this->errorCode = self::ERROR_NONE;

            // Set session variables
            Yii::app()->user->setId($user->id); // Set user ID
            Yii::app()->user->setState('username', $user->username); // Set username
            // Optionally, you can set more session states as needed
            Yii::app()->user->setState('id', $user->id);
            Yii::app()->user->setState('verified', $user->verified);


        }

        return !$this->errorCode;
    }

}