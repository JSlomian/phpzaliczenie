<?php

namespace Apsl\Inf\Zaliczenie\Controller;

use Apsl\Controller\BasePage;
use Apsl\Http\Request;
use Apsl\Inf\Zaliczenie\Service\FormValidator;
use Apsl\Inf\Zaliczenie\Service\MailService;
use Apsl\Session\Session;
use Symfony\Component\Mailer\Mailer;

final class NewPasswordController extends BasePage
{
    private const HASH = 'hash';

    public function __construct(
        protected Request              $request = new Request(),
        private readonly Session       $session = new Session(),
        private readonly FormValidator $formValidator = new FormValidator()
    )
    {
        parent::__construct($this->request);
    }

    protected function doHandle(): void
    {
        $body = [
            'errors' => []
        ];
        if ($this->request->isMethod(REQUEST::METHOD_POST)) {
            $password1 = $this->request->getPostValue('password1');
            $password2 = $this->request->getPostValue('password2');
            $body['form']['password1'] = $password1;
            $body['form']['password2'] = $password2;
            if ($this->formValidator->validatePassword($password1, $password2, $body['errors'])) {
                $this->response->redirect($this->request->getCurrentUri(withQueryString: false) . '?success=true');
            }
        }
        if (!$this->request->getQueryStringValue('success')) {
            $hash = $this->request->getQueryStringValue(self::HASH);
            $sessionHash = $this->session->getValue(self::HASH);
            if ($hash == null) {
                $body['errors'][] = 'Brak hasha';
            }
            if ($sessionHash == null) {
                $body['errors'][] = 'Braka hasha w sesji';
            }
            if ($hash != $sessionHash) {
                $body['errors'][] = "Hash nie jest poprawny";
            } else {
                $body['form']['show'] = true;
            }
        } else {
            $body['message'] = "Hasło by się zmieniło";
            $this->session->setValue(self::HASH, null);
        }
        $this->response->setBody($this->useTemplate('templates/new_password.html.php', $body));
    }
}