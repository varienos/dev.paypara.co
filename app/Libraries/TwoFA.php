<?php

    namespace App\Libraries;

    // 2FA NAMESPACE
    use RobThree\Auth\TwoFactorAuth;

    class TwoFA
    {
        function __construct()
        {
            $this->tfa    = new TwoFactorAuth();
        }

        public function createSecret()
        {
            return $this->tfa->createSecret();
        }

        public function getQRCodeImageAsDataUri($secret)
        {
            // SOURCE: https://robthree.github.io/TwoFactorAuth/qr-codes.html
            return $this->tfa->getQRCodeImageAsDataUri(env('2FA_APP_TITLE'), $secret);
        }

        public function verifyCode($secret, $verification)
        {
            // SOURCE: https://robthree.github.io/TwoFactorAuth/improved-code-verification.html
            return $this->tfa->verifyCode($secret, $verification);
        }

        public function getCode($code)
        {
            // SOURCE: https://github.com/RobThree/TwoFactorAuth/blob/master/demo/demo.php
            return $this->tfa->getCode($code);
        }

        public function ensureCorrectTime()
        {
            try {
                $this->tfa->ensureCorrectTime();
                return 'Unauthorized';
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }



    }