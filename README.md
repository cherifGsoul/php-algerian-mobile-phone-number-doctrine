# cherif/php-algerian-mobile-phone-number-doctrine

The cherif/php-algerian-mobile-phone-number-doctrine package allows to use (cherif/algerian-mobile-phone-number)[https://github.com/cherifGsoul/php-algerian-mobile-phone-number] as a (Doctrine field type)[https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/cookbook/custom-mapping-types.html].

## Installtion
The recommended way of installation is by using (Packagist)[https://packagist.org/packages/cherif/php-algerian-mobile-phone-number-doctrine] and (Composer)[http://getcomposer.org/].

The following command should be executed in order to add the package as a requirement to `composer.json` of a project:

```shell
$ composer require cherif/php-algerian-mobile-phone-number-doctrine
```

## Examples:
To configure Doctrine to use cherif/php-algerian-mobile-phone-number-doctrine as a field type, you'll need to set up the following in your bootstrap:

```php
\Doctrine\DBAL\Types\Type::addType('algerian_mobile_phone_number', 'Cherif\AlgerianMobilePhoneNumber\Doctrine\AlgerianMobilePhoneNumberType');
```

In Symfony:

```yaml
# config/packages/doctrine.yaml
doctrine:
  dbal:
    types:
      algerian_mobile_phone_number: Cherif\AlgerianMobilePhoneNumber\Doctrine\AlgerianMobilePhoneNumberType
```
## Usage:

Then, in your entities, you may annotate properties by setting the @Column type to `algerian_mobile_phone_number`:

```php
use Doctrine\ORM\Mapping as ORM;
use Cherif\AlgerianMobilePhoneNumber\AlgerianMobilePhoneNumber;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @var Cherif\AlgerianMobilePhoneNumber\AlgerianMobilePhoneNumber
     *
     * @ORM\Id
     * @ORM\Column(type="algerian_mobile_phone_number", unique=true)
     */
    protected $mobilePhoneNumber;

    public function getMobilePhoneNumber(): AlgerianMobilePhoneNumber
    {
        return $this->mobilePhoneNumber;
    }
}
```

To use XML Mapping instead of PHP annotations.

```xml
...

<field name="mobilePhoneNumber" column="mobile_phone_number" type="algerian_mobile_phone_number" unique="true" />

...
```

## Contribution
Contributions are welcome to make this library better.

- Clone the repo:

```shell
$ git clone git@github.com:cherifGsoul/php-algerian-mobile-phone-number-doctrine.git
```

and enter to the cloned repository directory.

- Install dependencies:

```shell
$ composer install
```

### Testing:
Run composer script for testing:

```shell
$ ./bin/phpunit
```

## License

[MIT License](LICENSE).



