<?php
/**
 * WP Robots Txt
 *
 * Copyright 2013 Christopher Davis <http://christopherdavis.me>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category    WordPress
 * @package     WPRobotsTxt
 * @copyright   2013 Christopher Davis
 * @license     http://opensource.org/licenses/GPL-2.0 GPL-2.0+
 */

/**
 * Wrapper for all our admin area functionality.
 * 
 * @since 0.1
 */
class CD_RDTE_Admin_Page
{
    private static $ins = null;

    protected $setting = 'cd_rdte_content';

    public static function instance()
    {
        if (null === self::$ins) {
            self::$ins = new self();
        }

        return self::$ins;
    }

    /**
     * Kick everything off.
     * 
     * @since   1.0
     * @access  public
     * @uses    add_action
     * @return  void
     */
    public static function init()
    {
        add_action('admin_init', array(self::instance(), 'settings'));
    }
    
    /**
     * Registers our setting and takes care of adding the settings field
     * we need to edit our robots.txt file
     * 
     * @since   1.0
     * @access  public
     * @uses    register_setting
     * @uses    add_settings_field
     * @return  void
     */
    public function settings()
    {
        register_setting(
            'reading', 
            $this->setting,
            array($this, 'cleanSetting')
        );

        add_settings_section(
            'robots-txt',
            __('Robots.txt Settings', 'wp-robots-txt'),
            '__return_false',
            'reading'
        );

        add_settings_field(
            'cd_rdte_robots_content',
            __('Robots.txt Content', 'wp-robots-txt'),
            array($this, 'field'),
            'reading',
            'robots-txt',
            array('label_for' => $this->setting)
        );
    }

    /**
     * Callback for the settings field.
     * 
     * @since   1.0
     * @access  public
     * @uses    get_option
     * @uses    esc_attr
     * @return  void
     */
    public function field()
    {
         $public = get_option('blog_public');
         $notpublicmsg = 'Not using the settings above. Using deault as shown below. Uncheck the Discourage checkbox above to use the settings. Make sure you do not have a physical robots.txt in your web root.';
         $bottom_message =  '';
         
         $content = get_option($this->setting);
         if ($content) {
             if ($public) {
                 $bottom_message .=  'The content of your robots.txt file.  Clear contents above and save to restore the default.';
             } else {
                 $bottom_message .= $notpublicmsg;
             }
         } else {
             $content = $this->getDefaultRobots();
             $bottom_message .= '<label style="color:#f00;font-weight:bold">';
             if ($public) {
                 $bottom_message .= 'You must Save Changes to make sure overrides above are taken.';
             } else {
                 $bottom_message .= $notpublicmsg;
             }
             $bottom_message .= '</label>';
         }
         $bottom_message .= '<div><iframe src="/robots.txt" height="120px"></iframe></div>';

         printf(
             '<textarea name="%1$s" id="%1$s" rows="10" class="large-text">%2$s</textarea>',
             esc_attr($this->setting),
             esc_textarea($content)
         );

         echo '<p class="description">';
         _e($bottom_message , 'wp-robots-txt');
         echo '</p>';
    }

    /**
     * Strips tags and escapes any html entities that goes into the 
     * robots.txt field
     * 
     * @since 1.0
     * @uses esc_html
     * @uses add_settings_error
     */
    public function cleanSetting($in)
    {
        if(empty($in)) {
            // TODO: why does this kill the default settings message?
            add_settings_error(
                $this->setting,
                'cd-rdte-restored',
                __('Robots.txt restored to default.', 'wp-robots-txt'),
                'updated'
            );
        }

        return esc_html(strip_tags($in));
    }
    
    /**
     * Get the default robots.txt content.  This is copied straight from
     * WP's `do_robots` function
     * 
     * @since   1.0
     * @access  protected
     * @uses    get_option
     * @return  string The default robots.txt content
     */
    protected function getDefaultRobots()
    {
        $public = get_option('blog_public');

        $output = "User-agent: *\n";
        if (!$public) {
            $output .= "Disallow: /\n";
        } else {
            $path = parse_url(site_url(), PHP_URL_PATH);
             $output .= "Disallow: $path/wp-admin/\n";
            $output .= "Disallow: $path/wp-includes/\n";

            $contentpath = parse_url(content_url(), PHP_URL_PATH); // parse_url(WP_CONTENT_URL, PHP_URL_PATH);
            if ($contentpath !== $path .'/wp-content/')
                $output .= "Disallow: $path/wp-content/\n";
            if ($contentpath !== '')
                $output .= "Disallow: $contentpath/\n";
           if (get_option('upload_url_path')) {
                $mediapath = parse_url(get_option('upload_url_path'), PHP_URL_PATH);
                $output .= "Allow: $mediapath/\n";
            }
        }

        return $output;
    }
}
