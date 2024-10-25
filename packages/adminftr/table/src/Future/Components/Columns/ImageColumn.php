<?php

namespace Adminftr\Table\Future\Components\Columns;

use Adminftr\Table\Future\Components\Column;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

/**
 * Class ImageColumn
 *
 * Represents a column in a table that displays images.
 */
class ImageColumn extends Column
{
    /**
     * The height of the image in pixels.
     *
     * @var string|null
     */
    public ?string $height = '60';

    /**
     * The disk where images are stored.
     *
     * @var string
     */
    protected string $disk = 'public';

    /**
     * Whether the image should be displayed in a circular shape.
     *
     * @var bool
     */
    protected bool $circular = false;

    /**
     * The callback to customize the rendering of the image URL.
     *
     * @var callable|null
     */
    protected $stacked;

    /**
     * The width of the image in pixels.
     *
     * @var string|null
     */
    public ?string $width = '60';

    /**
     * The default image URL to be used if the image URL is not valid.
     *
     * @var string
     */
    protected string $defaultImageUrl = '';

    /**
     * Create a new instance of the ImageColumn.
     *
     * @param string $name
     * @param string|null $label
     * @return static
     */
    public static function make(string $name, ?string $label = null)
    {
        return new static($name, $label);
    }

    /**
     * Set a callback to customize how the image URL is rendered.
     *
     * @param callable $callback
     * @return $this
     */
    public function stacked(callable $callback)
    {
        $this->stacked = $callback;

        return $this;
    }

    /**
     * Set the disk where images are stored.
     *
     * @param string $disk
     * @return $this
     */
    public function disk(string $disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Set the image to be square with the given size.
     *
     * @param int $size
     * @return $this
     */
    public function square(int $size)
    {
        $this->height = $size;
        $this->width = $size;

        return $this;
    }

    /**
     * Set the image to be displayed as a circle.
     *
     * @return $this
     */
    public function circular()
    {
        $this->circular = true;

        return $this;
    }

    /**
     * Set the default image URL to be used if the actual image URL is invalid.
     *
     * @param string $url
     * @return $this
     */
    public function defaultImage(string $url)
    {
        $this->defaultImageUrl = $url;

        return $this;
    }

    /**
     * Render the image HTML for the given model.
     *
     * @param Model $model
     * @return HtmlString
     */
    public function render(Model $model)
    {
        // If the image URL is not valid, use the default image URL.
        if (! filter_var($model->{$this->name}, FILTER_VALIDATE_URL)) {
            $model->{$this->name} = Storage::disk($this->disk)->url($model->{$this->name});
        }

        // Use the render callback if provided, otherwise use the image URL from the model.
        $url = $this->stacked ? call_user_func($this->stacked, $model) : $model->{$this->name};
        $parsedUrl = parse_url($url);

        // Ensure the URL has a scheme.
        if (! isset($parsedUrl['scheme'])) {
            $url = 'http://'.$url;
        }

        // Determine the CSS class for the image based on its shape.
        $circularClass = $this->circular ? 'rounded-circle' : 'rounded';

        // Return the HTML string for the image.
        return new HtmlString("<img src='{$url}' class='img-fluid {$circularClass}'
style='height: {$this->height}px;width: {$this->width}px' alt=''/>");
    }
}
