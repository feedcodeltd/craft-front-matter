# Front Matter for Craft CMS 3.x

[![Build Status](https://scrutinizer-ci.com/g/tinydots/craft-front-matter/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tinydots/craft-front-matter/build-status/develop) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tinydots/craft-front-matter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tinydots/craft-front-matter/?branch=master) 
[![Code Coverage](https://scrutinizer-ci.com/g/tinydots/craft-front-matter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tinydots/craft-front-matter/?branch=master) 
[![License](https://poser.pugx.org/tinydots/craft-front-matter/license)](https://packagist.org/packages/tinydots/craft-front-matter)

Front Matter allows you to extract [YAML](http://yaml.org/spec/1.2/spec.html) data from specially-formatted
comments at the top of your twig templates. This is especially useful
for including a pattern library inside your Craft CMS project.

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

    `cd /path/to/project`

2. Then tell Composer to load the plugin:

    `composer require tinydots/craft-front-matter`

3. In the Control Panel, go to Settings -> Plugins and click the “Install”
button for Front Matter.

## Usage

### Defining data

You can add YAML metadata to the top of any twig template by surrounding
it in `{#---` and `---#}` tags. Because the YAML data is inside a twig
comment, you can still `{% include %}` and `{% embed %}` templates as
normal, with or without the plugin installed.

Given a `_components/link.html` template for rendering a link, with the
following YAML front matter data:

```twig
{#---
title: Links
description: >
    This is a tiny component for rendering a simple link.

        {% include "_components/link" with {
            url: 'https://www.example.com,
            text: 'Google',
        } %}
variables:
    text: The text to use as the body of the link
    url: The url of the target
examples:
    - text: Craft CMS
      url: https://www.craftcms.com
    - text: Google
      url: https://www.google.com
---#}

<a href="{{ url }}">{{ text }}</a>
```

### Accessing data

You can access the YAML data as an array from other templates with
`craft.frontMatter.parse(template)`:

```twig
{% set component = craft.frontMatter.parse("_components/link") %}

<h2>{{ component.title }}</h2>

{{ component.description|markdown }}
```

### Pattern Libraries

The main use-case for embedding YAML data in templates is for creating
a style guide or pattern library inside the Craft project itself.

Collections/arrays are available to use as normal so can be used to
document the variables the template accepts:

```twig
{% if component.variables is defined %}
    <h3>Variables</h3>
    <dl>
        {% for variable, description in component.variables %}
            <dt><code>{{ variable }}</code></dt>
            <dd>{{ description|markdown }}</dd>
        {% endfor %}
    </dl>
{% endif %}
```

You can output the escaped source of the template _without_ the YAML
data, using `craft.frontMatter.source(template)`:

```twig
<h3>Source code</h3>

<pre>
    {{- craft.frontMatter.source("_components/link") -}}
</pre>
```

If you use simple strings and arrays as input variables in your template,
you can even embed a few examples of the output by passing them back in to a
normal `{% include %}` of the template:

```twig
{% if component.examples is defined %}
    <h3>Examples</h3>

    {% for example in component.examples %}

        {# Output the rendered template with the example data #}
        {% include "_components/link" with example only %}

        {# Output the escaped rendered HTML output#}
        <pre>{% filter escape('html') %}{% include "_components/link" with example only %}{% endfilter %}</pre>

    {% endfor %}
{% endif %}
```