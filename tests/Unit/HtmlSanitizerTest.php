<?php

namespace Tests\Unit;

use App\Support\HtmlSanitizer;
use PHPUnit\Framework\TestCase;

class HtmlSanitizerTest extends TestCase
{
    public function test_strips_script_tags(): void
    {
        $input = '<p>Normal text</p><script>alert("xss")</script>';
        $cleaned = HtmlSanitizer::clean($input);
        $this->assertStringNotContainsString('<script>', $cleaned);
        $this->assertStringNotContainsString('alert', $cleaned);
        $this->assertStringContainsString('Normal text', $cleaned);
    }

    public function test_strips_inline_event_handlers(): void
    {
        $input = '<img src="valid.jpg" onerror="alert(1)" onload="evil()">';
        $cleaned = HtmlSanitizer::clean($input);
        $this->assertStringNotContainsString('onerror', $cleaned);
        $this->assertStringNotContainsString('onload', $cleaned);
        $this->assertStringContainsString('src="valid.jpg"', $cleaned);
    }

    public function test_disarms_javascript_urls(): void
    {
        $input = '<a href="javascript:alert(1)">Click me</a>';
        $cleaned = HtmlSanitizer::clean($input);
        $this->assertStringNotContainsString('javascript:', $cleaned);
        $this->assertStringContainsString('href="#"', $cleaned);
    }

    public function test_cleans_nested_arrays(): void
    {
        $input = [
            'id' => '<p>Halo</p><script>evil()</script>',
            'en' => '<p>Hello</p><iframe src="evil.com"></iframe>',
        ];
        $cleaned = HtmlSanitizer::cleanInput($input);
        $this->assertStringNotContainsString('<script>', $cleaned['id']);
        $this->assertStringNotContainsString('<iframe>', $cleaned['en']);
        $this->assertStringContainsString('Halo', $cleaned['id']);
        $this->assertStringContainsString('Hello', $cleaned['en']);
    }
}
