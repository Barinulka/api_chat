<?php 
namespace App\Http\Actions\User;

use App\Entity\UUID;
use App\Http\Request;
use App\Http\Response;
use App\Entity\User\User;
use App\Entity\Person\Name;
use App\Http\ErrorResponse;
use App\Exception\HttpException;
use App\Http\Actions\ActionInterface;
use App\Http\SuccessResponse;
use App\Repository\UserRepository\UserRepositoryInterface;

class CreateUser implements ActionInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {

    }

    public function handle(Request $request): Response
    {

        $newUserUUID = UUID::randomUUID();
        

        try {
            $name = new Name(
                $request->getJsonBodyField("first_name"),
                $request->getJsonBodyField("last_name"),
            );
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        try {
            $user = new User(
                $newUserUUID,
                $name,
                $request->getJsonBodyField("login"),
            );
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        $this->userRepository->save($user);

        return new SuccessResponse(
            [
                'uuid' => (string)$newUserUUID,
            ], 
            201
        );
    }
}