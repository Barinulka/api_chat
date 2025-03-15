<?php 
namespace App\Http\Actions\Post;

use App\Entity\UUID;
use App\Http\Request;
use App\Http\Response;
use App\Entity\Post\Post;
use App\Http\ErrorResponse;
use App\Exception\HttpException;
use App\Http\Actions\ActionInterface;
use App\Exception\UserNotFoundException;
use App\Exception\InvalidArgumentException;
use App\Http\SuccessResponse;
use App\Repository\PostRepository\PostRepositoryInterface;
use App\Repository\UserRepository\UserRepositoryInterface;

class CreatePost implements ActionInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PostRepositoryInterface $postRepository,
    ) {

    }


    public function handle(Request $request): Response
    {
        try {
            $authorUUID = new UUID($request->getJsonBodyField("author_uuid"));
        } catch (HttpException | InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $user = $this->userRepository->get($authorUUID);
        } catch(UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $newPostUUID = UUID::randomUUID();

        try {
            $post = new Post(
                $newPostUUID,
                $user,
                $request->getJsonBodyField('title'),
                $request->getJsonBodyField('content'),
            );

        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $this->postRepository->save($post);

        return new SuccessResponse([
            'uuid' => (string) $newPostUUID,
        ]);
    }
}