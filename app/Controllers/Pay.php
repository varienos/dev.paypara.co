<?php

namespace App\Controllers;

class Pay extends BaseController
{
    public function __construct()
    {
        $this->pay = new \App\Models\PayModel();
    }

    public function index($token)
    {
        $data = $this->pay->newIframe($token);

        if ($data['maintenance']) {
            $view = 'pay/partials/misc/_maintenance.php';
        } elseif ($data['pending']) {
            $view = 'pay/partials/misc/_pending-transaction.php';
        } elseif ($data['error']) {
            $view = 'pay/partials/misc/_error.php';
        } elseif (!$data['depositPerm']) {
            $view = 'pay/partials/misc/_user-disabled.php';
        } else {
            $view = 'pay/partials/_onboarding.php';
        }

        $data['content'] = view($view, $data);

        return htmlMinify(view('pay/iframe', $data));
    }

    public function frame()
    {
        $currentStep = $this->request->getVar('step');

        if($currentStep == "onboarding") {
            $amount = $this->request->getVar('amount');
            $hasCard = $this->request->getVar('hasCard');

            return $this->getCrossFrame(array('amount' => $amount));
        };

        if($currentStep == "cross") {
            $data = $this->getBankAccount();
            $payment = $this->request->getVar('payment');

            return $this->getBankFrame($data);
        };

        if($currentStep == "bank") {
            $data = $this->getPaparaAccount();
            return $this->getPaparaFrame($data);
        };

        return json_encode(array($step, $amount, $hasCard));
    }

    public function getBankAccount()
    {
        return []; // TODO
    }

    public function getPaparaAccount()
    {
        return []; // TODO
    }

    public function getBankFrame($data)
    {
        return htmlMinify(view('pay/partials/methods/_bank.php', $data));
    }

    public function getPaparaFrame($data)
    {
        return htmlMinify(view('pay/partials/methods/_papara.php', $data));
    }

    public function getCrossFrame($data)
    {
        return htmlMinify(view('pay/partials/methods/_cross.php', $data));
    }

    public function getPosFrame($data)
    {
        return htmlMinify(view('pay/partials/methods/_pos.php', $data));
    }
}