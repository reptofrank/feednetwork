<?php

namespace App\Factory;

use App\Entity\Content;
use App\Repository\ContentRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Content|Proxy createOne(array $attributes = [])
 * @method static Content[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Content|Proxy findOrCreate(array $attributes)
 * @method static Content|Proxy random(array $attributes = [])
 * @method static Content|Proxy randomOrCreate(array $attributes = [])
 * @method static Content[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Content[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ContentRepository|RepositoryProxy repository()
 * @method Content|Proxy create($attributes = [])
 */
final class ContentFactory extends ModelFactory
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
            'description' => self::faker()->realText(100),
            'guid' => self::faker()->url()
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Content $content) {})
        ;
    }

    protected static function getClass(): string
    {
        return Content::class;
    }
}
