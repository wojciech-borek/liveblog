<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\RelationEdit;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationEditHandler
{
    public function __construct(private RelationRepositoryInterface $repository, private RelationService $relationService) {
    }

    public function __invoke(RelationEditCommand $command): void {
        $id = new RelationId($command->getId());
        $relation = $this->relationService->getRelation($id);
        if (empty($relation)) {
            throw new RelationNotFoundException($id->getValue());
        }
        $relation->changeTitle(new RelationTitle($command->getTitle()));
        $this->repository->save($relation);
    }
}
