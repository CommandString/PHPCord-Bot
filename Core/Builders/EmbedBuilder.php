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

    public function withTitle(string $title): self
    {
        $this->embed->title = $title;

        return $this;
    }

    public function withDescription(string $description): self
    {
        $this->embed->description = $description;

        return $this;
    }

    public function withColor(int $color): self
    {
        $this->embed->color = $color;

        return $this;
    }

    public function withField(string $name, string $value, ?bool $inline = null): self
    {
        $field = new EmbedField();

        $field->name = $name;
        $field->value = $value;
        $field->inline = $inline;

        $this->embed->fields[] = $field;

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

    // TODO: Finish Embed Builder
}
