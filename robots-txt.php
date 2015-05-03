<?php
/**
 * Plugin Name: WP Robots Txt
 * Plugin URI: https://github.com/chrisguitarguy/WP-Robots-Txt
 * Description: Edit your robots.txt file from the WordPress admin
 * Version: 1.2
 * Text Domain: wp-robots-txt
 * Author: Christopher Davis
 * Author URI: http://christopherdavis.me
 * License: MIT
 *
 * Copyright (c) 2015 Christopher Davis <http://christopherdavis.me>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * @category    WordPress
 * @author      Christopher Davis <http://christopherdavis.me>
 * @copyright   2015 Christopher Davis
 * @license     http://opensource.org/licenses/MIT MIT
 */

!defined('ABSPATH') && exit;

define('WP_ROBOTS_TXT_DIR', plugin_dir_path(__FILE__));
define('WP_ROBOTS_TXT_NAME', plugin_basename(__FILE__));

require_once WP_ROBOTS_TXT_DIR . 'inc/core.php';
if (is_admin()) {
    require_once WP_ROBOTS_TXT_DIR . 'inc/options-page.php';
    CD_RDTE_Admin_Page::init();
}

add_filter('robots_txt', 'cd_rdte_filter_robots', 10, 2);
register_activation_hook(__FILE__, 'cd_rdte_activation');
register_deactivation_hook(__FILE__, 'cd_rdte_deactivation');
