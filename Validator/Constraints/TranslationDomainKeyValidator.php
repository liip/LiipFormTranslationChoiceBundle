<?php
namespace Liip\FormTranslationChoiceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Liip\FormTranslationChoiceBundle\Translation\Translator;

/**
 * Validate that the value is a key in the specified translation domain
 *
 * @author David Buchmann <david@liip.ch>
 */
class TranslationDomainKeyValidator extends ConstraintValidator
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function isValid($value, Constraint $constraint)
    {
        /** @var $constraint TranslationDomainKey */
        $values = $this->translator->all($constraint->translation_domain, $constraint->locale);
        if (! count($values)) {
            trigger_error('No translations in "'.$constraint->translation_domain . '" for "en".');
        }

        if (! isset($values[$value])) {
            $this->context->addViolation($constraint->message, array(
                '{{ string }}' => $value,
                '{{ domain }}' => $constraint->translation_domain,
            ));

            return false;
        }

        return true;
    }
}