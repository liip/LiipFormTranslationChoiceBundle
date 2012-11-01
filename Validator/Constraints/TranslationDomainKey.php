<?php
namespace Liip\Bundle\FormTranslationChoiceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @author David Buchmann <david@liip.ch>
*/
class TranslationDomainKey extends Constraint
{
    public $message = 'liipformtranslationchoice.validator.translationdomainkey';
    public $translation_domain;
    public $locale = null;

    public function validatedBy()
    {
        return 'translation_domain_key';
    }

}