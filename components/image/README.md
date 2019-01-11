# Image Compnent

The image component normalizes and simplifies complex, responsive image functionality.

## Usage

```
egg_component( 'Image', [
	'alt'      => '',
	'caption'  => '',
	'lazyload' => false,
	'role'     => false,
	'sizes'    => [],
	'src'      => '',
	'srcset'   => [],
]);
```

## Parameters

**src**
* (string) (required) Add src attribute for `img` element.
 * Default: None

**alt**
* (string) (optional) Alternative text for the `img` element. Ideal for accessibility. If left blank, consider adding `role`.
 * Default: None

**caption**
* (string) (optional) A caption for the image.
 * Default: None

**lazyload**
* (boolean) (optional) Whether or not to use lazyload. If true, will add `data-` before `src`, `srcset`, and `sizes` attributes.
 * Default: false

**role**
* (boolean|string) (optional) Add role attribute. If true, defaults to `role="presentation"`.
 * Default: false

**sizes**
* (array) (optional) Add sizes attribute.
 * Default: None

**srcset**
* (array) (optional) Add srcset attribute.
 * Default: None

## Output

### Non-Lazyload

```
<figure class="image">
	<img
		class="image-img"
		alt=""
		src=""
		srcset=""
		sizes="">
</figure>
```

### Lazyload

```
<figure class="image">
	<img
		class="image-img"
		alt=""
		data-src=""
		data-srcset=""
		data-sizes="">
</figure>
```

## Examples

### Lazyload Responsive

```
egg_component( 'image', [
	'lazyload' => true,
	'role'     => true,
	'sizes'    => [
		'(min-width: 768px) 50%',
		'(min-width: 1024px) 33%',
	],
	'src'      => 'https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_1000x700.jpg',
	'srcset'   => [
		'1000w'   => 'https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_1000x700.jpg',
		'600w'    => 'https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_600x400.jpg',
	],
]);
```

**Output**

```
<figure class="image">
	<img
		class="image-img"
		alt=""
		data-src="https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_1000x700.jpg"
		data-srcset="https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_1000x700.jpg 1000w, https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_600x400.jpg 600w"
		data-sizes="(min-width: 768px) 50%, (min-width: 1024px) 33%"
		role="presentation">
</figure>
```

### Caption

```
egg_component( 'image', [
	'alt'      => 'Egg of Gold',
	'caption'  => 'This eggs is gold. There are none like it.',
	'src'      => 'https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_1000x700.jpg',
]);
```

**Output**

```
<figure class="image">
	<img
		class="image-img"
		alt="Egg of Gold"
		src="https://github.com/creativeslice/goldenegg/blob/master/assets/img/img_1000x700.jpg">
	<figcaption class="image-caption">This eggs is gold. There are none like it.</figcaption>
</figure>
```

## Universal Component Parameters

**class**
* (array|string) (optional) Add extra class(es) to the wrapper element. (eg: [ 'btn', 'visible-sm-block' ])
 * Default: None

**id**
* (string|int) (optional) Add an id to the wrapper element. If a number if provided, the id will be prepended with 'section-' (`section-1`). (eg: 'headerBanner')
 * Default: None

**attr**
* (array) (optional) Add extra attributes to the wrapper element. (eg: [ 'data-gallery' => 'slideshow' ])
 * Default: None
