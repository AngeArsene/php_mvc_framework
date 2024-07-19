<?php

declare(strict_types=1);

namespace application\core;

/**
 * Represents a view in the application.
 * 
 * This class is responsible for rendering the view content and its layout.
 */
final class View
{
    public static $MAIN_LAYOUT = 'main';

    private const VIEW_EXTENS = '.view.php';
    private const LAYOUT_EXTENS = '.layout.php';

    public function __construct(private string $name, private string $layout, private array $params = [])
    {
    }

    /**
     * Retrieves the content of the view file.
     *
     * @return string The rendered view content.
     */
    private function view_content(): string
    {
        foreach ($this->params as $key => $value) $$key = $value;

        ob_start();

        require_once Application::$ROOT_DIR .
            DIRECTORY_SEPARATOR . 'views' .
            DIRECTORY_SEPARATOR . $this->name . self::VIEW_EXTENS;

        return ob_get_clean();
    }

    /**
     * Retrieves the content of the layout file.
     *
     * @return string The rendered layout content.
     */
    private function layout_content(): string
    {
        foreach ($this->params as $key => $value) $$key = $value;

        ob_start();

        require_once Application::$ROOT_DIR .
            DIRECTORY_SEPARATOR . 'views' .
            DIRECTORY_SEPARATOR . 'layouts' .
            DIRECTORY_SEPARATOR . $this->layout . self::LAYOUT_EXTENS;

        return ob_get_clean();
    }

    /**
     * Renders the view content within the layout.
     *
     * @return string The final rendered HTML.
     */
    private function render(): string
    {
        return str_replace('{{content}}', $this->view_content(), $this->layout_content());
    }

    /**
     * Returns the rendered HTML when the object is cast to a string.
     *
     * @return string The final rendered HTML.
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
