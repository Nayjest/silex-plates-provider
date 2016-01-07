<?php

namespace Rych\Plates\Extension;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use League\Plates\Template\Template;

class SectionExtension implements ExtensionInterface
{
    /**
     * The template object in use
     *
     * @var League\Plates\Template\Template $template
     */
    public $template;

    /**
     * Class constructor
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct()
    {
    }

    /**
     * Register the extension with the engine
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Engine $engine)
    {
        $engine->registerFunction('sectionIs', [$this, 'sectionIs']);
    }

    /**
     * Make a section in one go
     *
     * <code>
     * <? $this->sectionIs('title', 'My Overidden Title Value') ?>
     * </code>
     *
     * @param string $name The section name
     * @param string $content The content for the section
     * @param League\Plates\Template\Template $template The current template object
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function sectionIs($name, $content)
    {
        if (!$this->template instanceof Template) {
            throw new Exception('Template has not been provided to Rych\Plates\Extension\SectionExtension');
        }
        $this->template->start($name);
        echo $content;
        return $this->template->stop();
    }
}
