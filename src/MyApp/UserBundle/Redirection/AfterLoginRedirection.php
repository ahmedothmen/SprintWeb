<?php

namespace MyApp\UserBundle\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Created by PhpStorm.
 * User: Haroun
 * Date: 15/03/2017
 * Time: 14:43
 */
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{

    /**
     * @var\Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        //Get list of roles for current user
        $roles = $token->getRoles();

        // Tranform this list in array
        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);

        // otherwise, if is a commercial user we redirect to the crm area
        if (in_array('ROLE_CLIENT', $rolesTab, true)){
            $redirection = new RedirectResponse($this->router->generate('my_app_user_client'));
        }


        // If is a admin or super admin we redirect to the backoffice area
        else {
            $redirection = new RedirectResponse($this->router->generate('my_app_user_admin'));
        }

        return $redirection;
    }

}