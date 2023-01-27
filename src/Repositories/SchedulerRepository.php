<?php

declare(strict_types=1);

namespace Worker\Repositories;

class SchedulerRepository
{
    private const TOTAL = 99;

    /**
     * Dummy implementation.
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array{data: array<array{id: int}>, count: int}
     */
    public function load(int $offset, int $limit): array
    {
        $fakeItemsCount = max(
            min($offset + $limit, self::TOTAL) - $offset,
            0
        );

        $data = [];

        for ($i = 0; $i < $fakeItemsCount; ++$i) {
            $data[] = [
                'id' => $offset + $i + 1,
            ];
        }

        return [
            'data'  => $data,
            'count' => count($data),
        ];
    }
}