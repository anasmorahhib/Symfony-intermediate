<?php

namespace App\Factory;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Product>
 *
 * @method        Product|Proxy                              create(array|callable $attributes = [])
 * @method static Product|Proxy                              createOne(array $attributes = [])
 * @method static Product|Proxy                              find(object|array|mixed $criteria)
 * @method static Product|Proxy                              findOrCreate(array $attributes)
 * @method static Product|Proxy                              first(string $sortedField = 'id')
 * @method static Product|Proxy                              last(string $sortedField = 'id')
 * @method static Product|Proxy                              random(array $attributes = [])
 * @method static Product|Proxy                              randomOrCreate(array $attributes = [])
 * @method static ProductRepository|ProxyRepositoryDecorator repository()
 * @method static Product[]|Proxy[]                          all()
 * @method static Product[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Product[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Product[]|Proxy[]                          findBy(array $attributes)
 * @method static Product[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Product[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class ProductFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'added_date' => self::faker()->dateTime(),
            'price' => self::faker()->numberBetween(20, 200),
            'quantity' => self::faker()->numberBetween(1, 20),
            'slug' => self::faker()->text(100),
            'title' => self::faker()->words(4, true),
            'description' => self::faker()->text(200),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Product $product): void {})
        ;
    }
}
