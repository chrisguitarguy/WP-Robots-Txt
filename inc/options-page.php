<?php
/**
 * Wrapper for all our admin area functionality.
 * 
 * @since 0.1
 */
class CD_RDTE_Admin_Page
{
    protected $setting = 'cd_rdte_content';
    
    /**
     * Constructor. Adds an action to `admin_init`
     * 
     * @since 1.0
     * @uses add_action
     */
    function __construct()
    {
        add_action( 'admin_init', array( &$this, 'settings' ) );
    }
    
    /**
     * Registers our setting and takes care of adding the settings field
     * we need to edit our robots.txt file
     * 
     * @since 1.0
     * @uses register_setting
     * @uses add_settings_field
     */
    function settings()
    {
        register_setting(
            'privacy', 
            $this->setting,
            array( &$this, 'clean_setting' )
        );
        
        add_settings_field(
            'cd_rdte_robots_content',
            __( 'Robots.txt Content', 'wp-robots-txt' ),
            array( &$this, 'field' ),
            'privacy',
            'default',
            array( 'lable_for' => 'cd_crte_text' )
        );
    }
    
    /**
     * Callback for the settings field. 
     * 
     * @since 1.0
     * @uses get_option
     * @uses esc_attr
     */
    function field()
    {
        $content = get_option( $this->setting );
        if( ! $content ) $content = $this->get_default_robots();
        ?>
        <textarea name="<?php echo esc_attr( $this->setting ); ?>" id="cd_cdte_text" rows="10" cols="50" style="width:97%"><?php echo esc_html( $content ); ?></textarea>
        <p class="description">
            <?php _e( 'The content of your robots.txt file.  Delete the above and save to restore the default.', 'wp-robots-txt' ); ?>
        </p>
        <?php
    }
    
    /**
     * Strips tags and escapes any html entities that goes into the 
     * robots.txt field
     * 
     * @since 1.0
     * @uses esc_html
     * @uses add_settings_error
     */
    function clean_setting( $in )
    {
        if( empty( $in ) )
        {
            // TODO: why does this kill the default settings message?
            add_settings_error(
                $this->setting,
                'cd-rdte-restored',
                __( 'Robots.txt restored to default.', 'wp-robots-txt' ),
                'updated'
            );
        }
        return esc_html( strip_tags( $in ) );
    }
    
    /**
     * Get the default robots.txt content.  This is copied straight from
     * WP's `do_robots` function
     * 
     * @since 1.0
     * @uses get_option
     * @return string The default robots.txt content
     */
    function get_default_robots()
    {
        $output = "User-agent: *\n";
        $public = get_option( 'blog_public' );
        if ( '0' == $public ) 
        {
            $output .= "Disallow: /\n";
        } 
        else 
        {
            $site_url = parse_url( site_url() );
            $path = ( !empty( $site_url['path'] ) ) ? $site_url['path'] : '';
            $output .= "Disallow: $path/wp-admin/\n";
            $output .= "Disallow: $path/wp-includes/\n";
        }
        return $output;
    }
}

new CD_RDTE_Admin_Page();
