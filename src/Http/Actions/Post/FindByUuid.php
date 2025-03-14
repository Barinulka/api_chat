<?php 
namespace App\Http\Actions\Post;

use App\Entity\UUID;
use App\Http\Request;
use App\Http\Response;
use App\Http\ErrorResponse;
use App\Exception\HttpException;
use App\Exception\PostException\PostNotFoundException;
use App\Http\Actions\ActionInterface;
use App\Http\SuccessResponse;
use App\Repository\PostRepository\PostRepositoryInterface;
use PHPUnit\Metadata\InvalidAttributeException;

class FindByUuid implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {

    }


    public function handle(Request $request): Response
    {
        try {
            $postUUID = new UUID($request->getQuery("uuid"));
        } catch (HttpException | InvalidAttributeException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $post = $this->postRepository->get($postUUID);
        } catch (PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse(
            [
                "uuid" => (string) $post->getId(),
                "title" => $post->getTitle(),
                "content" => $post->getContent(),
                "author" => [
                    "uudi" => (string)$post->getUser()->getId(),
                    "login" => $post->getUser()->getLogin(),
                    "first_name" => $post->getUser()->getUserName()->getFirstName(),
                    "last_name" => $post->getUser()->getUserName()->getLastName(),
                ]
            ]
        );
    }
}