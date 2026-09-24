<?php

namespace Xushi\UI;

use Illuminate\View\Compilers\ComponentTagCompiler;

class XushiTagCompiler extends ComponentTagCompiler
{
    public function compile(string $value): string
    {
        if (! str_contains($value, '@verbatim')) {
            return parent::compile($value);
        }

        $segments = preg_split(
            '/(@verbatim.*?@endverbatim)/s',
            $value,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        $compiled = '';

        foreach ($segments as $segment) {
            if ($segment === '') {
                continue;
            }

            $compiled .= str_starts_with($segment, '@verbatim')
                ? $segment
                : parent::compile($segment);
        }

        return $compiled;
    }

    protected function compileOpeningTags(string $value): string
    {
        $pattern = "/
            <
                \s*
                xushi[\:][\w\-\:\.]*
                (?<attributes>
                    (?:
                        \s+
                        (?:
                            (?:
                                @(?:class)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                @(?:style)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
                            )
                            |
                            (?:
                                [\w\-:.@%]+
                                (
                                    =
                                    (?:
                                        \\\"[^\\\"]*\\\"
                                        |
                                        '[^']*'
                                        |
                                        [^'\\\"=<>]+
                                    )
                                )?
                            )
                        )
                    )*
                    \s*
                )
                (?<![\/=\-])
            >
        /x";

        return preg_replace_callback($pattern, function (array $matches) {
            $this->boundAttributes = [];
            $component = 'xushi::' . $this->extractComponentName($matches[0]);
            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            return $this->componentString($component, $attributes);
        }, $value);
    }

    protected function compileSelfClosingTags(string $value): string
    {
        $pattern = "/
            <
                \s*
                xushi[\:]([\w\-\:\.]*)
                \s*
                (?<attributes>
                    (?:
                        \s+
                        (?:
                            (?:
                                @(?:class)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                @(?:style)(\( (?: (?>[^()]+) | (?-1) )* \))
                            )
                            |
                            (?:
                                \{\{\s*\\\$attributes(?:[^}]+?)?\s*\}\}
                            )
                            |
                            (?:
                                [\w\-:.@%]+
                                (
                                    =
                                    (?:
                                        \\\"[^\\\"]*\\\"
                                        |
                                        '[^']*'
                                        |
                                        [^'\\\"=<>]+
                                    )
                                )?
                            )
                        )
                    )*
                    \s*
                )
            \/>
        /x";

        return preg_replace_callback($pattern, function (array $matches) {
            $this->boundAttributes = [];
            $attributes = $this->getAttributesFromAttributeString($matches['attributes']);

            if (isset($attributes['slot'])) {
                $slot = $attributes['slot'];
                unset($attributes['slot']);

                return '@slot(' . $slot . ') '
                    . $this->componentString('xushi::' . $matches[1], $attributes)
                    . "\n@endComponentClass##END-COMPONENT-CLASS##"
                    . ' @endslot';
            }

            return $this->componentString('xushi::' . $matches[1], $attributes)
                . "\n@endComponentClass##END-COMPONENT-CLASS##";
        }, $value);
    }

    protected function compileClosingTags(string $value): string
    {
        return preg_replace(
            "/<\/\s*xushi[\:][\w\-\:\.]*\s*>/",
            ' @endComponentClass##END-COMPONENT-CLASS##',
            $value
        );
    }

    protected function extractComponentName(string $tag): string
    {
        preg_match('/<\s*xushi[\:]([\w\-\:\.]*)/i', $tag, $matches);

        return $matches[1] ?? '';
    }
}
