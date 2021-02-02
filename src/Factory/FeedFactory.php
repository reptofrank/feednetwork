<?php

namespace App\Factory;

use App\Entity\Feed;
use App\Repository\FeedRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Feed|Proxy createOne(array $attributes = [])
 * @method static Feed[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Feed|Proxy findOrCreate(array $attributes)
 * @method static Feed|Proxy random(array $attributes = [])
 * @method static Feed|Proxy randomOrCreate(array $attributes = [])
 * @method static Feed[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Feed[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FeedRepository|RepositoryProxy repository()
 * @method Feed|Proxy create($attributes = [])
 */
final class FeedFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->unique()->catchPhrase(),
            'url' => self::faker()->url()
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Feed $feed) {})
        ;
    }

    protected static function getClass(): string
    {
        return Feed::class;
    }
}
