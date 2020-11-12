<?php
namespace App\Socials\Mailru;

use SocialiteProviders\Manager\SocialiteWasCalled;

class MailRuExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'mailru', __NAMESPACE__ . '\Provider'
        );
    }
}
