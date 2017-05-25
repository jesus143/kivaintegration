<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function kiva_box($postType) {



            add_meta_box( 'kiva-box', __( 'Kiva Information', 'kivauk' ),  'kiva_metabox_display', array('kivauk'));
            //add_meta_box( 'metabox', __( 'Advertisement Type', 'pdftpl2' ),  'pdftpl2_advertisement_size', array('pdfcr-advertisement'), 'side', 'high');

}

function kiva_metabox_display() {
    global $post;
    $loan_id =  get_post_meta($post->ID,'loan_id',true);
?>
<input type="hidden" name="kiva_noncename" id="kiva_noncename" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ) ?>" />
<table>
    <tr>
        <td>
            <label for="pdftpl2_new_field"><?php echo __("Loaner Id:", 'kivauk' ) ?></label>
        </td>
        <td>

            <input type="text" name="loan_id" value="<?php echo $loan_id ; ?>" />
        </td>
    </tr>
    <tr><td colspan="2"><br></td></tr>
</table>
<?php

}


function kiva_onsave( $post_id ) {

    if ( !wp_verify_nonce( sanitize_text_field($_POST['kiva_noncename']), plugin_basename(__FILE__) )) {
        return $post_id;
    }

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if ( 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) )
             return $post_id;
    } else {
        if ( !current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }

    if ( $parent_id = wp_is_post_revision($post_id) )
    {
        $post_id = $parent_id;
    }

    if (!get_post_meta($post_id, "loan_id")) {
        add_post_meta($post_id, "loan_id", sanitize_text_field($_POST["loan_id"]));
    }else{
        update_post_meta($post_id, "loan_id", sanitize_text_field($_POST["loan_id"]));
    }
    if ($_POST["loan_id"] == "") {
          delete_post_meta($post_id, "loan_id");
    }


}


