<?php
/**
 * This class has a list of error messages for form upload data
 *
 * Created by PhpStorm.
 * User: tharwat
 * Date: 3/9/2019
 * Time: 02:21
 */
namespace phpchassis\form;

/**
 * Class FormErrorMsg
 * @package phpchassis-ddd\form
 */
class FormErrorMsg {

    /**
     * First Name Characters Error mesage
     *
     * @var string $fNameMsg
     */
    public static $fNameCharsMsg = "Your first name must be between 2 and 25 characters";

    /**
     * Last Name Characters Error mesage
     *
     * @var string $lNameChars
     */
    public static $lNameCharsMsg = "Your last name must be between 2 and 25 characters";

    /**
     * Username Characters Error message
     *
     * @var string $usernameChars
     */
    public static $usernameChars = "Your username must be between 5 and 25 characters";

    /**
     * Username Taken Error message
     *
     * @var string $usernameTaken
     */
    public static $usernameTaken = "This username already exists";

    /**
     * Emails do not match Error message
     *
     * @var string $emailsDoNotMatch
     */
    public static $emailsDoNotMatch = "Your emails do not match";

    /**
     * Email invalid Error message
     *
     * @var string $emailInvalid
     */
    public static $emailInvalid = "Please enter a valid email address";

    /**
     * Email taken Error message
     *
     * @var string $emailTaken
     */
    public static $emailTaken = "This email is already in use";

    /**
     * Passwords do not match Error message
     *
     * @var string $passwordsDoNotMatch
     */
    public static $passwordsDoNotMatch = "Your passwords do not match";

    /**
     * Password Not Alphanumeric Error message
     *
     * @var string $passwordNotAlphanumeric
     */
    public static $passwordNotAlphanumeric = "Your password can only contain letters and numbers";

    /**
     * Password Length Error message
     *
     * @var string $passwordLength
     */
    public static $passwordLength = "Your password must be between 5 and 30 characters";

    /**
     * Login failed Error message
     *
     * @var string $loginFailed
     */
    public static $loginFailed = "Your username or password was incorrect";
}