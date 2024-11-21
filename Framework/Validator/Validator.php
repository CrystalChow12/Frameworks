<?php

namespace Framework\Validator;

class Validator {
	public static array $errors = [];
	public static array $messages = [];

	public static function isEmpty(string $field) {
		if (empty($field)) {
			self::$errors['empty_fields'] = 'Please enter all fields.';
			return true;
		}
	}

	// public static function isEmpty(string $email, string $username, string $password, string $role) {
	// 	//check if any of the fields are empty
	// 	if ($email === '' || $username === '' || $password === '' || $role === '') {
	// 		self::$errors['empty_fields'] = 'Please enter all fields.';
	// 		return true;
	// 	}
	// }

	public static function validEmail(string $email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			self::$errors['email_format'] = 'Please enter a valid email address.';
			return false;
		}

		return true;
	}

	public static function validUsername(string $username) {
		//check that it matches the pattern of first.lastname
		if (!preg_match('/^[a-zA-Z]+\.[a-zA-Z]+\d*$/', $username)) {
			self::$errors['username_format'] = 'Username must be in the format of first.lastname';
			return false;
		}

		return true;
	}

	public static function validPassword(string $password) {
		//check the length
		if (strlen($password) < 10) {
			self::$errors['password_length'] = 'Password must be at least 10 characters long.';
			return false;
		}

		//if it has uppercase, lowercase, numbers and symbols
		if (!preg_match('/[A-Za-z0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
			self::$errors['password_format'] =
				'Password must contain at least one uppercase letter, one lowercase letter, one number and one symbol.';
			return false;
		}

		$entropyBits = 0;
		$extraBits = 0;

		// Password12!
		for ($i = 0; $i < strlen($password); $i++) {
			if ($i === 0) {
				$entropyBits += 4;
			}

			if ($i >= 1 && $i <= 8) {
				$entropyBits += 2;
			}

			if ($i >= 9 && $i <= 12) {
				$entropyBits += 3;
			}

			if ($i >= 13) {
				$entropyBits += 1;
			}

			if (ctype_upper($password[$i])) {
				$extraBits += 1;
			}

			if (!ctype_alnum($password[$i])) {
				$extraBits += 1;
			}
		}

		if ($extraBits > 6) {
			$extraBits = 6;
		}

		$entropyBits += $extraBits;

		//echo $entropyBits . ' ' . $extraBits;
		if ($entropyBits < 18) {
			self::$errors['password_format'] = 'Password not strong enough.';
			return false;
		}

		return true;
	}

	public static function isNumber(string $text) {
		//check if the text is a number
		if (is_numeric($text)) {
			self::$errors['number'] = 'Please enter text that is not a number.';
			return false;
		}

		return true;
	}

	// public static function validDate(string $date) {
	// 	//split date into year, month, and day
	// 	$split_date = explode('-', $date);
	// 	$y = (int) $split_date[0];
	// 	$m = (int) $split_date[1];
	// 	$d = (int) $split_date[2];

	// 	if (!checkdate($m, $d, $y)) {
	// 		self::$errors['date_format'] = 'Please enter a valid date.';
	// 		return false;
	// 	}
	// 	return true;
	// }

	public static function addError(string $key, string $message) {
		Validator::$errors[$key] = $message;
	}


	public static function getErrors() {
		return Validator::$errors;
	}

	//clear errors after use
	public static function clearErrors() {
		Validator::$errors = [];
	}


	//do the same thing for messages 
	public static function addMessage(string $key, string $message) {
		Validator::$messages[$key] = $message;
	}

	public static function getMessages() {
		return Validator::$messages;
	}

	//clear messages after use
	public static function clearMessages() {
		Validator::$messages = [];
	}
}
