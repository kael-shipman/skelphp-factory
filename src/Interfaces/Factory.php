<?php
namespace Skel\Interfaces;

/**
 * A class that provides construction and creation of arbitrary classes
 *
 * This is to be passed to nearly all Skel objects, and should provide a robust dependency injection system
 * that allows users to optionally override class types for a variety of different contexts
 */
interface Factory extends \KS\FactoryInterface {
  /**
   * Set the factory's associated context object
   */
  function setContext(Context $c);
}


