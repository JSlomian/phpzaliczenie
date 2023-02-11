<?php

namespace Apsl\Inf\Zaliczenie\Service;

final class FormValidator
{
    public function validatePassword(string $password, string $repeatPassword, array &$errors): bool
    {
        $password = trim($password);
        $repeatPassword = trim($repeatPassword);
        if ($password !== $repeatPassword) {
            $errors[] = 'Hasła nie są jednakowe.';
            return false;
        }
        if ($password == '') {
            $errors[] = 'Hasło jest puste.';
            return false;
        }
        if (preg_match('/[A-Z]/', $password) !== 1) {
            $errors[] = 'Hasło nie zawiera dużych liter';
        }
        if (preg_match('/[a-z]/', $password) !== 1) {
            $errors[] = 'Hasło nie zawiera małych liter.';
        }
        if (preg_match('/[0-9]/', $password) !== 1) {
            $errors[] = 'Hasło nie zawiera liczb.';
        }
        if (preg_match('/[^\w]/', $password !== 1)) {
            $errors[] = 'Hasło nie zawiera znaków specjalnych';
        }
        if (preg_match('/(.*?).{7,}/', $password !== 1)) {
            $errors[] = 'Hasło jest krótsze niż 8 znaków';
        }
        if (empty($errors)) {
            return true;
        }
        return false;
    }

    public function validateEmail(string $email, array &$errors): bool
    {
        $email = trim($email);
        if ($email === '') {
            $errors[] = 'Pole email jest puste.';
        } elseif (filter_var($email, filter: FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Zły format podanego emaila';
        }
        if (empty($errors)) {
            return true;
        }
        return false;
    }
}