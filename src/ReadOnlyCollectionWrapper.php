<?php

/**
 * This file is part of the Kdyby (http://www.kdyby.org)
 *
 * Copyright (c) 2008 Filip Procházka (filip@prochazka.su)
 *
 * For the full copyright and license information, please view the file license.txt that was distributed with this source code.
 */

namespace Kdyby\Doctrine\Collections\Readonly;

use Closure;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;
use Traversable;

/**
 * Read-only collection wrapper.
 * Prohibits any write/modify operations, but allows all non-modifying.
 */
class ReadOnlyCollectionWrapper implements Collection, Selectable
{

	/** @var Collection */
	private $inner;

	public function __construct(Collection $collection)
	{
		$this->inner = $collection;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws ReadOnlyCollectionException
	 */
	public function add($element)
	{
		throw ReadOnlyCollectionException::invalidAccess('add an element to');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws ReadOnlyCollectionException
	 */
	public function clear()
	{
		throw ReadOnlyCollectionException::invalidAccess('clear');
	}

	/**
	 * {@inheritdoc}
	 */
	public function contains($element)
	{
		return $this->inner->contains($element);
	}

	/**
	 * {@inheritdoc}
	 */
	public function isEmpty()
	{
		return $this->inner->isEmpty();
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws ReadOnlyCollectionException
	 */
	public function remove($key)
	{
		throw ReadOnlyCollectionException::invalidAccess('remove an element from');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws ReadOnlyCollectionException
	 */
	public function removeElement($element)
	{
		throw ReadOnlyCollectionException::invalidAccess('remove an element from');
	}

	/**
	 * {@inheritdoc}
	 */
	public function containsKey($key)
	{
		return $this->inner->containsKey($key);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get($key)
	{
		return $this->inner->get($key);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getKeys()
	{
		return $this->inner->getKeys();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getValues()
	{
		return $this->inner->getValues();
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws ReadOnlyCollectionException
	 */
	public function set($key, $value)
	{
		throw ReadOnlyCollectionException::invalidAccess('set an element in');
	}

	/**
	 * {@inheritdoc}
	 */
	public function toArray()
	{
		return $this->inner->toArray();
	}

	/**
	 * {@inheritdoc}
	 */
	public function first()
	{
		return $this->inner->first();
	}

	/**
	 * {@inheritdoc}
	 */
	public function last()
	{
		return $this->inner->last();
	}

	/**
	 * {@inheritdoc}
	 */
	public function key()
	{
		return $this->inner->key();
	}

	/**
	 * {@inheritdoc}
	 */
	public function current()
	{
		return $this->inner->current();
	}

	/**
	 * {@inheritdoc}
	 */
	public function next()
	{
		return $this->inner->next();
	}

	/**
	 * {@inheritdoc}
	 */
	public function exists(Closure $p)
	{
		return $this->inner->exists($p);
	}

	/**
	 * {@inheritdoc}
	 */
	public function filter(Closure $p)
	{
		return $this->inner->filter($p);
	}

	/**
	 * {@inheritdoc}
	 */
	public function forAll(Closure $p)
	{
		return $this->inner->forAll($p);
	}

	/**
	 * {@inheritdoc}
	 */
	public function map(Closure $func)
	{
		return $this->inner->map($func);
	}

	/**
	 * {@inheritdoc}
	 */
	public function partition(Closure $p)
	{
		return $this->inner->partition($p);
	}

	/**
	 * {@inheritdoc}
	 */
	public function indexOf($element)
	{
		return $this->inner->indexOf($element);
	}

	/**
	 * {@inheritdoc}
	 */
	public function slice($offset, $length = NULL)
	{
		return $this->inner->slice($offset, $length);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator(): Traversable
    {
		return $this->inner->getIterator();
	}

	/**
	 * {@inheritdoc}
	 */
	public function offsetExists($offset): bool
    {
		return $this->inner->offsetExists($offset);
	}

	/**
	 * {@inheritdoc}
	 */
	public function offsetGet($offset): mixed
    {
		return $this->inner->offsetGet($offset);
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws ReadOnlyCollectionException
	 */
	public function offsetSet($offset, $value): void
    {
		throw ReadOnlyCollectionException::invalidAccess('set an element in');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws ReadOnlyCollectionException
	 */
	public function offsetUnset($offset): void
    {
		throw ReadOnlyCollectionException::invalidAccess('remove an element from');
	}

	/**
	 * {@inheritdoc}
	 */
	public function count(): int
    {
		return $this->inner->count();
	}

	/**
	 * {@inheritdoc}
	 */
	public function matching(Criteria $criteria)
	{
		if (!$this->inner instanceof Selectable) {
			throw new NotSupportedException(sprintf(
				'Collection %s does not implement %s, so you cannot call ->matching() over it.',
				Selectable::class,
				get_class($this->inner)
			));
		}

		return $this->inner->matching($criteria);
	}

}
