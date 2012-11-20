<?php
namespace Liip\Bundle\FormTranslationChoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;

use Liip\Bundle\FormTranslationChoiceBundle\Translation\Translator;

/**
 * A special case of the choice widget that uses translation message domains
 * as options.
 *
 * @author David Buchmann <david@liip.ch>
 */
class TranslationChoiceType extends AbstractType
{
    /**
     * @var Translator
     */
    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $that = $this;
        $choiceList = function (Options $options) use ($that) {
            return new SimpleChoiceList($that->getTranslations($options['translation_domain'], $options['locale'], $options['sorted']));
        };

        $resolver->setRequired(array('translation_domain'));

        $resolver->setDefaults(array(
            'choice_list' => $choiceList,
            'locale' => null,
            'sorted' => true,
        ));
    }

    public function getTranslations($domain, $locale, $sorted)
    {
        $res = $this->translator->all($domain, $locale);

        if ($sorted) {
            asort($res);
        }

        return $res;
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'translation_choice';
    }
}