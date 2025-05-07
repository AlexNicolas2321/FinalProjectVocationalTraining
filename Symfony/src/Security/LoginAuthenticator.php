<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Routing\RouterInterface;
use App\Repository\UserRepository;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    private JWTTokenManagerInterface $jwtManager;
    private UserRepository $userRepository;
    private RouterInterface $router;

    public function __construct(JWTTokenManagerInterface $jwtManager, UserRepository $userRepository, RouterInterface $router)
    {
        $this->jwtManager = $jwtManager;
        $this->userRepository = $userRepository;
        $this->router = $router;
    }

    public function authenticate(Request $request): Passport
    {
        $dni = $request->request->get('dni');
        $password = $request->request->get('password');

        $user = $this->userRepository->findOneBydni($dni);

        if (!$user) {
            throw new AuthenticationException('Credenciales incorrectas.');
        }

        return new Passport(
            new UserBadge($dni),
            new PasswordCredentials($password)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Generate the token JWT
        $user = $token->getUser();
        $jwt = $this->jwtManager->create($user);

        // return  the token in a json response
        return new JsonResponse(['token' => $jwt]);
    }

    protected function getLoginUrl(Request $request): string
    {
        //if you try to access to a controller without the token
        return $this->router->generate('app_login');
    }
}
