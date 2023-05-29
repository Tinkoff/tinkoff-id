<?php

namespace Bitrix\Tinkoffid\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\ActionFilter\Authentication;
use Bitrix\Main\Engine\Response\Redirect;
use CUser;
use CModule;
use TinkoffAuth\Config\Api;
use TinkoffAuth\Facades\Tinkoff;


class AuthFlow extends Controller
{

    /**
     * @return array[]
     */
    public function configureActions()
    {
        return [
            'sign' => [
                '-prefilters' => [
                    Csrf::class,
                    Authentication::class
                ]
            ]
        ];
    }

    public function signAction()
    {
        if ( ! CModule::IncludeModule("tinkoffid")) {
            return $this->redirectHome();
        }
        $tinkoff  = new Tinkoff();
        $mediator = $tinkoff->auth();
        if ( ! $mediator->getStatus()) {
            return $this->redirectHome();
        }

        $credentials = $mediator->getPayload();
        $userinfo    = $credentials[Api::SCOPES_USERINFO];
        $name        = $userinfo['given_name'];
        $lastName    = $userinfo['family_name'];

        // Формирование почты, имени пользователя и пароля
        $email    = isset($userinfo['email']) && $userinfo['email'] ? $userinfo['email'] : null;
        $username = str_replace(['+', ' ', '-'], '', $userinfo['phone_number']);
        $username = $username ?: null;
        $password = md5(time() . rand(0, 100) . rand(0, 200));


        if ( ! $email || ! $username) {
            return $this->redirectHome();
        }

        $userEntity = new CUser;
        $user       = CUser::GetByLogin($email)->Fetch();
        $userID     = isset($user['ID']) && $user['ID'] ? $user['ID'] : null;

        if ( ! $userID) {
            $userID = $userEntity->Add([
                'LOGIN'            => $email,
                'EMAIL'            => $email,
                'PASSWORD'         => $password,
                'CONFIRM_PASSWORD' => $password,
            ]);
        }

        // Паспорт пользователя
        $passportShort = $credentials[Api::SCOPES_PASSPORT_SHORT];
        $passportFull  = $credentials[Api::SCOPES_PASSPORT];
        $passport      = array_merge($passportShort, $passportFull);

        // Водительские права
        $driveLicenses = $credentials[Api::SCOPES_DRIVER_LICENSES];

        // ИНН и Снилс
        $inn   = $credentials[Api::SCOPES_INN];
        $snils = $credentials[Api::SCOPES_SNILS];

        //Информации об идентификации и самозанятости
        $isIdentified   = $credentials[Api::SCOPES_IDENTIFICATION];
        $isSelfEmployed = $credentials[Api::SCOPES_SELF_EMPLOYED_STATUS];

        // Адреса
        $addresses = $credentials[Api::SCOPES_ADDRESSES];

        // Дебетовые карты, подписка и собренд
        $debitCards   = $credentials[Api::SCOPES_DEBIT_CARDS];
        $subscription = $credentials[Api::SCOPES_SUBSCRIPTION];
        $cobrand      = $credentials[Api::SCOPES_COBRAND_STATUS];

        // Публичное должностное лицо, ин агент и есть ли в черных списках
        $officialPerson  = $credentials[ Api::SCOPES_PUBLIC_OFFICIAL_PERSON ];
        $foreignAgent    = $credentials[ Api::SCOPES_FOREIGN_AGENT ];
        $blacklistStatus = $credentials[ Api::SCOPES_BLACKLIST_STATUS ];

        $userEntity->update($userID, [
            'NAME'                          => $userinfo['given_name'],
            'LAST_NAME'                     => $userinfo['family_name'],
            'SECOND_NAME'                   => $userinfo['middle_name'],
            'PERSONAL_PHONE'                => $username,
            'TINKOFF_AUTH_PASSPORT'         => $passport,
            'TINKOFF_AUTH_DRIVE_LICENSES'   => $driveLicenses,
            'TINKOFF_AUTH_INN'              => $inn,
            'TINKOFF_AUTH_SNILS'            => $snils,
            'TINKOFF_AUTH_IS_IDENTIFIED'    => $isIdentified,
            'TINKOFF_AUTH_IS_SELF_EMPLOYED' => $isSelfEmployed,
            'TINKOFF_AUTH_ADDRESSES'        => $addresses,
            'TINKOFF_AUTH_DEBITCARDS'       => $debitCards,
            'TINKOFF_AUTH_SUBSCRIPTION'     => $subscription,
            'TINKOFF_AUTH_COBRAND'          => $cobrand,
            'TINKOFF_AUTH_OFFICIAL_PERSON'   => $officialPerson,
            'TINKOFF_AUTH_FOREIGN_AGENT'     => $foreignAgent,
            'TINKOFF_AUTH_BLACKLIST_STATUS'  => $blacklistStatus,
        ]);

        $userEntity->Authorize($userID);


        return $this->redirectHome();
    }

    private function redirectHome()
    {
        if (class_exists(Redirect::class)) {
            return new Redirect('/');
        }

        header('Location: /');
        exit();
    }
}