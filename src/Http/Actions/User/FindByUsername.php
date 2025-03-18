<?php 
namespace App\Http\Actions\User;

use App\Exception\HttpException;
use App\Exception\UserNotFoundException;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\Actions\ActionInterface;
use App\Http\SuccessResponse;
use App\Repository\UserRepository\UserRepositoryInterface;

class FindByUsername implements ActionInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {

    }

    public function handle(Request $request): Response
    {
        try {
            $userName = $request->getQuery("username");
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        try {
            $user = $this->userRepository->getByLogin($userName);
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        return new SuccessResponse([
            'username' => $user->getLogin(),
            'name' => $user->getUserName()->getFirstName(),
        ]);
    }
}