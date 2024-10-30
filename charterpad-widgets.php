<?php

/**
 * Plugin Name: CharterPad Widget
 * Plugin URI: https://app.charterpad.com/widgets
 * Description: The CharterPad website widgets has it all: setup the avaiable widgets to integrate trip avaiability and quote enquiries, adaptive design, mobile responsive, and much more. Get started now!
 * Version: 1.0.5
 * Author: Charterpad
 * Author URI: https://charterpad.com/
 **/
add_action('admin_menu', 'cpwidget5236_widget_admin_panel_menu');
add_action('wp_head', 'cpwidget5236_wp_head');
add_action('wp_footer', 'cpwidget5236_wp_footer');
require(__DIR__ . '/helpers/helpers.php');

add_shortcode('cp-quote', 'cpwidget5236_generate_shortcode');
add_shortcode('cp-availability', 'cpwidget5236_generate_shortcode');

$cpwidget5236_options = get_option('cpwidget5236_plugin_options');
$cpwidget5236_base_url = esc_url('https://app.charterpad.com/');
$cpwidget5236_widgetsList = array('availability', 'quote');
$cpwidget5236_styleSheetCdn = esc_url($cpwidget5236_base_url . "widgets/css/app.css");
$cpwidget5236_scriptCdn = esc_url($cpwidget5236_base_url . "widgets/js/app.js");

// Adding admin side styling
wp_register_style('cpwidget5236_admin_style', plugin_dir_url(__FILE__) . 'css/style.css');
wp_enqueue_style('cpwidget5236_admin_style', plugin_dir_url(__FILE__) . 'css/style.css');

if (!function_exists('cpwidget5236_wp_head')) {
    function cpwidget5236_wp_head()
    {
        global $cpwidget5236_options, $cpwidget5236_styleSheetCdn;
        if (isset($cpwidget5236_options['app_code']) && isset($cpwidget5236_options['type']) && $cpwidget5236_options['type'] == 'advanced')
            wp_enqueue_style("charterpad_widget_style", $cpwidget5236_styleSheetCdn);
    }
}
if (!function_exists('cpwidget5236_wp_footer')) {
    function cpwidget5236_wp_footer()
    {
        global $cpwidget5236_options, $cpwidget5236_scriptCdn;
        if (isset($cpwidget5236_options['app_code']) && isset($cpwidget5236_options['type']) && $cpwidget5236_options['type'] == 'advanced')
            wp_enqueue_script("charterpad_widget_js", $cpwidget5236_scriptCdn);
        else
            wp_enqueue_script("cpwidget5236_classic_js", plugin_dir_url(__FILE__)  . "js/cp_widget_iframe.js", true, true);
    }
}

