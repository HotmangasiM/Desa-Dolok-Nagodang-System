<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class NewsContentSanitizer
{
    private const ALLOWED_TAGS = [
        'a',
        'b',
        'blockquote',
        'br',
        'code',
        'div',
        'em',
        'h2',
        'h3',
        'h4',
        'i',
        'li',
        'ol',
        'p',
        'pre',
        's',
        'span',
        'strong',
        'u',
        'ul',
    ];

    private const ALLOWED_STYLES = [
        'margin-left',
        'padding-left',
        'text-align',
    ];

    public static function sanitize(?string $html): string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return '';
        }

        $document = new DOMDocument();

        libxml_use_internal_errors(true);
        $document->loadHTML(
            '<div>' . mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8') . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        self::cleanNode($document->documentElement);

        $output = '';

        foreach ($document->documentElement->childNodes as $child) {
            $output .= $document->saveHTML($child);
        }

        return trim($output);
    }

    private static function cleanNode(DOMNode $node): void
    {
        if ($node instanceof DOMElement) {
            $tagName = strtolower($node->tagName);

            if (in_array($tagName, ['iframe', 'script', 'style'], true)) {
                $node->parentNode?->removeChild($node);
                return;
            }

            if (!in_array($tagName, self::ALLOWED_TAGS, true) && $tagName !== 'div') {
                self::unwrapNode($node);
                return;
            }

            self::cleanAttributes($node);
        }

        foreach (iterator_to_array($node->childNodes) as $child) {
            self::cleanNode($child);
        }
    }

    private static function cleanAttributes(DOMElement $node): void
    {
        foreach (iterator_to_array($node->attributes) as $attribute) {
            $name = strtolower($attribute->name);
            $value = $attribute->value;

            if ($name === 'href' && strtolower($node->tagName) === 'a') {
                if (preg_match('/^(https?:\/\/|mailto:|\/)/i', $value)) {
                    $node->setAttribute('rel', 'noopener noreferrer');
                    $node->setAttribute('target', '_blank');
                    continue;
                }
            }

            if ($name === 'style') {
                $style = self::sanitizeStyle($value);

                if ($style !== '') {
                    $node->setAttribute('style', $style);
                    continue;
                }
            }

            $node->removeAttribute($attribute->name);
        }
    }

    private static function sanitizeStyle(string $style): string
    {
        $safeRules = [];

        foreach (explode(';', $style) as $rule) {
            if (!str_contains($rule, ':')) {
                continue;
            }

            [$property, $value] = array_map('trim', explode(':', $rule, 2));
            $property = strtolower($property);

            if (!in_array($property, self::ALLOWED_STYLES, true)) {
                continue;
            }

            if ($property === 'text-align' && preg_match('/^(left|right|center|justify)$/', $value)) {
                $safeRules[] = "{$property}: {$value}";
            }

            if (in_array($property, ['margin-left', 'padding-left'], true) && preg_match('/^\d{1,3}(px|rem|em)$/', $value)) {
                $safeRules[] = "{$property}: {$value}";
            }
        }

        return implode('; ', $safeRules);
    }

    private static function unwrapNode(DOMElement $node): void
    {
        $parent = $node->parentNode;

        if (!$parent) {
            return;
        }

        while ($node->firstChild) {
            $parent->insertBefore($node->firstChild, $node);
        }

        $parent->removeChild($node);
    }
}
