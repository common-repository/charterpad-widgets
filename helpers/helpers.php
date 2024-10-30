<?php

// tag with possible indentation
if (!function_exists('cpwidget5236_tag')) {
    function cpwidget5236_tag($tag, $ltagcontent = "", $openindent = -1, $closeindent = -1)
    {
        return cpwidget5236_attrtag($tag, "", $ltagcontent, $openindent, $closeindent);
    }
}

// an attribute with a given value
// or empty if value is not set
if (!function_exists('cpwidget5236_attr')) {
    function cpwidget5236_attr($attr, $value)
    {
        if (empty($value))
            return '';
        else
            return ' ' . $attr . '="' . $value . '"';
    }
}

// attributed tag, possibly indented
if (!function_exists('cpwidget5236_attrtag')) {
    function cpwidget5236_attrtag($tag, $attrs, $ltagcontent = "", $openindent = -1, $closeindent = -1)
    {
        $attributes = '';
        if (is_array($attrs)) {
            foreach ($attrs as $key => $value) {
                $attributes .= cpwidget5236_attr($key, $value);
            }
        } else {
            $attributes = $attrs;
        }

        $html = "<" . $tag . ' ' . $attributes;
        if ($openindent >= 0)
            $html = "\n" . cpwidget5236_indentation($openindent) . $html;
        if (empty($ltagcontent)) {
            $html .= "/>";
            if ($closeindent >= 0)
                $html .= "\n" . cpwidget5236_indentation($closeindent);
        } else {
            $html .= ">" . $ltagcontent;
            if ($closeindent >= 0) {
                $html .= "\n" . cpwidget5236_indentation($closeindent);
            }
            $html .= "</" . $tag . ">";
        }
        return $html;
    }
}

// indent the given lines
if (!function_exists('cpwidget5236_indent')) {
    function cpwidget5236_indent($html, $indent)
    {
        $result = "";
        $lines = explode("\n", $html);
        foreach ($lines as $line) {
            $result .= cpwidget5236_indentation($indent) . $line . "\n";
        }
        return $result;
    }
}


// indentation by the given count
if (!function_exists('cpwidget5236_indentation')) {
    function cpwidget5236_indentation($count)
    {
        return str_repeat("  ", $count);
    }
}

// adds a newline    
if (!function_exists('cpwidget5236_line')) {
    function cpwidget5236_line($line)
    {
        return $line . "\n";
    }
}
