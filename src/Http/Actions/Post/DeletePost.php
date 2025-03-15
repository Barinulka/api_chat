<?php
namespace App\Http\Actions\Post;

use App\Entity\UUID;
use App\Exception\HttpException;
use App\Exception\InvalidArgumentException;
use App\Exception\PostException\PostNotFoundException;
use App\Http\Actions\ActionInterface;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessResponse;
use App\Repository\PostRepository\PostRepositoryInterface;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {

    }

    public function handle(Request $request): Response
    {
        try {
            $postUUID = new UUID($request->getQuery('uuid'));
        } catch (HttpException | InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $this->postRepository->delete($postUUID);
        } catch(PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessResponse();
        
    }
}