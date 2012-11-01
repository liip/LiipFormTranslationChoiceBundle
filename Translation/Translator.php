<?php
namespace Liip\Bundle\FormTranslationChoiceBundle\Translation;

use Symfony\Bundle\FrameworkBundle\Translation\Translator as BaseTranslator;

/**
 * Extended translator that gives access to all entries of a
 * domain, to be used in forms and validation.
 *
 * @author David Buchmann <david@liip.ch>
 */
class Translator extends BaseTranslator
{
    /**
     * Expose the MessageCatalogueInterface::all method
     *
     * @param $domain
     * @param $locale
     */
    public function all($domain = null, $locale = null)
    {
        if (! isset($locale)) {
            $locale = $this->getLocale();
        }
        if (!isset($this->catalogues[$locale])) {
            $this->loadCatalogue($locale);
        }
        /** @var $cat \Symfony\Component\Translation\MessageCatalogueInterface */
        $cat = $this->catalogues[$locale];
        while (! in_array($domain, $cat->getDomains())) {
            $cat = $cat->getFallbackCatalogue();
            if ($cat == null) {
                throw new \RuntimeException("No messages in $domain for $locale");
            }
        }

        return $cat->all($domain);
    }
}
