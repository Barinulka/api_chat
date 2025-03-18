<?php

namespace App\Http\Actions\Like;

use App\Entity\Post\PostLike;
use App\Entity\UUID;
use App\Exception\HttpException;
use App\Exception\InvalidArgumentException;
use App\Exception\LikeExistsException;
use App\Exception\PostException\PostNotFoundException;
use App\Exception\UserNotFoundException;
use App\Http\Actions\ActionInterface;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessResponse;
use App\Repository\LikeRepositoryInterface;
use App\Repository\PostRepository\PostRepositoryInterface;
use App\Repository\UserRepository\UserRepositoryInterface;

class CreatePostLike implements ActionInterface
{

    public function __construct(
        private LikeRepositoryInterface $likeRepository,
        private UserRepositoryInterface $userRepository,
        private PostRepositoryInterface $postRepository,
    ) {

    }

    public function handle(Request $request): Response
    {
        try {
            $authorUUID = new UUID($request->getJsonBodyField('author_uuid'));
            $postUUID = new UUID($request->getJsonBodyField('post_uuid'));
        } catch (HttpException | InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        try {
            $author = $this->userRepository->get($authorUUID);
            $post = $this->postRepository->get($postUUID);
        } catch (UserNotFoundException | PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        $newUUID = UUID::randomUUID();

        $postLike = new PostLike(
            $newUUID,
            $author,
            $post
        );

        try {
            $this->likeRepository->save($postLike);
        } catch (LikeExistsException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        return new SuccessResponse(
            ['uuid' => (string) $newUUID],
            201
        );

    }
}