// Add cp widget admin menu
if (!function_exists('cpwidget5236_widget_admin_panel_menu')) {
    function cpwidget5236_widget_admin_panel_menu()
    {
        $cpwidget5236_icon = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4wLjEsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMjEuNiAyMjQiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIyMS42IDIyNCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8cGF0aCBmaWxsPSIjRkZGRkZGIiBzdHJva2U9IiNGRkZGRkYiIHN0cm9rZS13aWR0aD0iNSIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMTQ0LjEsNzIuN2MxLjMsMS4zLDEuNywzLjMsMSw1LjFsLTM1LjgsODcuOA0KCWMtMC42LDEuNS0yLjMsMi4yLTMuNywxLjZjLTEuNC0wLjYtMi4xLTIuMy0xLjUtMy44TDEzOC45LDc4bC04NC41LDM1LjJjLTEuNSwwLjYtMy4xLTAuMS0zLjctMS42Yy0wLjYtMS41LDAuMS0zLjEsMS41LTMuOA0KCWw4Ni45LTM2LjJDMTQwLjgsNzEsMTQyLjgsNzEuNCwxNDQuMSw3Mi43Ii8+DQo8cGF0aCBmaWxsPSIjRkZGRkZGIiBzdHJva2U9IiNGRkZGRkYiIHN0cm9rZS13aWR0aD0iNSIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMzguOSw2OS45Yy0xNi43LDAtMzAuMi0xMy43LTMwLjItMzAuNg0KCWMwLTE2LjksMTMuNi0zMC42LDMwLjItMzAuNmMxNi43LDAsMzAuMiwxMy43LDMwLjIsMzAuNkM2OS4xLDU2LjEsNTUuNiw2OS45LDM4LjksNjkuOSBNMzguOSwyLjVDMTguOCwyLjUsMi41LDE5LDIuNSwzOS4zDQoJYzAsMCwwLDAsMCwwLjFoMHYxMDUuMmMwLDEuNywxLjQsMy4xLDMuMSwzLjFjMS43LDAsMy4xLTEuNCwzLjEtMy4xVjU5LjhjNi41LDkuOCwxNy42LDE2LjMsMzAuMiwxNi4zYzIwLjEsMCwzNi40LTE2LjUsMzYuNC0zNi44DQoJQzc1LjMsMTksNTksMi41LDM4LjksMi41Ii8+DQo8cGF0aCBmaWxsPSIjRkZGRkZGIiBzdHJva2U9IiNGRkZGRkYiIHN0cm9rZS13aWR0aD0iNSIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMTgyLjcsMjE1LjNjLTE2LjcsMC0zMC4yLTEzLjctMzAuMi0zMC42DQoJYzAtMTYuOSwxMy42LTMwLjYsMzAuMi0zMC42YzE2LjcsMCwzMC4yLDEzLjcsMzAuMiwzMC42QzIxMi45LDIwMS42LDE5OS40LDIxNS4zLDE4Mi43LDIxNS4zIE0yMTkuMSw3OS41YzAtMS43LTEuNC0zLjEtMy4xLTMuMQ0KCWMtMS43LDAtMy4xLDEuNC0zLjEsMy4xdjg0LjhjLTYuNS05LjgtMTcuNi0xNi4zLTMwLjItMTYuM2MtMjAuMSwwLTM2LjQsMTYuNS0zNi40LDM2LjhjMCwyMC4zLDE2LjMsMzYuOCwzNi40LDM2LjgNCgljMjAuMSwwLDM2LjQtMTYuNSwzNi40LTM2LjhjMCwwLDAsMCwwLTAuMWgwVjc5LjV6Ii8+DQo8cGF0aCBmaWxsPSIjRkZGRkZGIiBzdHJva2U9IiNGRkZGRkYiIHN0cm9rZS13aWR0aD0iNSIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNOC43LDE4NC43YzAtMTYuOSwxMy42LTMwLjYsMzAuMi0zMC42DQoJYzE2LjcsMCwzMC4yLDEzLjcsMzAuMiwzMC42cy0xMy42LDMwLjYtMzAuMiwzMC42QzIyLjIsMjE1LjMsOC43LDIwMS42LDguNywxODQuNyBNMTQzLDIxNS4zSDU5LjFjOS43LTYuNiwxNi4yLTE3LjgsMTYuMi0zMC42DQoJYzAtMjAuMy0xNi4zLTM2LjgtMzYuNC0zNi44Yy0yMC4xLDAtMzYuNCwxNi41LTM2LjQsMzYuOGMwLDIwLjMsMTYuMywzNi44LDM2LjQsMzYuOGMwLDAsMCwwLDAuMSwwdjBoMTA0YzEuNywwLDMuMS0xLjQsMy4xLTMuMQ0KCUMxNDYsMjE2LjcsMTQ0LjcsMjE1LjMsMTQzLDIxNS4zIi8+DQo8cGF0aCBmaWxsPSIjRkZGRkZGIiBzdHJva2U9IiNGRkZGRkYiIHN0cm9rZS13aWR0aD0iNSIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBkPSJNMTgyLjcsNjkuOWMtMTYuNywwLTMwLjItMTMuNy0zMC4yLTMwLjYNCgljMC0xNi45LDEzLjYtMzAuNiwzMC4yLTMwLjZjMTYuNywwLDMwLjIsMTMuNywzMC4yLDMwLjZDMjEyLjksNTYuMSwxOTkuNCw2OS45LDE4Mi43LDY5LjkgTTE4Mi43LDIuNQ0KCUMxODIuNywyLjUsMTgyLjcsMi41LDE4Mi43LDIuNUwxODIuNywyLjVINzguNmMtMS43LDAtMy4xLDEuNC0zLjEsMy4xYzAsMS43LDEuNCwzLjEsMy4xLDMuMWg4My44Yy05LjcsNi42LTE2LjIsMTcuOC0xNi4yLDMwLjYNCgljMCwyMC4zLDE2LjMsMzYuOCwzNi40LDM2LjhjMjAuMSwwLDM2LjQtMTYuNSwzNi40LTM2LjhDMjE5LjEsMTksMjAyLjgsMi41LDE4Mi43LDIuNSIvPg0KPC9zdmc+DQo=';
        add_menu_page('CharterPad Widget', 'CharterPad', 'manage_options', 'charterpad-plugin', 'cpwidget5236_render_plugin_settings_page', 'data:image/svg+xml;base64,' . $cpwidget5236_icon . ',');
    }
}

