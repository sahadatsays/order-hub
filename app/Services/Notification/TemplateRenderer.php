<?php

namespace App\Services\Notification;

class TemplateRenderer
{
    /**
     * Render a template string by replacing variable placeholders with actual values.
     * Variables use {{variable_name}} syntax.
     * Missing variables are replaced with empty string for safety.
     */
    public function render(string $template, array $variables): string
    {
        return preg_replace_callback('/\{\{(\w+)\}\}/', function ($matches) use ($variables) {
            $key = $matches[1];

            return $variables[$key] ?? '';
        }, $template);
    }

    /**
     * Render subject and body from template data with variables.
     */
    public function renderTemplate(array $templateData, array $variables): array
    {
        return [
            'subject' => isset($templateData['subject'])
                ? $this->render($templateData['subject'], $variables)
                : null,
            'body' => $this->render($templateData['body'] ?? '', $variables),
        ];
    }

    /**
     * Extract variable placeholders from a template string.
     */
    public function extractVariables(string $template): array
    {
        preg_match_all('/\{\{(\w+)\}\}/', $template, $matches);

        return array_unique($matches[1] ?? []);
    }
}
