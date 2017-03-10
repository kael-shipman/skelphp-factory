# Factory

A class that provides overridable instantiation of classes based on text descriptors rather than concrete class names.

In the ideal world, any class that needs to instantiate anything would have an instance of this class and would instantiate by telling this class what type of object it wants. For example:

```php
<?php
namespace MyNamespace;

class A {
  public function __constructor(int $one, int $two) {
    $this->one = $one;
    $this->two = $two;
  }

  public static function create(int $one=null, int $two=null) {
    if (!$one) $one = 100;
    if (!$two) $two = 200;
    $o = new static($one, $two);
    return $o;
}

class MyFactory extends \Skel\Factory {
  public function getClass(string $type, string $subtype) {
    // If we want to handle this type with a specific class of our own...
    if ($type == 'aProvider') {
      // And if we want to change that class according to subtype...
      if ($subtype == 'numberOne') return '\\MyNamespace\\A';
      elseif ($subtype == 'numberTwo') return '\\MyNamespace\\A2';

      // Otherwise, return a default within this general type category `aProvider`
      else return '\\Skel\\A';
    }

    // If we don't want to handle other types, pass along to the parent class
    return parent::getClass($type, $subtype);
  }
}

class Application {
  protected $factory;
  public $someServiceProvider;
  public $defaultInstance;

  public function __constructor(\Skel\Interfaces\Factory $f) {
    $this->factory = $factory;
    $this->someServiceProvider = $f->new('aProvider', 'numberOne', 1, 2);
    $this->defaultInstance = $f->create('aProvider', 'numberOne');
  }
}



// Instantiate everything

$app = new Application(new MyFactory());

$app->someServiceProvider; // == Object(MyNamespace\A) { $one => 1, $two = 2 }
$app->defaultInstance; // == Object(MyNamespace\A) { $one = 100, $two = 200 }
```

