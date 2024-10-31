<?php
/**
 * PrintKK connect.
 *
 * @var string $text
 * @var string $connectUrl
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="printkk_connect_box">
    <div class="printkk-base-box">
        <img src="<?php echo esc_url( printkk_admin_image_url().'logo.png' ); ?>" alt="PrintKk" class="printkk-logo">
    </div>
    <div class="printkk_connect_content">
        <img src="<?php echo esc_url( printkk_admin_image_url().'connect.png' )?>" class="printkk_connect-img">
        <a href="<?php echo esc_url($connectUrl) ?>" target="_blank" class="printkk_connect_btn""> <?php echo esc_html($text); ?> </a>
    </div>
</div>
