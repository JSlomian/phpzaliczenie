<?php

namespace Apsl\Inf\Zaliczenie\Controller;

use Apsl\Controller\BasePage;
use Apsl\Http\Request;
use Apsl\Inf\Zaliczenie\Service\FormValidator;
use Apsl\Inf\Zaliczenie\Service\MailService;
use Apsl\Session\Session;
use Symfony\Component\Mailer\Mailer;

final class ResetPasswordController extends BasePage
{
    private const HASH = 'hash';
    private const EMAIL = "apsl-dev@gmx.com";

    public function __construct(
        protected Request              $request = new Request(),
        private readonly Session       $session = new Session(),
        private readonly FormValidator $formValidator = new FormValidator(),
        private readonly MailService   $mailService = new MailService()
    )
    {
        parent::__construct($this->request);
    }

    public function doHandle(): void
    {
        $body = [
            'errors' => [],
            'form' => ['email' => ''],

        ];
        if ($this->request->isMethod(REQUEST::METHOD_POST)) {
            $email = $this->request->getPostValue('email');
            $body['form']['email'] = $email;
            if ($this->formValidator->validateEmail($email, $body['errors'])) {
                $generatedHash = sha1(time());
                $this->session->setValue(self::HASH, $generatedHash);
                $link = $this->request->getRouteUrl(NewPasswordController::class, true)
                    . "?"
                    . self::HASH
                    . "="
                    . $generatedHash;
                $emailMessage = "Link do zresetowania hasła: <a href=\"//$link\">$link</a>";
                $body['message'] = "sprawdź e-mail w celu zresetowania hasła";
                $this->mailService->sendEmail($email, $emailMessage, $errors);
            }
        }
        $this->response->setBody($this->useTemplate('templates/reset_password.html.php', ['body' => $body]));
    }
}