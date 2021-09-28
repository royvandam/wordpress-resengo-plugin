<?php
/**
 * Plugin Name: Resengo Widget
 * Plugin URI:
 * Description:  Resengo Widget
 * Version:     1.1.2
 * Author:      Hassan Ali
 * Author URI:  https://hassanali.pro
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: resengo_widget
 */

if (!class_exists('resengo_widget')) {

    class resengo_widget
    {
        public $plugin_name = "";

        public function __construct()
        {
            $this->plugin_name = "resengo-widget";

            add_action('admin_menu', array($this, 'resengo_widget_admin_menu'));
            add_action('wp_footer', array($this, 'resengo_widget_js'));
            add_action('admin_notices', array($this, 'resengo_missing_id_setting'));
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'resengo_widget_settings_link'));
        }

        public function resengo_widget_settings_link($links)
        {
            $links[] = '<a href="' .
            admin_url('options-general.php?page=resengo-widget-options') .
            '">' . __('Settings', $this->plugin_name) . '</a>';
            return $links;
        }
        public function resengo_widget_admin_menu()
        {
            add_options_page(__('Resengo Widget', $this->plugin_name), __('Resengo Widget', $this->plugin_name), 'manage_options', 'resengo-widget-options', array($this, 'resengo_widget_option'));
        }
        public function resengo_widget_option()
        {
            $data = [];
            if (isset($_POST['resengo_submit'])) {
                $data['resengo_company_id'] = (isset($_POST['resengo_company_id']) ? sanitize_text_field($_POST['resengo_company_id']) : '');
                $data['resengo_language'] = (isset($_POST['resengo_language']) ? sanitize_text_field($_POST['resengo_language']) : '');
                foreach ($data as $key => $value) {
                    update_option($key, $value);
                }
            }
            ob_start();
            include_once 'admin/resengo_widget_backend.php';
            $content = ob_get_clean();
            echo $content;
        }
        public function resengo_missing_id_setting($data)
        {
            if ('' == get_option('resengo_company_id')) {
                printf('<div class="notice-warning settings-error notice is-dismissible"><p>%s</p></div>', __("Company ID is required please add it here", $this->plugin_name) . " <a href='" . admin_url('options-general.php?page=resengo-widget-options') . "'>" . __("Setting", $this->plugin_name) . "</a>");
            }
        }

        public function resengo_widget_js()
        {
            $resengo_company_id = get_option("resengo_company_id");
            $resengo_language = get_option("resengo_language");

            if ($resengo_company_id == "") {
                return;
            }

            if ($resengo_language == "LOCALE") {
                $locale = get_locale();
                $resengo_language = strtoupper(explode('_', $locale)[0]);
            }

            ob_start();
            ?>
            <script type="text/javascript">
                window.resengoWidgetOptions = {
                    companyId: '<?php echo $resengo_company_id; ?>',
                    language: '<?php echo $resengo_language; ?>' };
                (function(){var f=function(a,b,c,d){if(!a.getElementById(c)){var e=a.getElementsByTagName(b)[0];a=a.createElement(b);a.id=c;a.src="https://resengocomgeneralpurpose.blob.core.windows.net/						resengowidget/resengo-widget.base.js";d&&(a.onload=d);e.parentNode.insertBefore(a,e)}},b=function(){return f(document,"script","resengo-flow-widget-script",function()										{RESENGO_WIDGET(window.resengoWidgetOptions)})};window.attachEvent?window.attachEvent("onload",b):window.addEventListener("load",b,!1)})();
            </script>
            <?php
            echo ob_get_clean();
        }
    }

    if (!function_exists('deactivate_resengo_widget')) {
        register_uninstall_hook(__FILE__, 'deactivate_resengo_widget');
        function deactivate_resengo_widget()
        {
            $data = ['resengo_company_id', 'resengo_language'];
            foreach ($data as $value) {
                delete_option($value);
            }
        }
    }

    $resengo_widget = new resengo_widget();
}
