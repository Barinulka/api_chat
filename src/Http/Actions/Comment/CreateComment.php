<?php 
namespace App\Http\Actions\Comment;

use App\Entity\UUID;
use App\Http\Request;
use App\Http\Response;
use App\Http\ErrorResponse;
use App\Entity\Comment\Comment;
use App\Exception\HttpException;
use App\Http\Actions\ActionInterface;
use App\Exception\UserNotFoundException;
use App\Exception\InvalidArgumentException;
use App\Exception\PostException\PostNotFoundException;
use App\Http\SuccessResponse;
use App\Repository\PostRepository\PostRepositoryInterface;
use App\Repository\UserRepository\UserRepositoryInterface;
use App\Repository\CommentRepository\CommentRepositoryInterface;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private UserRepositoryInterface $userRepository,
        private PostRepositoryInterface $postRepository
    ) {

    }
    public function handle(Request $request): Response
    {

        try {
            $authorUUID = new UUID($request->getJsonBodyField("author_uuid"));
            $postUUID = new UUID($request->getJsonBodyField("post_uuid"));
        } catch (HttpException | InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }


        try {
            $user = $this->userRepository->get($authorUUID);
            $post = $this->postRepository->get($postUUID);
        } catch (UserNotFoundException | PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        $newCommentUUID = UUID::randomUUID();

        $comment = new Comment(
            $newCommentUUID,
            $user,
            $post,
            $request->getJsonBodyField("comment")
        );

        $this->commentRepository->save($comment);

        return new SuccessResponse(
            [
                'uuid' => (string) $newCommentUUID
            ], 
            201
        );
    }
}