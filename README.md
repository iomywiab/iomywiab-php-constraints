# iomywiab-php-constraints

This library provides **generic classes for checking values**.

It was inspired by WebMozart/Assert
(https://github.com/webmozarts/assert), which is the leading assertion library for PHP at the time of writing and a
great code I used a lot. This library iomywiab-php-constraints, however, provides more functionality. With
iomywiab-php-constraints you get a non-static interface that is the same, no matter how complex the constraints are (you
can even combine any number of constraints and still have the same interface to it). Static interfaces, however, vary
depending on the needed parameters.

Another goal was to provide meaningful error messages but still have a good performance when checking. I decided to
split functionality: All constraint first check if a value is valid (static methods, no overhead creating objects, but
complex constraints break common interfaces). A value is considered valid if no check fails. If a single check fails
then all checks are run to get the all error messages, so in case there is more than one error you will receive all
error messages. Therefore, the performance of checking only should be comparable to WebMozart/Assert, but creating the
error messages is more detailed and therefore probably slower. Since I expect most constraints used in an application to
be not violated, I accept this slower behaviour in favor of better debug information.

It is recommended to use these classes for parameter checks to avoid buffer overflows, injections, bad redirects or
other attacks.

Typical usage is

* REST API parameters
* Function parameters
* Configuration files

**Best practice** is to always cover ALL parameters.

Please note: In order to secure applications you should follow the paradigm of "complete programming"
(German: "Vollständige Programmierung"), which requires you to work on verified values only.

## Coding conventions

### Common method Parameters

Order of parameters:

1. mandatory options
2. the mandatory value to be checked
3. the optional name of the value
4. optional options
5. optional array of errors to be filled

### Structure of static method isValid

1. If all checks are ok then return true (break on first failed check)
2. If buffer for errors is provided then log ALL errors
3. return false
   (see example: IsArray)

## Examples

Please note: All examples are ignoring type hints.

### No constraints

```php
class Example1 {
   public function redirect(/*string*/ $url, /*string*/ $name, /*int*/ $monthlyPayment, /*int*/$age): void {
      
      $paramName = 'name=' . $name;                                       
      $paramPay  = 'yearlyPayment=' . (12*$monthlyPayment); 
      $paramAge  = 'age=' . $age;
      header('Location: ' . $url . '?' . $paramName . '&' . $paramPay . '&' . $paramAge); 
      
      // Warning! $name could by null, '', numeric, a 2GB blob, ...
      // Warning! $monthlyPayment could be null, 0, negative, boolean, ...
      // Warning! $age could be null, 0, negative, a string, ...
      // Warning! $url could have any content, destination not verified
   }
}
``` 

### Predefined constraints, incomplete

```php
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreaterOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsLess;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMaxLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\simple\IsNotEmpty;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrl;
class Example2 {
   public function redirect(/*string*/ $url, /*string*/ $name, /*int*/ $monthlyPayment, /*int*/$age): void {
      IsUrl::assert($url);
      IsType::assert(IsType::STRING, $name);
      IsNotEmpty::assert($name);
      IsStringMaxLength::assert(80,$name);
      IsType::assert(IsType::FLOAT, $name);
      IsGreaterOrEqual::assert(0.0, $monthlyPayment);
      IsType::assert(IsType::INT, $name);
      IsGreaterOrEqual::assert(18, $age);
      IsLess::assert(120, $age);
      // set header (see Example1)
   }
}
``` 

### User-defined constraints, complete

Example follows best practice: 1 constraint for 1 parameter

```php
use iomywiab\iomywiab_php_constraints\constraints\combined\Constraints;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsGreaterOrEqual;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsLess;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrl;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMinLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMaxLength;
class MyURL extends IsUrl {
   public function __construct() 
   {
      $this->setSchemes(['http', 'https'])
             ->setPorts([80,443])
             ->setHosts(['github.com','www.github.com']);
   }
}
class Example3 {
   public function redirect(/*string*/ $url, /*string*/ $name, /*int*/ $monthlyPayment, /*int*/$age): void {
      MyURL::assert($url);
      Constraints::assert([
          new IsType(IsType::STRING),
          new IsStringMinLength(1),
          new IsStringMaxLength(100)
      ], $name);
      Constraints::assert([
          new IsType(IsType::FLOAT),
          new IsGreaterOrEqual(0),
          new IsLess(123456)
      ], $monthlyPayment);
      Constraints::assert([
          new IsType(IsType::INT),
          new IsGreaterOrEqual(18),
          new IsLess(120)
      ],$age);
      // set header (see first Example1)
   }
}
``` 

### User-defined constraints, complete and shortest

```php
use iomywiab\iomywiab_php_constraints\constraints\combined\IsParameters;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInRange;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringLengthBetween;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMaxLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMinLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrl;
class Example4 {
   public function redirect(/*string*/ $url, /*string*/ $name, /*int*/ $monthlyPayment, /*int*/$age): void {
      IsParameters::assert(
      [
            'url' => new IsUrl(['http', 'https'],['github.com','www.github.com'],[80,443]),
            'name' => new IsStringLengthBetween(1,100),
            'monthlyPayment'=>[
                new IsType(IsType::INT),
                new IsInRange(0,123456)
            ],
            'age' =>[
               new IsType(IsType::INT),
               new IsInRange(18,120)
            ]
         ],
         [
            'url'            => $url,
            'name'           => $name,
            'monthlyPayment' => $monthlyPayment,
            'age'            => $age
         ], 'redirect');
      // set header (see first Example1)
   }
}
``` 

### User-defined constraints, complete and shortest

Example shows checking of a JSON structure (maybe as passed via REST post call)

```php
use iomywiab\iomywiab_php_constraints\constraints\combined\IsParameters;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsInRange;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringLengthBetween;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMaxLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsStringMinLength;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsType;
use iomywiab\iomywiab_php_constraints\constraints\parameterized\IsUrl;
class Example5 {
   public function redirect(/*array*/ $json): void {
      IsParameters::assert(
      [
            'url' => new IsUrl(['http', 'https'],['github.com','www.github.com'],[80,443]),
            'name' => new IsStringLengthBetween(1,100),
            'monthlyPayment'=> [
                new IsType(IsType::INT),
                new IsInRange(0,123456)
            ],
            'age' =>[
               new IsType(IsType::INT),
               new IsInRange(18,120)
            ]
         ],
         $json, 'redirect');
      // set header (see first Example1)
   }
}
``` 

## Type and Value

PHP differentiates between type and value:

* InvalidArgumentException (derived from LogicException) is to be used for invalid types
* UnexpectedValueException (derived from RunTimeException) is to be used for invalid values

I do not see the benefit of having a differentiation here: If my parameters are wrong, then I do not care why. I care
for them being correct, which includes type and value. Also, I disagree with type errors being derived from
LogicException only, as parameters might be specified during runtime from users and those parameters also might have a
wrong type. Therefore, constraints in this package use its own class ConstraintViolationException.

## Checked and Unchecked exceptions

ConstraintViolationException is derived from LogicException. The latter is mostly treated as an unchecked exception.
Unchecked means there is no need to create @throws tags in PHPDoc and not catching such an exception in your code is not
marked as erroneous in inspections.

I decided to go with LogicException as the main purpose of a constraint exception is

* checking parameters
* checking invariants
* checking configuration

### Checking Parameters

Most parameter checks might be treated as asserts, but if needed you might just convert the exception to be a checked
exception like this:

```php
use iomywiab\iomywiab_php_constraints\constraints\simple\IsStringNotEmpty;
public function doSomething($unchecked, $checked1, $checked2): void {
   // example for an unchecked constraint
   IsStringNotEmpty::assert($unchecked);

   // example for an individual checked constraint: indirect exception conversion
   if (IsStringNotEmpty::isValid($checked1)) {
      throw new Exception('checked1 must not be empty');
   }

   // example for a checked constraint: direct exception conversion
   try {
      IsStringNotEmpty::assert($checked2);
   } catch (Exception $cause) {
      throw new Exception('checked2 must not be empty', $cause);
   }

   // example for an grouped checked constraint: direct exception conversion
   try {
      IsStringNotEmpty::assert($checked1);
      IsStringNotEmpty::assert($checked2);
   } catch (Exception $cause) {
      throw new Exception('All parameters must not be empty', $cause);
   }
}
```

### Checking Invariants

Faulty invariants are programming errors. Here constraints behave like asserts: they will lead to an exception, but do
not have to be caught (although it is recommended in many cases).

## Best Practices

Always check all parameters that is

* function / method parameters
* REST parameters
* configuration parameters

No PHPDoc header should use "@throws ConstraintViolationException". In case you need/want to define a throws tag use
exception conversion (see examples above in "Checking parameters").