if (!function_exists('cpwidget5236_render_plugin_settings_page')) {
    function cpwidget5236_render_plugin_settings_page()
    {
?>
        <div class="wrap">
            <h1>CharterPad Widget</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('cpwidget5236_plugin_options'); // cpwidget5236_plugin_options = Name of setting group
                do_settings_sections('cpwidget5236_plugin'); // cpwidget5236_plugin = name of section
                ?>
                <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Settings'); ?>" />
            </form>
        </div>
    <?php
    }
}

if (!function_exists('cpwidget5236_register_settings')) {
    function cpwidget5236_register_settings()
    {
        register_setting('cpwidget5236_plugin_options', 'cpwidget5236_plugin_options', 'cpwidget5236_plugin_options_validate');
        add_settings_section('cpwidget5236_settings', 'General Settings', 'cpwidget5236_plugin_section_text', 'cpwidget5236_plugin');

        // General Settings
        add_settings_field('cpwidget5236_plugin_setting_type', 'Integration Method', 'cpwidget5236_plugin_setting_type', 'cpwidget5236_plugin', 'cpwidget5236_settings');
        add_settings_field('cpwidget5236_plugin_setting_app_code', 'App Code', 'cpwidget5236_plugin_setting_app_code', 'cpwidget5236_plugin', 'cpwidget5236_settings');
        add_settings_field('cpwidget5236_plugin_setting_primary_color', 'Primary Color', 'cpwidget5236_plugin_setting_primary_color', 'cpwidget5236_plugin', 'cpwidget5236_settings');
        add_settings_field('cpwidget5236_plugin_setting_secondary_color', 'Secondary Color', 'cpwidget5236_plugin_setting_secondary_color', 'cpwidget5236_plugin', 'cpwidget5236_settings');
        add_settings_field('cpwidget5236_plugin_theme', 'Theme', 'cpwidget5236_plugin_theme', 'cpwidget5236_plugin', 'cpwidget5236_settings');
        add_settings_field('cpwidget5236_plugin_setting_hide_footer_section', 'Company Signature', 'cpwidget5236_plugin_setting_hide_footer_section', 'cpwidget5236_plugin', 'cpwidget5236_settings');

        // Availability
        add_settings_section('cpwidget5236_availability_settings', 'Availability Widget Settings', 'cpwidget5236_plugin_availability_text', 'cpwidget5236_plugin');
        add_settings_field('cpwidget5236_plugin_setting_availability_enabled', 'Enabled', 'cpwidget5236_plugin_setting_availability_enabled', 'cpwidget5236_plugin', 'cpwidget5236_availability_settings');
        add_settings_field('cpwidget5236_plugin_setting_trip_type', 'Trip Type', 'cpwidget5236_plugin_setting_trip_type', 'cpwidget5236_plugin', 'cpwidget5236_availability_settings');

        // Quote
        add_settings_section('cpwidget5236_quote_settings', 'Quote Widget Settings', 'cpwidget5236_plugin_quote_text', 'cpwidget5236_plugin');
        add_settings_field('cpwidget5236_plugin_setting_quote_enabled', 'Enabled', 'cpwidget5236_plugin_setting_quote_enabled', 'cpwidget5236_plugin', 'cpwidget5236_quote_settings');
    }
    add_action('admin_init', 'cpwidget5236_register_settings');
}
if (!function_exists('cpwidget5236_plugin_options_validate')) {
    function cpwidget5236_plugin_options_validate($cpwidget5236_input)
    {
        if (!isset($cpwidget5236_input['availability_enabled'])) {
            $cpwidget5236_input['availability_enabled'] = 0;
        }
        if (!isset($cpwidget5236_input['quote_enabled'])) {
            $cpwidget5236_input['quote_enabled'] = 0;
        }
        return $cpwidget5236_input;
    }
}
if (!function_exists('cpwidget5236_plugin_section_text')) {
    function cpwidget5236_plugin_section_text()
    {
        echo '<p class="description">Setup your widget and customize the style as per your theme.</p>';
    }
}
if (!function_exists('cpwidget5236_plugin_availability_text')) {

    function cpwidget5236_plugin_availability_text()
    {
        global $cpwidget5236_base_url;
        echo '<p class="description">The specified widget will be used to check the trip availability with advanced search filters. You will receive the customer enquiries as per their prefrences. Use the shortcode <code>[cp-availability]</code></p> <img src="	' . $cpwidget5236_base_url . 'images/widgets/availability.png" height="400"></img>';
    }
}
if (!function_exists('cpwidget5236_plugin_quote_text')) {
    function cpwidget5236_plugin_quote_text()
    {
        global $cpwidget5236_base_url;
        echo '<p class="description">The specified widget will be used as a simple enquiry form. Use the shortcode <code>[cp-quote]</code></p><img src="' . esc_attr($cpwidget5236_base_url) . 'images/widgets/quote.png" height="400"></img>';
    }
}
if (!function_exists('cpwidget5236_plugin_setting_app_code')) {
    function cpwidget5236_plugin_setting_app_code()
    {
        global $cpwidget5236_options, $cpwidget5236_base_url;
        echo "<input required class='cpw-app-code-input' id='cpwidget5236_plugin_setting_app_code' name='cpwidget5236_plugin_options[app_code]' type='text' value='" . esc_attr($cpwidget5236_options['app_code']) . "' />";
        echo "<p class='description'>Get app code from your CharterPad account. <a href='" . esc_attr($cpwidget5236_base_url) . "app-widgets' target='_blank'>Get App Code</a></p>";
    }
}
if (!function_exists('cpwidget5236_plugin_setting_primary_color')) {
    function cpwidget5236_plugin_setting_primary_color()
    {
        global $cpwidget5236_options;
        if (!isset($cpwidget5236_options['primary_color'])) $cpwidget5236_options['primary_color'] = '#009b91';
        echo "<input required id='cpwidget5236_plugin_setting_primary_color' name='cpwidget5236_plugin_options[primary_color]' type='color' placeholder='#009b91' value='" . esc_attr($cpwidget5236_options['primary_color']) . "' />";
        echo "<p class='description'>Set the primary color of the theme as per you website color scheme (Default: #009b91)</p>";
    }
}
if (!function_exists('cpwidget5236_plugin_setting_secondary_color')) {
    function cpwidget5236_plugin_setting_secondary_color()
    {
        global $cpwidget5236_options;
        if (!isset($cpwidget5236_options['secondary_color'])) $cpwidget5236_options['secondary_color'] = '#ff9933';
        echo "<input required id='cpwidget5236_plugin_setting_secondary_color' name='cpwidget5236_plugin_options[secondary_color]' type='color' placeholder='#ff9933' value='" . esc_attr($cpwidget5236_options['secondary_color']) . "' />";
        echo "<p class='description'>Set the secondary color of the theme as per you website color scheme (Default: #ff9933)</p>";
    }
}
if (!function_exists('cpwidget5236_plugin_setting_hide_footer_section')) {
    function cpwidget5236_plugin_setting_hide_footer_section()
    {
        global $cpwidget5236_options;
        $cpwidget5236_checked = (isset($cpwidget5236_options['hide_footer_section']) && $cpwidget5236_options['hide_footer_section'] == 1) ? 1 : 0;
        echo "<label for='cpwidget5236_plugin_setting_hide_footer_section'><input id='cpwidget5236_plugin_setting_hide_footer_section' name='cpwidget5236_plugin_options[hide_footer_section]' type='checkbox' value='1' " . checked(1, $cpwidget5236_checked, false) . "/>";
        echo "By default, a nice footer section exists with all widgets. If you want to hide the footer section then mark as checked.</label>";
    }
}
if (!function_exists('cpwidget5236_plugin_setting_availability_enabled')) {
    function cpwidget5236_plugin_setting_availability_enabled()
    {
        global $cpwidget5236_options;
        $cpwidget5236_checked = !isset($cpwidget5236_options['availability_enabled']) ? 1 : $cpwidget5236_options['availability_enabled'];
        echo "<input id='cpwidget5236_plugin_setting_availability_enabled' name='cpwidget5236_plugin_options[availability_enabled]' type='checkbox' value='1' " . checked(1, $cpwidget5236_checked, false) . "/>";
    }
}
if (!function_exists('cpwidget5236_plugin_setting_quote_enabled')) {
    function cpwidget5236_plugin_setting_quote_enabled()
    {
        global $cpwidget5236_options;
        $cpwidget5236_checked = !isset($cpwidget5236_options['quote_enabled']) ? 1 : $cpwidget5236_options['quote_enabled'];
        echo "<input id='cpwidget5236_plugin_setting_quote_enabled' name='cpwidget5236_plugin_options[quote_enabled]' type='checkbox' value='1' " . checked(1, $cpwidget5236_checked, false) . "/>";
    }
}
if (!function_exists('cpwidget5236_plugin_setting_trip_type')) {

    function cpwidget5236_plugin_setting_trip_type()
    {
        global $cpwidget5236_options;
        $cpwidget5236_empty_leg = (isset($cpwidget5236_options['empty_leg']) && $cpwidget5236_options['empty_leg'] == 1) ? 1 : 0;
        $cpwidget5236_one_way = (isset($cpwidget5236_options['one_way']) && $cpwidget5236_options['one_way'] == 1) ? 1 : 0;
        $cpwidget5236_round_trip = (isset($cpwidget5236_options['round_trip']) && $cpwidget5236_options['round_trip'] == 1) ? 1 : 0;
        echo "<label class='cpw-mr-20'  for='cpwidget5236_plugin_setting_empty_leg'><input id='cpwidget5236_plugin_setting_empty_leg' name='cpwidget5236_plugin_options[empty_leg]' type='checkbox' value='1' " . checked(1, $cpwidget5236_empty_leg, false) . "/>";
        echo "Empty Leg</label>";
        echo "<label class='cpw-mr-20'  for='cpwidget5236_plugin_setting_one_way'><input id='cpwidget5236_plugin_setting_one_way' name='cpwidget5236_plugin_options[one_way]' type='checkbox' value='1' " . checked(1, $cpwidget5236_one_way, false) . "/>";
        echo "One Way</label>";
        echo "<label class='cpw-mr-20'  for='cpwidget5236_plugin_setting_round_trip'><input id='cpwidget5236_plugin_setting_round_trip' name='cpwidget5236_plugin_options[round_trip]' type='checkbox' value='1' " . checked(1, $cpwidget5236_round_trip, false) . "/>";
        echo "Round Trip</label>";
        echo "<p class='description'>The above types are available as filters. You may limit in your widget. By default all options will be considered.</p>";
    }
}
if (!function_exists('cpwidget5236_plugin_setting_type')) {
    function cpwidget5236_plugin_setting_type()
    {
        global $cpwidget5236_options;
    ?>
        <select name="cpwidget5236_plugin_options[type]" id="cpwidget5236_plugin_setting_type">
            <?php $cpwidget5236_selected = (isset($cpwidget5236_options['type']) && $cpwidget5236_options['type'] === 'advanced') ? 'selected' : ''; ?>
            <option value="advanced" <?php echo $cpwidget5236_selected; ?>>Advanced (Recommended)</option>
            <?php $cpwidget5236_selected = (isset($cpwidget5236_options['type']) && $cpwidget5236_options['type'] === 'classic') ? 'selected' : ''; ?>
            <option value="classic" <?php echo $cpwidget5236_selected; ?>>Classic</option>
        </select>
        <p class="description"><b>Advanced: </b> You will be able to override the style on the widget elements. You may manage the font-fmily, size color and much more.</p>
        <p class="description"><b>Classic: </b> You will be able to avoid style and script related conflicts(if any).</p>
    <?php
    }
}
if (!function_exists('cpwidget5236_plugin_theme')) {
    function cpwidget5236_plugin_theme()
    {
        global $cpwidget5236_options;
    ?>
        <select name="cpwidget5236_plugin_options[theme]" id="cpwidget5236_plugin_theme">
            <option value="light" <?php echo (isset($cpwidget5236_options['theme']) && $cpwidget5236_options['theme'] === 'light') ? 'selected' : ''; ?>>Light</option>
            <option value="dark" <?php echo (isset($cpwidget5236_options['theme']) && $cpwidget5236_options['theme'] === 'dark') ? 'selected' : ''; ?>>Dark</option>
        </select>
        <?php
    }
}
if (!function_exists('cpwidget5236_generate_shortcode')) {
    function cpwidget5236_generate_shortcode($cpwidget5236_attributes, $cpwidget5236_content = null, $cpwidget5236_shortcode_name)
    {
        extract(shortcode_atts(array(
            'category' => '',
            'module' => ''
        ), $cpwidget5236_attributes));
        ob_start();
        $cpwidget5236_widget = str_replace('cp-', '', $cpwidget5236_shortcode_name);
        global $cpwidget5236_options, $cpwidget5236_styleSheetCdn, $cpwidget5236_scriptCdn;

        // Check either App code is defined
        if (!isset($cpwidget5236_options['app_code'])) return '<p>App code is not defined yet please setup CharterPad widget plugin.</p>';
        // Check if enabled
        if (isset($cpwidget5236_options[$cpwidget5236_widget . '_enabled']) && $cpwidget5236_options[$cpwidget5236_widget . '_enabled'] == 0) return false;

        if (isset($cpwidget5236_options['type']) && $cpwidget5236_options['type'] == 'advanced') {
            cpwidget5236_get_charterpad_widget_tag($cpwidget5236_widget);
        } else {
            $cpwidget5236_style = cpwidget5236_attrtag('link', "href='" . $cpwidget5236_styleSheetCdn . "' rel='stylesheet'");
            $cpwidget5236_script = cpwidget5236_attrtag('script', "src='" . $cpwidget5236_scriptCdn . "' type='text/javascript'", ' ');

            $cpwidget5236_head = cpwidget5236_attrtag('head', '', cpwidget5236_attrtag('meta', ['charset' => 'utf-8']) . cpwidget5236_attrtag("meta", "http-equiv='X-UA-Compatible' content='IE=edge'") . cpwidget5236_attrtag("meta", "name='viewport' content='width=device-width,initial-scale=1'"));
            $cpwidget5236_cpTag = str_replace('"', "'", cpwidget5236_get_charterpad_widget_tag($cpwidget5236_widget, false));
            $cpwidget5236_body = (cpwidget5236_attrtag('body', "style='margin: 0px'",  $cpwidget5236_style . $cpwidget5236_cpTag . $cpwidget5236_script));

            $cpwidget5236_iframeAttrs = [
                "id" => "charterpad-iframe-" . $cpwidget5236_widget,
                "onload" => "cpwidgetResizeIFrameToFitContent(this)",
                "frameborder" => "0",
                "scrolling" => "no",
                "style" => "border:none;width:100%;overflow:visible;", // don't add any space in the values
            ];
        ?>
            <iframe <?php foreach ($cpwidget5236_iframeAttrs as $cpwidget5236_attrkey => $cpwidget5236_attrVal) {
                        echo esc_attr(' ' . $cpwidget5236_attrkey . '=' . $cpwidget5236_attrVal);
                    } ?> src="javascript: window.frameElement.getAttribute('srcdoc')" srcdoc="<?php echo esc_attr($cpwidget5236_head . $cpwidget5236_body); ?>" sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-presentation allow-top-navigation">
            </iframe>

        <?php
        }
        return ob_get_clean();
    }
}
if (!function_exists('cpwidget5236_get_charterpad_widget_tag')) {
    function cpwidget5236_get_charterpad_widget_tag($cpwidget5236_widget, $cpwidget5236_printTag = true)
    {
        global $cpwidget5236_options;

        $cpwidget5236_attributes = [
            "app-code" => $cpwidget5236_options['app_code'],
            "app-widget" => $cpwidget5236_widget,
            "hide-footer" => (isset($cpwidget5236_options['hide_footer_section']) && $cpwidget5236_options['hide_footer_section'] == 1) ? 'true' : 'false',
            "app-theme-primary" => $cpwidget5236_options['primary_color'],
            "app-theme-secondary" => $cpwidget5236_options['secondary_color'],
            "app-theme" => isset($cpwidget5236_options['theme']) ? $cpwidget5236_options['theme'] : 'light'
        ];

        if ($cpwidget5236_widget == 'availability') {
            $cpwidget5236_widget_types = [];
            if (isset($cpwidget5236_options['empty_leg'])) array_push($cpwidget5236_widget_types, 'empty-leg');
            if (isset($cpwidget5236_options['one_way'])) array_push($cpwidget5236_widget_types, 'one-way');
            if (isset($cpwidget5236_options['round_trip'])) array_push($cpwidget5236_widget_types, 'round-trip');

            if (count($cpwidget5236_widget_types)) $cpwidget5236_attributes['app-widget-types'] = implode(',', $cpwidget5236_widget_types);
        }
        if (!$cpwidget5236_printTag) {
            return cpwidget5236_attrtag('charterpad-widget', $cpwidget5236_attributes, ' ');
        } else {
        ?>
            <charterpad-widget <?php foreach ($cpwidget5236_attributes as $cpwidget5236_attrKey => $cpwidget5236_attrVal) {
                                    echo esc_attr(' ' . $cpwidget5236_attrKey . '=' . $cpwidget5236_attrVal);
                                } ?>></charterpad-widget>
<?php
        }
    }
}
