<?php

namespace Core\Builders;

use PHPCord\PHPCord\Builders\BuilderInterface;
use PHPCord\PHPCord\Parts\Messages\Embeds\Embed;
use PHPCord\PHPCord\Parts\Messages\Embeds\EmbedField;
use PHPCord\PHPCord\Parts\Messages\Embeds\EmbedFooter;

class EmbedBuilder implements BuilderInterface
{
    protected Embed $embed;

    public function __construct()
    {
        $this->embed = new Embed();
    }

    private function set(string $name, mixed $value): self
    {
        $this->embed->$name = $value;

        return $this;
    }

    public function withTitle(string $title): self
    {
        return $this->set('title', $title);
    }

    public function withThumbnail(string $url): self
    {
        return $this->set('thumbnail', $url);
    }

    public function withAuthor(string $name, ?string $iconUrl = null, ?string $proxyIconUrl = null): self
    {
        $author = new EmbedAuthor();
        $author->name = $name;
        $author->iconUrl = $iconUrl;
        $author->proxyIconUrl = $proxyIconUrl;

        $this->embed->author = $author;

        return $this;
    }

    public function withDescription(string $description): self
    {
        return $this->set('description', $description);
    }

    public function withColor(int $color): self
    {
        return $this->set('color', $color);
    }

    public function withTimestamp(int $timestamp): self
    {
        return $this->set('timestamp', $timestamp);
    }

    public function withField(string $name, string $value, ?bool $inline = null): self
    {
        $this->embed->fields = [...$this->embed->fields ?? [], ($field = new EmbedField())];

        $field->name = $name;
        $field->value = $value;
        $field->inline = $inline;

        var_dump($field);

        return $this;
    }

    public function withFooter(string $text, ?string $iconUrl = null, ?string $proxyIconUrl = null): self
    {
        $footer = new EmbedFooter();
        $footer->text = $text;
        $footer->iconUrl = $iconUrl;
        $footer->proxyIconUrl = $proxyIconUrl;

        $this->embed->footer = $footer;

        return $this;
    }

    public function build(): Embed
    {
        return clone $this->embed;
    }
}
