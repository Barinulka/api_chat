<?php

namespace App\Repository\PostLikeRepository;

use App\Entity\Post\PostLike;
use App\Entity\UUID;
use App\Exception\LikeExistsException;
use App\Exception\LikeNotFoundException;
use App\Repository\LikeRepositoryInterface;
use App\Repository\PostRepository\PostRepositoryInterface;
use App\Repository\UserRepository\UserRepositoryInterface;
use PDO;

class SqlitePostLikeRepository implements LikeRepositoryInterface
{

    public function __construct(
        private PDO $connection,
        private UserRepositoryInterface $userRepository,
        private PostRepositoryInterface $postRepository,
    ) {

    }

    /**
     * @throws LikeExistsException
     */
    public function save(PostLike $postLike): void
    {
        $statement = $this->connection->prepare(
            "INSERT INTO post_like (uuid, author_uuid, post_uuid) 
            VALUES (:uuid, :author_uuid, :post_uuid)"
        );

        $this->checkLike($postLike->getAuthor()->getId(), $postLike->getPost()->getId());

        $statement->execute([
            ':uuid' => $postLike->getUuid(),
            ':author_uuid' => $postLike->getAuthor()->getId(),
            ':post_uuid' => $postLike->getPost()->getId(),
        ]);
    }

    /**
     * @throws LikeNotFoundException
     */
    public function getByPostUUID(UUID $postUUID): array
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM post_like WHERE author_uuid = :author_uuid"
        );

        $statement->execute([
            ':author_uuid' => $postUUID,
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new LikeNotFoundException(sprintf('Нет лайков для поста с uuid = %s', (string) $postUUID));
        }

        $likes = [];
        foreach ($result as $like) {
            $user = $this->userRepository->get(new UUID($like['author_uuid']));
            $post = $this->postRepository->get(new UUID($like['post_uuid']));
            $likes[] = new PostLike(
                new UUID($like['uuid']),
                $user,
                $post
            );
        }

        return $likes;
    }

    /**
     * @throws LikeExistsException
     */
    private function checkLike(UUID $authorUUID, UUID $postUUID): void
    {
        $statement = $this->connection->prepare(
            "SELECT uuid FROM post_like WHERE author_uuid = :author_uuid AND post_uuid = :post_uuid"
        );

        $statement->execute([
            ':author_uuid' => $authorUUID,
            ':post_uuid' => $postUUID,
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            throw new LikeExistsException();
        }
    }
}