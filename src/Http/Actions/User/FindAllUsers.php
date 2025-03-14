<?php
namespace App\Http\Actions\User;

use App\Exception\HttpException;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\Actions\ActionInterface;
use App\Http\SuccessResponse;
use App\Repository\UserRepository\UserRepositoryInterface;

class FindAllUsers implements ActionInterface {
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {

    }

    public function handle(Request $request): Response
    {
        try {
            $users = $this->userRepository->findAll();
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse([
            'users' => $users
        ]);
    }
}