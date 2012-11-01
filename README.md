FormTranslationChoiceBundle
===========================

This Symfony2 bundle provides a form choice field type and a validation
constraint that work with [translation domains](http://symfony.com/doc/current/book/translation.html#using-message-domains).
You can use all strings of a translation domain as values for a field of your
entity. The form stores the translation key in the field.

For example, we use it with an entity `Person` that has a field `title`. We use
a translation domain `person_title` and maintain all possible titles a person
can have (Mr, Ms, Prof, Dr, and so on) in the translation file. The entity
stores the translation key and the title can thus be translated as needed. We
could even change Mr to Mister without need to change the database.

This does not replace a choice field that links to another entity. But for
simple cases like the above example, you might not want to build an admin
interface and store such options in the database.


Installation
============

```bash
php composer.phar require liip/formtranslationchoice-bundle --no-update
php composer.phar update liip/formtranslationchoice-bundle
```

Enable the bundle
=================

Load the bundle in your kernel:

``` php
// app/AppKernel.php
public function registerBundles()
{
  return array(
      // ...
      new Liip\FormTranslationChoiceBundle\LiipFormTranslationChoiceBundle(),
      // ...
  );
}
```
Due to the Symfony2 translator not exposing the translation domains, you need
to use the extended translator provided by this bundle. Add the following to
your project configuration file:

```yaml
# app/config/config.yml
parameters:
    #...
    translator.class:      Liip\Bundle\FormTranslationChoiceBundle\Translation\Translator
```

Usage
=====

This bundle provides a form widget `translation_choice` and a validation
constraint `TranslationDomainKey` that operate on a whole translation domain.

*Warning*: When using this, you want to make sure you have complete translation
for the used domain, or none at all. This bundle does not merge different
languages, but does fall back to the default language if the requested language
does not exist.

translation_choice Form Field Type
----------------------------------

The `translation_choice` field type is based on the core `choice` and provides
all translations of the specified domain as choices. You can use the options of
the standard [Symfony2 choice field type](http://symfony.com/doc/current/reference/forms/types/choice.html).
It makes no sense to specify the choice or choice_list argument though, as they
come from the translation domain.

To select the translation domain to use, the `translation_domain` option is
required.

```php
/** @var $builder FormBuilderInterface */
$builder
    ->add('title', 'translation_choice', array(
        'translation_domain' => 'person_title',
    ))
```

By default, the request locale is used, but you can set the `locale` option if
you need to override this.


Validation constraint
---------------------

This bundle provides a validation constraint that ensures that a field has a
value that is a key in the specified translation domain.

```php
use Liip\FormTranslationChoiceBundle\Validator\Constraints as TranslationAssert;

// ...

/**
 * @TranslationAssert\TranslationDomainKey(translation_domain = "phone_type")
 */
private $type;
```


License
=======

This bundle is licensed under the MIT license. Please see the file LICENSE for more.
