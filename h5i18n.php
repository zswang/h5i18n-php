<?php

namespace h5i18n;

class Languages {
    /**
     * 当前语言
     */
    protected $locale;
    /**
     * 默认语言
     */
    protected $defaultLang;

    function __construct ($locale = 'cn') {
        $this->locale = $locale;
    }

    public function parse($text) {
        $result = array(
            'options' => array(),
            'locale' => null,
            'localeText' => null,
        );

        while (preg_match('/<!--\{([\w-]+)\}-->([\s\S]*?)<!--\/\{\1\}-->|<!--\{([\w-]+|\*)\}([\s\S]*?)-->/',
            $text, $matches, PREG_OFFSET_CAPTURE)) {
            $locale = $matches[1][0];
            if (empty($locale)) {
                $optionLang = $matches[3][0];
                $optionText = $matches[4][0];
                $result['options'][$optionLang] = $optionText;
            } else {
                $localeText = $matches[2][0];
                $result['locale'] = $locale;
                $result['localeText'] = $localeText;
            }
            $text = substr($text, 0, $matches[0][1]) . 
                substr($text, $matches[0][1] + strlen($matches[0][0]));
        }

        $text = trim($text);
        if (!empty($text)) {
            $result['defaultText'] = $text;
            if (empty($result['options'][$this->defaultLang])) {
                $result['options'][$this->defaultLang] = $text;
            }
        }
        return $result;
    }

    public function get($text, $locale = null) {
        if (empty($locale)) {
            $locale = $this->locale;
        }

        $expression = $this->parse($text);
        if (empty($expression)) {
            return $text;
        }

        $options = $expression['options'];

        if (!empty($options[$locale])) {
            return $options[$locale];
        }

        if (!empty($expression['defaultText'])) {
            return $expression['defaultText'];
        }

        return $options[$this->defaultLang];
    }

    public function getLocale() {
        return $this->locale;
    }
}