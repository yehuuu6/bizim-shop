<?php

namespace Components\Super;

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/consts.inc.php");

if (isset($_SESSION['id']) && $_SESSION['verified'] == 0) {
    header("location: /auth/verify");
    die();
}

use Components\Component;

/**
 * Head component of the page
 * @param string $props['title'] Title of the page, default: DEFAULT_PAGE_TITLE
 * @param string $props['description'] Description of the page, default: DEFAULT_PAGE_DESCRIPTION
 * @param string $props['keywords'] Keywords of the page, default: DEFAULT_PAGE_KEYWORDS
 * @param string $props['author'] Author of the page, default: DEFAULT_PAGE_AUTHOR
 * @param string $props['favicon'] Favicon of the page, default: DEFAULT_PAGE_FAVICON
 * @param array $props['styles'] Stylesheets of the page, default: []
 * @throws Exception If one or more metadata props are invalid & has more than 5 props.
 */
class Head extends Component
{
    public function __construct(array $props = [])
    {
        $this->check_props($props);

        // Set metadata props
        $metadata = $this->set_metadata($props);
        list($title, $desc, $keywords, $author, $favi, $styles) = $metadata;

        $body = <<<HTML
        <!DOCTYPE html>
            <html lang="tr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="description" content="{$desc}">
                <meta name="keywords" content="{$keywords}">
                <meta name="author" content="{$author}">
                {$this->set_styles($styles)}
                <link rel="shortcut icon" href="{$favi}" type="image/x-icon">
                <script src="/global/plugins/icons.js"></script>
                <title>{$title}</title>
            </head>
            <body>
        HTML;

        // Render the component on the page
        parent::render($body);
    }

    /**
     * Checks if props are valid.
     * @throws Exception If one or more props are invalid & has more than 6 props.
     */
    private function check_props(array $props = [])
    {
        $allowed = [
            "title",
            "description",
            "keywords",
            "author",
            "favicon",
            "styles"
        ];

        if (count($props) > 6) {
            throw new \Exception("Head component has too many props.");
        }

        if ($props) {
            foreach (array_keys($props) as $key) {
                if (!in_array($key, $allowed)) {
                    throw new \Exception("Head component has an unknown prop.");
                }
            }
        }
    }

    /**
     * Sets page metadata based on props given to the component.
     */
    private function set_metadata(array $props = [])
    {
        $PAGE_TITLE = $props["title"] ?? DEFAULT_PAGE_TITLE;
        $PAGE_DESCRIPTION = $props["description"] ?? DEFAULT_PAGE_DESCRIPTION;
        $PAGE_KEYWORDS = $props["keywords"] ?? DEFAULT_PAGE_KEYWORDS;
        $PAGE_AUTHOR = $props["author"] ?? DEFAULT_PAGE_AUTHOR;
        $PAGE_FAVICON = $props["favicon"] ?? DEFAULT_PAGE_FAVICON;
        $PAGE_STYLESHEETS = $props["styles"] ?? [];

        return [$PAGE_TITLE, $PAGE_DESCRIPTION, $PAGE_KEYWORDS, $PAGE_AUTHOR, $PAGE_FAVICON, $PAGE_STYLESHEETS];
    }

    /**
     * Sets stylesheets of the page.
     */
    private function set_styles(array $styles)
    {
        foreach ($styles as $style) {
            $style = "<link rel='stylesheet' href='{$style}'>";
            echo $style;
        }
    }
}